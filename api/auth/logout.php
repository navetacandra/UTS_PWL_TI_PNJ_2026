<?php

session_destroy();
header("Content-Type: application/json");
echo json_encode([
    "status" => 200,
    "message" => "Logout succeed"
]);

header("Location: " . BASE_URL . "/login");
