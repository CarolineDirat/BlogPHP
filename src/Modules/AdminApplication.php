<?php

namespace App\Modules;

use App\Application\Application;

class AdminApplication extends Application
{    
    public function __construct()
    {
        parent::__construct();
        $this->module = 'admin';
    }

    public function run(): void
    {
        $page = $this->getHttpRequest()->getData('page');
        $action = $this->getHttpRequest()->getData('action');
        if (empty($this->httpRequest->getUserSession())) {
            // if user session doesn't exist : redirection to home page
            $action = 'show';
            $page = 'home';
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
