<?php
require_once '../vendor/autoload.php';
require_once '../config/config.php';

use App\Controller\HomeController;
use App\Controller\PostController;
use App\Application\HTTPRequest;
use App\Application\HTTPResponse;
use App\Application\TwigRenderer;

try {
    $match = false; // will be true if the rooter receive a route corresponding to a controller
    $action = "show";
    $page = "home";
    $httpRequest = new HTTPRequest();
    $twigRenderer = new TwigRenderer('../templates');
    
    if ($httpRequest->requestURI() === "/") {
        $match = true;
        $controller = new HomeController($action, $page, $httpRequest);
        $controller->execute()->send($twigRenderer);
    } 

    if ($httpRequest->hasGET('page')) {
        $page =$httpRequest->getData('page');
        switch ($page) {
            case 'post':
                $match = true;
                $controller = new PostController($action, $page, $httpRequest);
                $controller->execute()->send($twigRenderer);
            break;
            case 'blog':
                $match = true;
                $controller = new PostController($action, $page, $httpRequest);
                $controller->execute()->send($twigRenderer);
            break;
            case 'contact':
                if($httpRequest->method() === 'POST'){
                    $match = true;
                    $action = 'process';
                    $controller = new HomeController($action, $page, $httpRequest);
                    $controller->execute()->send($twigRenderer);
                }
            break;
        }
    }    
    if(!$match) {
        throw new \Exception('No page corresponds to that requested');
    }
    
} catch (Exception $e) {
    $twigRenderer = new TwigRenderer('../templates');
    $twigRenderer->render('error', ['error' => $e->getMessage()]);
}
