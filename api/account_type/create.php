<?php

if (!authenticated()) {
    die();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $error_code = 405;
    $error_status = "METHOD_NOT_ALLOWED";
    $error_message = "The action you're trying to perform isn't allowed on this page. Double-check your submission, or return to the dashboard to try again.";
    require_once __DIR__ . '/../../error_response.php';
    die();
}

$errors = [];
$name = $_POST["name"];
$description = $_POST["description"];

if (!isset($name)) {
    $errors["name"] = "Name is required!";
} elseif (!is_string($name)) {
    $errors["name"] = "Name must be string!";
} elseif (strlen($name) < 1) {
    $errors["name"] = "Name is required!";
} elseif (strlen($name) > 128) {
    $errors["name"] = "Name max length is 128 char!";
}

if (!isset($description)) {
    $errors["description"] = "Description is required!";
} elseif (!is_string($description)) {
    $errors["description"] = "Description must be string!";
} elseif (strlen($description) < 1) {
    $errors["description"] = "Description is required!";
}

header("Content-Type: application/json");
if (count($errors) > 0) {
    http_response_code(400);
    echo json_encode(["status" => 400, "error" => $errors]);
    die();
}

try {
    $stmt = $conn->prepare(
        "INSERT INTO account_type (name, description) VALUES (?, ?) RETURNING id, name, description, created_at, updated_at;",
    );
    $stmt->execute([$name, $description]);

    http_response_code(201);
    echo json_encode([
        "status" => 201,
        "message" => "Account type added.",
        "data" => $stmt->fetch(PDO::FETCH_ASSOC),
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => 500,
        "message" => $e->getMessage(),
    ]);
}
