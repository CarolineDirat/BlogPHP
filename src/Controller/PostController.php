<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\TwigRenderer;
use App\Application\PostManager;

final class PostController extends AbstractController
{
        
    /**
     * controller to show a post's page
     *
     * @return void
     */
    public function executeShowPost()
    {
        // get the post for the id
        $httpRequest = $this->getHTTPRequest();
        
        if ($httpRequest->getExists('id') && $httpRequest->getExists('slug')){
            $post = getPost((int)$httpRequest->getData('id'));
        

        // return the post page with the post object
        $twigRenderer = new TwigRenderer('../templates');
        echo $twigRenderer->render($this->getPage(), ['post'=> $post]);
        } else {
            throw new \Exception('La requête est incomplete (slug ou id)');
        }
        
    }
}
