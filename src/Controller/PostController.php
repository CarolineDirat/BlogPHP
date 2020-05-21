<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;
use App\Application\PDOSingleton;
use App\Model\PostManagerPDO;
use App\Model\UserManagerPDO;
use App\Model\CommentManagerPDO;
use Âpp\Entity\Post;

final class PostController extends AbstractController
{
    /**
     * controller to show the page of a post.
     */
    public function executeShowPost(): HTTPResponse
    {
        $httpRequest = $this->getHTTPRequest();

        if ($httpRequest->hasGet('id') && $httpRequest->hasGet('slug')) {
            $dao = PDOSingleton::getInstance()->getConnexion();
            // get the post from the id
            $postManager = new PostManagerPDO($dao);
            $post = $postManager->getPost((int) $httpRequest->getData('id'));

            // get the author from idUser of $post
            $userManager = new UserManagerPDO($dao);
            $pseudo = $userManager->getPseudo((int) $post->getIdUser());

            // get list of post's comments
            $commentManager = new CommentManagerPDO($dao);
            $listComments = $commentManager->getListComments($post->getId());

            return new HTTPResponse($this->getPage(), ['post' => $post, 'pseudo' => $pseudo, 'comments' => $listComments]);
        }

        throw new \Exception('id or slug is missing in the request');
    }

    /**
     * controller to show the blog page, a list of posts from most recent to oldest.
     */
    public function executeShowBLog(): HTTPResponse
    {
        // get the list of all posts
        $postManager = new PostManagerPDO(PDOSingleton::getInstance()->getConnexion());
        $listPosts = $postManager->getListPosts();

        return new HTTPResponse($this->getPage(), ['listPosts' => $listPosts]);
    }
}
