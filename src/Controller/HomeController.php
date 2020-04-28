<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPRequest;

class HomeController extends AbstractController
{    
    
    public function executeShow(){
        echo $this->getTwig()->render('layout.twig');
    }
}