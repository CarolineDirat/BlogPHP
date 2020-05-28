<?php

require_once '../vendor/autoload.php';
require_once '../config/config.php';

session_start();

use App\Application\HTTPRequest;
use App\Application\TwigRenderer;
use App\Controller\AdminController;
use App\Controller\HomeController;
use App\Controller\LoginController;
use App\Controller\PostController;

$twigRenderer = new TwigRenderer('../templates');

try {
    $match = false; // will be true if the rooter receive a route corresponding to a controller
    $action = 'show';
    $page = 'home';
    $httpRequest = new HTTPRequest(); //$httpRequest->unsetSession('user');

    if ('/' === $httpRequest->requestURI()) {
        $match = true;
        $controller = new HomeController($action, $page, $httpRequest);
        $controller->execute()->send($twigRenderer);
    }

    if ($httpRequest->hasGET('page')) {
        $page = $httpRequest->getData('page');
        $action = $httpRequest->getData('action');
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
            case 'login':
                $match = true;
                $controller = new LoginController($action, $page, $httpRequest);
                $controller->execute()->send($twigRenderer);

            break;
            case 'admin':
                $match = true;
                $user = $httpRequest->getUserSession();
                // if user doesn't exist : redirection to home page
                if (empty($user)) {
                    $controller = new HomeController('show', 'home', $httpRequest);
                    $controller->execute()->send($twigRenderer);
                }
                // if user does not have 'admin' rights : the user is disconnect
                if ('admin' !== $user->getRole()) {
                    $controller = new LoginController('logout', 'login', $httpRequest);
                    $controller->execute()->send($twigRenderer);
                }
                $controller = new AdminController($action, $page, $httpRequest);
                $controller->execute()->send($twigRenderer);
        }
    }
    if (!$match) {
        throw new Exception('No page corresponds to that requested');
    }
} catch (Exception $e) {
    $twigRenderer->render('error', ['error' => $e->getMessage().' in the file '.$e->getFile()]);
}
