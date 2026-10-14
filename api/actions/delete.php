<?php

if (!authenticated()) {
    die();
}

if (
    ($_SERVER["REQUEST_METHOD"] != "POST" && !isset($_POST["_method"])) ||
    $_POST["_method"] != "DELETE"
) {
    $error_code = 405;
    $error_status = "METHOD_NOT_ALLOWED";
    $error_message = "The action you're trying to perform isn't allowed on this page. Double-check your submission, or return to the dashboard to try again.";
    require_once __DIR__ . '/../../error_response.php';
    die();
}

$errors = [];
$id = $_REQUEST["id"];

if (!isset($id)) {
    $errors["id"] = "ID is required!";
} elseif (!is_string($id)) {
    $errors["id"] = "ID must be string!";
} elseif (strlen($id) < 1) {
    $errors["id"] = "ID is required!";
} elseif (preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/', $id) != 1) {
    $errors["id"] = "ID must be valid UUID!";
}

header("Content-Type: application/json");
if (count($errors) > 0) {
    http_response_code(400);
    echo json_encode(["status" => 400, "error" => $errors]);
    die();
}

$stmt_check = $conn->prepare(
    "SELECT * FROM actions WHERE deleted_at IS NULL AND id=?;",
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

try {
    $stmt = $conn->prepare(
        "UPDATE actions SET deleted_at=CURRENT_TIMESTAMP WHERE deleted_at IS NULL AND id=?;",
    );
    $stmt->execute([$id]);

    http_response_code(200);
    echo json_encode([
        "status" => 200,
        "message" => "Action deleted.",
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => 500,
        "message" => $e->getMessage(),
    ]);
}
