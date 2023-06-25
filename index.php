<?php
    declare(strict_types=1);

    spl_autoload_register(function ($class) {
        require __DIR__ . "/src/$class.php";
    });

    set_error_handler("ErrorHandler::handleError");
    set_exception_handler(("ErrorHandler::handleException"));

    header("Content-Type: application/json; charset=UTF-8");

    $parts = explode("/", $_SERVER["REQUEST_URI"]);

    if($parts[2] != "products") {
        http_response_code(404);
        exit;
    }
    $id = $parts[3] ?? null;

    $database = new Database("sql107.byethost5.com", "b5_34178224_product_db", "b5_34178224", "Long@12345");
    $database->getConnection();

    $gateway = new ProductGateway($database);

    $conreoller = new ProductController($gateway);

    $conreoller->processRequest($_SERVER['REQUEST_METHOD'], $id);
?>
