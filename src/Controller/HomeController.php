<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;

//use App\Application\TwigRenderer;

final class HomeController extends AbstractController
{
        
    /**
     * controller to show the Home Page
     *
     * @return HTTPResponse
     */
    public function executeShowHome() : HTTPResponse
    {
        return new HTTPResponse($this->getPage());
    }

    /**
     * controller to process the contact form
     *
     * @return HTTPResponse
     */
    public function executeProcessContact() : HTTPResponse
    {
        
        $message = "c'est moi le message";
        
        
        return new HTTPResponse('home', ['messageInfo' => $message ]);
    }
}
