<?php

if (!authenticated()) {
    die();
}

if (
    ($_SERVER["REQUEST_METHOD"] != "POST" && !isset($_POST["_method"])) ||
    $_POST["_method"] != "PUT"
) {
    $error_code = 405;
    $error_status = "METHOD_NOT_ALLOWED";
    $error_message = "The action you're trying to perform isn't allowed on this page. Double-check your submission, or return to the dashboard to try again.";
    require_once __DIR__ . '/../../error_response.php';
    die();
}

$errors = [];
$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$account_type_id = $_POST['account_type_id'];
$status = $_POST['status'];
$identification_number = $_POST['identification_number'];
$identification_type = $_POST['identification_type'];

if (!isset($id)) {
    $errors["id"] = "ID is required!";
} elseif (!is_string($id)) {
    $errors["id"] = "ID must be string!";
} elseif (strlen($id) < 1) {
    $errors["id"] = "ID is required!";
} elseif (preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/', $id) != 1) {
    $errors["id"] = "ID must be valid UUID!";
}

if (!isset($name)) {
    $errors["name"] = "Name is required!";
} else if (!is_string($name)) {
    $errors["name"] = "Name must be string!";
} else if (strlen($name) < 1) {
    $errors["name"] = "Name is required!";
} else if (strlen($name) > 128) {
    $errors["name"] = "Name max length is 128 char!";
}

if (!isset($email)) {
    $errors["email"] = "Email is required!";
} else if (!is_string($email)) {
    $errors["email"] = "Email must be string!";
} else if (strlen($email) < 1) {
    $errors["email"] = "Email is required!";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "Email must be valid email!";
}

if (isset($password)) {
    if (!is_string($password)) {
        $errors["password"] = "Password must be string!";
    } else if (strlen($password) > 0 && strlen($password) < 8) {
        $errors["password"] = "Password min length is 8 char!";
    }
}

if (!isset($status)) {
    $errors["status"] = "Status is required!";
} else if (!is_string($status)) {
    $errors["status"] = "Status must be string!";
} else if (strlen($status) < 1) {
    $errors["status"] = "Status is required!";
} else if (strlen($status) > 128) {
    $errors["status"] = "Status max length is 128 char!";
}

if (!isset($identification_number)) {
    $errors["identification_number"] = "ID Number is required!";
} else if (!is_string($identification_number)) {
    $errors["identification_number"] = "ID Number must be string!";
} else if (strlen($identification_number) < 1) {
    $errors["identification_number"] = "ID Number is required!";
} else if (strlen($identification_number) > 128) {
    $errors["identification_number"] = "ID Number max length is 128 char!";
} else if (preg_match('/^\d+$/', $identification_number) != 1) {
    $errors["identification_number"] = "ID Number must be number!";
}

if (!isset($identification_type)) {
    $errors["identification_type"] = "ID Type is required!";
} else if (!is_string($identification_type)) {
    $errors["identification_type"] = "ID Type must be string!";
} else if (strlen($identification_type) < 1) {
    $errors["identification_type"] = "ID Type is required!";
} else if (!in_array($identification_type, ["NIM", "NIP"])) {
    $errors["identification_type"] = "ID Type is required!";
}

if (!isset($account_type_id)) {
    $errors["account_type_id"] = "ID Account Type is required!";
} else if (!is_string($account_type_id)) {
    $errors["account_type_id"] = "ID Account Type must be string!";
} else if (strlen($account_type_id) < 1) {
    $errors["account_type_id"] = "ID Account Type is required!";
} else if (preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/', $account_type_id) != 1) {
    $errors["account_type_id"] = "ID Account Type must be valid UUID!";
}

header("Content-Type: application/json");
if (count($errors) > 0) {
    http_response_code(400);
    echo json_encode(["status" => 400, "error" => $errors]);
    die();
}

$stmt_check = $conn->prepare(
    "SELECT * FROM accounts WHERE deleted_at IS NULL AND id=?;",
);
$stmt_check->execute([$id]);
if (!$stmt_check->fetch()) {
    http_response_code(400);
    echo json_encode([
        "status" => 400,
        "error" => ["id" => "ID is not registered!"],
    ]);
    die();
}

$stmt_check_actype = $conn->prepare(
    "SELECT * FROM account_type WHERE deleted_at IS NULL AND id=?;",
);
$stmt_check_actype->execute([$account_type_id]);
if (!$stmt_check_actype->fetch()) {
    http_response_code(400);
    echo json_encode([
        "status" => 400,
        "error" => ["account_type_id" => "ID Account Type is not registered!"],
    ]);
    die();
}

try {
    $stmt = $conn->prepare(
        strlen($password) >= 8
            ? "UPDATE accounts SET name=?, email=?, password=?, account_type_id=?, status=?, identification_number=?, identification_type=?, updated_at=CURRENT_TIMESTAMP WHERE deleted_at IS NULL AND id=?;"
            : "UPDATE accounts SET name=?, email=?, account_type_id=?, status=?, identification_number=?, identification_type=?, updated_at=CURRENT_TIMESTAMP WHERE deleted_at IS NULL AND id=?;"
    );
    $stmt->execute(
        strlen($password) >= 8
            ? [$name, $email, password_hash($password, PASSWORD_BCRYPT), $account_type_id, $status, $identification_number, $identification_type, $id]
            : [$name, $email, $account_type_id, $status, $identification_number, $identification_type, $id]
    );

    http_response_code(200);
    echo json_encode([
        "status" => 200,
        "message" => "Account updated.",
    ]);
} catch (PDOException $e) {
    $message = $e->getMessage();

    if(str_contains($message, "unique_account_type")) {
        http_response_code(400);
        echo json_encode([
            "status" => 400,
            "message" => "Account type already taken by another user.",
        ]);
        die();
    }

    http_response_code(500);
    echo json_encode([
        "status" => 500,
        "message" => $message,
    ]);
}
