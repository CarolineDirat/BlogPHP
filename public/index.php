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
        echo $twigRenderer->render($httpResponse->getPage(),$httpResponse->getParams());
    }

    if ($httpRequest->hasGET('page')) {
        $page =$httpRequest->getData('page');
        switch ($page) {
            case 'post':
                $controller = new PostController($action, $page, $httpRequest);
                $httpResponse = $controller->execute();
                echo $twigRenderer->render($httpResponse->getPage(),$httpResponse->getParams());
            break;
            case 'blog':
                $controller = new PostController($action, $page, $httpRequest);
                $httpResponse = $controller->execute();
                echo $twigRenderer->render($httpResponse->getPage(),$httpResponse->getParams());
            break;
            case 'contact':
                if(isset($_POST)){
                    $action = 'process';
                    $controller = new HomeController($action, $page, $httpRequest);
                    $httpResponse = $controller->execute();
                    echo $twigRenderer->render($httpResponse->getPage(),$httpResponse->getParams());
                }
            break;
        }
    }
    throw new \Exception('No page corresponds to that requested');
} catch (Exception $e) {
    $twigRenderer = new TwigRenderer('../templates');
    echo $twigRenderer->render('error', ['error' => $e->getMessage()]);
}
