<?php

if (!authenticated()) {
    die();
}

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    $error_code = 405;
    $error_status = "METHOD_NOT_ALLOWED";
    $error_message = "The action you're trying to perform isn't allowed on this page. Double-check your submission, or return to the dashboard to try again.";
    require_once __DIR__ . '/../../error_response.php';
    die();
}

$id = $_GET['id'];
$stmt = $conn->prepare(
    isset($id)
        ? "SELECT id, name, description, created_at, updated_at FROM account_type WHERE deleted_at IS NULL AND id=?;;"
        : "SELECT id, name, description, created_at, updated_at FROM account_type WHERE deleted_at IS NULL;"
);
$stmt->execute(isset($id) ? [$id] : []);

header("Content-Type: application/json");
echo json_encode([
    "status" => 200,
    "data" => $stmt->fetchAll(PDO::FETCH_ASSOC),
]);
