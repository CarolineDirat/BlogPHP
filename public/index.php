<?php
require_once '../vendor/autoload.php';
require_once '../config/config.php';

use App\Controller\HomeController;
use App\Controller\PostController;
use App\Application\HTTPRequest;
use App\Application\HTTPResponse;
use App\Application\TwigRenderer;

try {
    $action = "show";
    $page = "home";
    $httpRequest = new HTTPRequest();
    $twigRenderer = new TwigRenderer('../templates');

    if ($httpRequest->requestURI() === "/") {
        $controller = new HomeController($action, $page, $httpRequest);
        $httpResponse = $controller->execute();
        echo $twigRenderer->render($httpResponse->getPage(), $httpResponse->getParams());
    }

    if ($httpRequest->hasGET('page')) {
        switch ($httpRequest->getData('page')) {
            case 'post':
            $page = 'post';
                $controller = new PostController($action, $page, $httpRequest);
                $httpResponse = $controller->execute();
                echo $twigRenderer->render($httpResponse->getPage(), $httpResponse->getParams());
            break;
        }
    } else {
        throw new \Exception('Auccune page ne correspond à celle demandée');
    }

    /*
    switch ($httpRequest->requestURI()) {
        case "/":
            $controller = new HomeController($action, $view, $httpRequest);
            $controller->execute();
            break;


        default:
            $controller = new HomeController($action, $view, $httpRequest);
            $controller->execute();
    }
    */
} catch (Exception $e) {
    echo $e->getMessage();
}
