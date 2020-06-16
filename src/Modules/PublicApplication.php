<?php

namespace App\Modules;

use App\Application\Application;
use App\Application\HTTPRequest;

class PublicApplication extends Application
{
    public function __construct(HTTPRequest $httpRequest)
    {
        parent::__construct($httpRequest);
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
