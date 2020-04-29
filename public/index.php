<?php
require_once '../vendor/autoload.php';

use App\Controller\HomeController;
use App\Application\HTTPRequest;


try {
    $httpRequest = new HTTPRequest();
    switch ($httpRequest->requestURI()) {
        case "/":
            $action = "show";
            $view = "home";
            $controller = new HomeController($action, $view, $httpRequest);
            $controller->execute();

        break;

        default:
            $title = "Page d'accueil";
            $action = "show";
            $view = "home";
            $controller = new HomeController($action, $view, $httpRequest);
            $controller->execute();
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
