<?php
require_once '../vendor/autoload.php';

use App\Controller\HomeController;
use App\Controller\PostController;
use App\Application\HTTPRequest;

try {
    $action = "show";
    $page = "home";
    $httpRequest = new HTTPRequest();

    if ($httpRequest->requestURI() === "/"){
        $controller = new HomeController($action, $page, $httpRequest);
        $controller->execute();
    }

    if($httpRequest->getExists('page')){
            switch ($httpRequest->getData('page')){
            case 'post':
            $page = 'post';
                $controller = new PostController($action, $page, $httpRequest);
                $controller-> execute();
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
