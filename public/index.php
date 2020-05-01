<?php
require_once '../vendor/autoload.php';

use App\Controller\HomeController;
use App\Application\HTTPRequest;

try {
    $action = "show";
    $view = "home";
    $httpRequest = new HTTPRequest();

    switch ($httpRequest->requestURI()) {
        case "/":
            $controller = new HomeController($action, $view, $httpRequest);
            $controller->execute();

        break;

        default:
            $title = "Page d'accueil";
            $controller = new HomeController($action, $view, $httpRequest);
            $controller->execute();
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
