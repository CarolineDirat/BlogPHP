<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;
use App\Application\PDOSingleton;
use App\Model\PostManagerPDO;
use App\Model\CommentManagerPDO;

final class CommentsAdminController extends AbstractController
{
    /**
     * executeAdminCommments.
     *
     * Controller to admin admin comments of one post blog
     *
     * @return HTTPResponse
     */
    public function executeAdminComments(): HTTPResponse
    {
        $httpRequest = $this->getHTTPRequest();
        if ($httpRequest->hasGet('id')) {
            // connexion to the database
            $dao = PDOSingleton::getInstance()->getConnexion();
            // get the post from the id, with its author's pseudo
            $postManager = new PostManagerPDO($dao);
            $post = $postManager->getPost((int) $httpRequest->getData('id'));
            // get list of post's comments
            $commentManager = new CommentManagerPDO($dao);
            $comments = $commentManager->getAllComments((int) $post->getId());

            return new HTTPResponse(
                $this->getAction().'.'.$this->getPage(),
                [
                    'post' => $post,
                    'comments' => $comments,
                    'user' => $this->httpRequest->getUserSession(),
                ]
            );
        }
        
        // if $_GET['id'] doesn't exists, redirection to home page with message info
        return new HTTPResponse(
            'home',
            [
                'messageInfo' => 'Vous avez été redirigé sur la page d\'accueil parce qu\'il manque l\'id du post à gérer dans votre requête',
                'user' => $httpRequest->getUserSession(),
            ]
        );

    }
}
