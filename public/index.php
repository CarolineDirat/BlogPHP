<?php

session_start();

require_once '../vendor/autoload.php';
require_once '../config/config.php';

use App\Application\HTTPRequest;
use App\Application\TwigRenderer;
use App\Controller\HomeController;
use App\Controller\PostController;

$twigRenderer = new TwigRenderer('../templates');

try {
    $match = false; // will be true if the rooter receive a route corresponding to a controller
    $action = 'show';
    $page = 'home';
    $httpRequest = new HTTPRequest();

    if ('/' === $httpRequest->requestURI()) {
        $match = true;
        $controller = new HomeController($action, $page, $httpRequest);
        $controller->execute()->send($twigRenderer);
    }

    if ($httpRequest->hasGET('page')) {
        $page = $httpRequest->getData('page');
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
                if ('POST' === $httpRequest->method()) {
                    $match = true;
                    $action = 'process';
                    $controller = new HomeController($action, $page, $httpRequest);
                    $controller->execute()->send($twigRenderer);
                }

                throw new \Exception('Post data missing from the contact form');

                break;
        }
    }
    if (!$match) {
        throw new \Exception('No page corresponds to that requested');
    }
} catch (Exception $e) {
    $twigRenderer->render('error', ['error' => $e->getMessage()]);
}
