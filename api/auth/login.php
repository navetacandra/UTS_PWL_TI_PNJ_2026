<?php

if (!unauthenticated() || !verify_csrf_token()) {
    die();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $error_code = 405;
    $error_status = "METHOD_NOT_ALLOWED";
    $error_message = "The action you're trying to perform isn't allowed on this page. Double-check your submission, or return to the dashboard to try again.";
    require_once __DIR__ . '/../../error_response.php';
    die();
}

$email = $_POST["email"];
$password = $_POST["password"];

if (!isset($email)) {
    $errors["email"] = "Email is required!";
} else if (!is_string($email)) {
    $errors["email"] = "Email must be string!";
} else if (strlen($email) < 1) {
    $errors["email"] = "Email is required!";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "Email must be valid email!";
}

if (!isset($password)) {
    $errors["password"] = "Password is required!";
} else if (!is_string($password)) {
    $errors["password"] = "Password must be string!";
} else if (strlen($password) < 1) {
    $errors["password"] = "Password is required!";
} else if (strlen($password) < 8) {
    $errors["password"] = "Password min length is 8 char!";
}

$stmt = $conn->prepare("SELECT a.*, at.name AS account_type_name FROM accounts a JOIN account_type at ON at.id=a.account_type_id WHERE a.deleted_at IS NULL AND email=? LIMIT 1;");
$stmt->execute([$email]);
$acc = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$acc) {
    http_response_code(400);
    echo json_encode([
        "status" => 400,
        "message" => "Invalid credential."
    ]);
    die();
}

if(!password_verify($password, $acc['password'])) {
    http_response_code(400);
    echo json_encode([
        "status" => 400,
        "message" => "Invalid credential."
    ]);
    die();
}

unset($acc['password']);
$_SESSION['user'] = $acc;
echo json_encode([
    "status" => 200,
    "message" => "Login succeed"
]);
