<?php

require_once '../vendor/autoload.php';
require_once '../config/config.php';

session_start();

use App\Application\HTTPRequest;
use App\Application\TwigRenderer;
use App\Controller\PostsAdminController;
use App\Controller\HomePublicController;
use App\Controller\LoginPublicController;
use App\Controller\PostAdminController;
use App\Controller\PostPublicController;
use App\Controller\BLogPublicController;

$twigRenderer = new TwigRenderer('../templates');

try {
    $match = false; // will be true if the rooter receive a route corresponding to a controller
    $action = 'show';
    $page = 'home';
    $httpRequest = new HTTPRequest();

    if ('/' === $httpRequest->requestURI()) {
        $match = true;
        $controller = new HomePublicController($action, $page, $httpRequest);
        $controller->execute()->send($twigRenderer);
    }

    if ($httpRequest->hasGET('page') && $httpRequest->hasGET('action')) {
        $page = $httpRequest->getData('page');
        $action = $httpRequest->getData('action');
        // if admin module is request
        if ($httpRequest->hasGET('module')) {
            if ('admin' === $httpRequest->getData('module')) {
                $user = $httpRequest->getUserSession();
                // if user session doesn't exist : redirection to home page
                if (empty($user)) {
                    $match = true;
                    $controller = new HomePublicController('show', 'home', $httpRequest);
                    $controller->execute()->send($twigRenderer);
                }
                // if user does not have 'admin' rights : the user is disconnect
                if ('admin' !== $user->getRole()) {
                    $match = true;
                    $controller = new LoginPublicController('logout', 'login', $httpRequest);
                    $controller->execute()->send($twigRenderer);
                }
                // if user role = admin, he can go to administration pages and if $action value is valid
                if ('admin' === $user->getRole()) {
                    switch ($page) {
                        case 'posts':
                            $match = true;
                            $controller = new PostsAdminController($action, $page, $httpRequest);
                            $controller->execute()->send($twigRenderer);

                        break;
                        case 'post':
                            $match = true;
                            $controller = new PostAdminController($action, $page, $httpRequest);
                            $controller->execute()->send($twigRenderer);
                    }
                }
            }
        }
        // else, we are in public application
        if ('public' === $httpRequest->getData('module')) {
            switch ($page) {
                case 'post':
                    $match = true;
                    $controller = new PostPublicController($action, $page, $httpRequest);
                    $controller->execute()->send($twigRenderer);

                break;
                case 'blog':
                    $match = true;
                    $controller = new BlogPublicController($action, $page, $httpRequest);
                    $controller->execute()->send($twigRenderer);

                break;
                case 'login':
                    $match = true;
                    $controller = new LoginPublicController($action, $page, $httpRequest);
                    $controller->execute()->send($twigRenderer);

                break;
            }
        }
    }
    if (!$match) {
        throw new Exception('No page corresponds to that requested');
    }
} catch (Exception $e) {
    $twigRenderer->render('error', ['error' => $e->getMessage().' in the file '.$e->getFile()]);
}
