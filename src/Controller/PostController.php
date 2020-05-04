<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\TwigRenderer;
use App\Application\PDOFactory;
use App\Model\PostManagerPDO;
use App\Model\UserManagerPDO;
use Âpp\Entity\Post;

final class PostController extends AbstractController
{
        
    /**
     * controller to show the page of a post
     *
     * @return void
     */
    public function executeShowPost()
    {
        $httpRequest = $this->getHTTPRequest();
        
        if ($httpRequest->getExists('id') && $httpRequest->getExists('slug')){
            // get the post from the id
            $postManager = new PostManagerPDO(PDOFactory::getMysqlConnexion());
            $post = $postManager->getPost((int)$httpRequest->getData('id'));

            // get the author from idUser of $post
            $userManager = new UserManagerPDO(PDOFactory::getMysqlConnexion());
            $pseudo = $userManager->getPseudo((int)$post->getIdUser());
        

        // return the post page with the post object, and the pseudo of the post's author
        $twigRenderer = new TwigRenderer('../templates');
        echo $twigRenderer->render($this->getPage(), ['post'=> $post, 'pseudo' => $pseudo]);
        } else {
            throw new \Exception('La requête est incomplete (slug ou id)');
        }
    }
}
