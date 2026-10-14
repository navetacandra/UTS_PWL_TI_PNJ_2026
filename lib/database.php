<?php

$host = "localhost:3306";
$dbname = "PBL_TI_2025_B_NavetaCandra";
$username = "root";
$password = "root";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

function gen_uuid() {
    $random_hex = bin2hex(random_bytes(16));
    $uuid_placeholder = "%s%s-%s-%s-%s-%s%s%s";

    return vsprintf($uuid_placeholder, str_split($random_hex, 4));
}
