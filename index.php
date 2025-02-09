<?php
declare(strict_types=1);
spl_autoload_register(function ($class){
    require __DIR__ . "/src/$class.php";
});

set_error_handler('\ErrorHandler::handleError');
set_exception_handler('\ErrorHandler::handleException');
header("Content-type: application/json; charset=UTF-8");

$uri_parts = explode('/', $_SERVER['REQUEST_URI']);

if($uri_parts[2] != 'products'){
    echo '<pre>'.var_export("wrong params", true).'</pre>';
    http_response_code(404);
    exit;
}

$id = $uri_parts[3] ?? null;

$dbInfo = parse_ini_file("config/db.ini.php");

$database = new Database($dbInfo["host"], $dbInfo["dbname"], $dbInfo["user"], $dbInfo["pass"], $dbInfo["charset"]);
$gateway = new ProductGateway($database);
$controller = new ProductController($gateway);
$controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
