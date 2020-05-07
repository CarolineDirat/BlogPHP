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
        $controller->execute()->send($twigRenderer);
        ;
    }

    if ($httpRequest->hasGET('page')) {
        $page =$httpRequest->getData('page');
        switch ($page) {
            case 'post':
                $controller = new PostController($action, $page, $httpRequest);
                $controller->execute()->send($twigRenderer);
            break;
            case 'blog':
                $controller = new PostController($action, $page, $httpRequest);
                $controller->execute()->send($twigRenderer);
            break;
        }
    }

    throw new \Exception('Auccune page ne correspond à celle demandée');
} catch (Exception $e) {
    $twigRenderer = new TwigRenderer('../templates');
    $twigRenderer->render('error', ['error' => $e->getMessage()]);
}
