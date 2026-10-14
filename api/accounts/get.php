<?php

if (!authenticated()) {
    die();
}

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    $error_code = 405;
    $error_status = "METHOD_NOT_ALLOWED";
    $error_message = "The action you're trying to perform isn't allowed on this page. Double-check your submission, or return to the dashboard to try again.";
    require_once __DIR__ . '/../../error_response.php';
    return;
}

$id = $_GET['id'];
$stmt = $conn->prepare(
    isset($id)
        ? "SELECT a.id, a.name, a.email, a.account_type_id, a.status, a.identification_number, a.identification_type, a.created_at, a.updated_at, at.name AS account_type_name FROM accounts a JOIN account_type at ON at.id=a.account_type_id WHERE a.deleted_at IS NULL AND a.id=?;"
        : "SELECT a.id, a.name, a.email, a.account_type_id, a.status, a.identification_number, a.identification_type, a.created_at, a.updated_at, at.name AS account_type_name FROM accounts a JOIN account_type at ON at.id=a.account_type_id WHERE a.deleted_at IS NULL;"
 );
$stmt->execute(isset($id) ? [$id] : []);

header("Content-Type: application/json");
echo json_encode([
    "status" => 200,
    "data" => $stmt->fetchAll(PDO::FETCH_ASSOC),
]);
