<?php
require_once __DIR__ . '../vendor/autoload.php';

use App\Controller\HomeController;
use App\Application\HTTPRequest;

$title = "";

try {
    $httpRequest = new HTTPRequest();
    switch ($httpRequest->requestURI()) {
        case "/":
            $title = "Page d'accueil";
            $action = "show";
            $module = "home";
            $controller = new HomeController($action, $module, $httpRequest);
            $controller->execute();

        break;

        default:
            $title = "Page d'accueil";
            $action = "show";
            $module = "home";
            $controller = new HomeController($action, $module, $httpRequest);
            $controller->execute();
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
