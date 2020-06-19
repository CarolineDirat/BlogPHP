<?php

require_once '../vendor/autoload.php';
require_once '../config/config.php';

use App\Application\HTTPRequest;
use App\Application\Route;
use App\Application\TwigRenderer;

try {
    $twigRenderer = new TwigRenderer('../Templates');
    $httpRequest = new HTTPRequest();
    // if request has'nt $_GET['module'] or $_GET['action'] or $_GET['module']
    if (!$httpRequest->hasGET('module') || !$httpRequest->hasGET('page') || !$httpRequest->hasGET('action')) {
        throw new Exception('Error Processing Request : No page corresponds to that requested', 1);
    }
    // if $_GET['module'] is not valid (when ModuleApplication class does'nt exists)
    $appClass = 'App\\Modules\\'.ucfirst($httpRequest->getData('module')).'Application';
    if (!class_exists($appClass)) {
        throw new Exception("Error Processing Request : No page corresponds to that requested because '.{$appClass}.' class does'nt exist");
    }
    $app = new $appClass($httpRequest);
    // checks if route from request exist
    $route = new Route(
        $httpRequest->getData('module'),
        $httpRequest->getData('action'),
        $httpRequest->getData('page')
    );
    $app->getRouter()->checkRoute($route);
    // execute the application
    $app->run();
} catch (Exception $e) {
    $twigRenderer->render('error', ['error' => $e->getMessage().' in the file '.$e->getFile().' - line: '.$e->getLine()]);
}
