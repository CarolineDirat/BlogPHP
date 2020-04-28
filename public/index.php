<?php
require_once '../vendor/autoload.php';

use App\Controller\HomeController;
use App\Application\HTTPRequest;


$title = "";
$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader, [
            'cache' => false, //'/path/to/compilation_cache',
            'debug' => true
            ]);


try{
    $httpRequest = new HTTPRequest();
    $uri = $httpRequest->requestURI(); 
    
    switch ($uri) {
        case "/":
            $title = "Page d'accueil";
            $action = "show";
            $module = "home";
            $controller = new HomeController($action,$module,$httpRequest,$twig);
            $controller->execute();

        break;

        default:
            $title = "Page d'accueil";
            $action = "show";
            $module = "home";
            $controller = new HomeController($action,$module,$httpRequest,$twig);
            $controller->execute();
    }

} catch(Exception $e){
    echo $e->getMessage();
}





//echo $twig->render('index.html', ['name' => 'Fabien']);
