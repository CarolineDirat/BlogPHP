<?php

namespace App\Modules;

use App\Application\Application;

class PublicApplication extends Application
{
    public function __construct()
    {
        parent::__construct();
        $this->module = 'public';
    }

    public function run(): void
    {
        $this->implementController(
            $this->getHttpRequest()->getData('action'),
            $this->getHttpRequest()->getData('page')
        );
    }
}
