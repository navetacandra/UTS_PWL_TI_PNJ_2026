<?php

session_start();

function gen_csrf_token() {
   $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function verify_csrf_token() {
    if(!isset($_REQUEST['csrf_token']) || ($_REQUEST['csrf_token'] != $_SESSION['csrf_token'])) {
        http_response_code(403);
        header("Content-Type: application/json");
        echo json_encode([
            "status" => 403,
            "message" => "Invalid CSRF token."
        ]);

        return false;
    }

    return true;
}

function filter_request()
{
    foreach (array_keys($_GET) as $k) {
        $_GET[$k] = htmlspecialchars(trim($_GET[$k]));
    }

    foreach (array_keys($_POST) as $k) {
        $_POST[$k] = htmlspecialchars(trim($_POST[$k]));
    }
}

function authenticated(string $redirect = "")
{
    if (!isset($_SESSION["user"])) {
        if (strlen($redirect) > 0) {
            header("Location: $redirect");
        } else {
            http_response_code(401);
            header("Content-Type: application/json");
            echo json_encode([
                "status" => 401,
                "message" => "Authenticated user only.",
            ]);
        }
        return false;
    }
    return true;
}

function unauthenticated(string $redirect = "")
{
    if (isset($_SESSION["user"])) {
        if (strlen($redirect) > 0) {
            header("Location: $redirect");
        } else {
            http_response_code(401);
            header("Content-Type: application/json");
            echo json_encode([
                "status" => 401,
                "message" => "Unauthenticated user only.",
            ]);
        }
        return false;
    }
    return true;
}

filter_request();
