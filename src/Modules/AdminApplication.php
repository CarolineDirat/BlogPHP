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
        $page = $this->getHttpRequest()->getData('page');
        $action = $this->getHttpRequest()->getData('action');
        if (empty($this->httpRequest->getUserSession())) {
            // if user session doesn't exist : go to login page
            $action = 'show';
            $page = 'login';
            $this->setModule('public');
        } elseif ('admin' !== $this->httpRequest->getUserSession()->getRole()) {
            // else if user does not have 'admin' rights : the user is disconnect
            $action = 'logout';
            $page = 'login';
            $this->setModule('public');
        }
        // if user role = admin, he can go to administration pages
        $this->implementController($action, $page);
    }
}
