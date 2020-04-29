<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\TwigRenderer;

final class HomeController extends AbstractController
{
        
    /**
     * controller to show the Home Page
     *
     * @return void
     */
    public function executeShow()
    {
        $twigRenderer = new TwigRenderer('/');
        echo $twigRenderer->render('index');
    }
}
