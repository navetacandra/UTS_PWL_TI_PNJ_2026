<?php

$uri = parse_url($_SERVER['REQUEST_URI']);
$base = trim(dirname($_SERVER['SCRIPT_NAME']));
$path = rtrim($uri['path'], "/");

if($_SERVER['SCRIPT_NAME'] == "/index.php" && $path == "") {
    $path .= "/login"; // default page
}

if(PHP_SAPI == 'cli-server') {
    define("BASE_URL", "");
    $target = rtrim(getcwd() . $path, '/');

    if(is_file($target)) { // static file
        return false;
    }
} else {
    define("BASE_URL", $base);
    $target = rtrim(getcwd() . substr($path, strlen($base)), '/');
}

if(is_file($target . '.php')) { // php exist
    $target .= '.php';
} else if(!is_file($target)) { // index.php on dir
    $target .= "/index.php";
}

if(!file_exists($target)) {
    $error_code = 404;
    $error_status = "NOT_FOUND";
    $error_message = "The link may be outdated, or the page might have been moved or deleted. Try the dashboard to get back on track.";
    require_once __DIR__ . '/error_response.php';
    die();
}

require_once __DIR__ . '/lib/database.php';
require_once __DIR__ . '/lib/utils.php';
require_once $target;
