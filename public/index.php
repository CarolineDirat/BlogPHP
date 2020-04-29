<?php
require_once '../vendor/autoload.php';

use App\Controller\HomeController;
use App\Application\HTTPRequest;

//require '../templates/index.html';
//exit;

$title = "";
//$loader = new \Twig\Loader\FilesystemLoader('/');
/*$twig = new \Twig\Environment($loader, [
            'cache' => false, //'/path/to/compilation_cache',
            'debug' => true
            ]);*/
//echo $twig->render('index.html');
//exit();

try{
    $httpRequest = new HTTPRequest();
    $uri = $httpRequest->requestURI(); 
    
    switch ($uri) {
        case "/":
            $title = "Page d'accueil";
            $action = "show";
            $module = "home";
            $controller = new HomeController($action,$module,$httpRequest);
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
