<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\TwigRenderer;
use App\Model\PostManagerPDO;
use App\Model\UserManagerPDO;

final class PostController extends AbstractController
{
        
    /**
     * controller to show a post's page
     *
     * @return void
     */
    public function executeShowPost()
    {
        
        $httpRequest = $this->getHTTPRequest();
        
        if ($httpRequest->getExists('id') && $httpRequest->getExists('slug')){
            
            // get the post from the id
            $postManager = new PostManagerPDO();
            $post = $postManager->getPost((int)$httpRequest->getData('id'));

            // get the author from idUser of $post
            $userManager = new UserManagerPDO();
            $pseudo = $userManager->getPseudo((int)$post->getIdUser());
        

        // return the post page with the post object
        $twigRenderer = new TwigRenderer('../templates');
        echo $twigRenderer->render($this->getPage(), ['post'=> $post, 'pseudo' => $pseudo]);
        } else {
            throw new \Exception('La requête est incomplete (slug ou id)');
        }
        
    }
}
