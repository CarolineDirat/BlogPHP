<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\TwigRenderer;

class HomeController extends AbstractController
{    
    
    public function executeShow(){
        $twigRenderer = new TwigRenderer('/');
        echo $twigRenderer->render('index');
    }
}