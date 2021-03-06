<?php

namespace App\Modules;

use App\Application\Application;
use App\Application\HTTPRequest;

class AdminApplication extends Application
{
    public function __construct(HTTPRequest $httpRequest)
    {
        parent::__construct($httpRequest);
        $this->module = 'admin';
    }

    public function run(): void
    {
        $httpRequest = $this->getHttpRequest();
        $page = $httpRequest->getData('page');
        $action = $httpRequest->getData('action');
        // if user session doesn't exist : go to login page
        if (empty($httpRequest->getUserSession())) {
            // store URI in session (used for redirection after login)
            $httpRequest->setSession('uri', $httpRequest->requestURI());
            // path to css needs perhaps some corrections
            $httpRequest->setSession('correctPath', $this->correctPath($httpRequest));
            // go to login page
            $action = 'show';
            $page = 'login';
            $this->setModule('public');
        // else if user does not have 'admin' rights : the user is disconnect
        } elseif ('admin' !== $httpRequest->getUserSession()->getRole()) {
            $httpRequest->setSession('uri', $httpRequest->requestURI());
            // path to css needs perhaps some corrections
            $httpRequest->setSession('correctPath', $this->correctPath($httpRequest));
            $action = 'logout';
            $page = 'login';
            $this->setModule('public');
        }
        // if user role = admin, he can go to administration pages
        $this->implementController($action, $page);
    }

    public function correctPath(HTTPRequest $httpRequest): string
    {
        $nbSlash = mb_substr_count($httpRequest->requestURI(), '/');
        $correctPath = '';
        while ($nbSlash > 1) {
            $correctPath .= '../';
            --$nbSlash;
        }

        return $correctPath;
    }
}
