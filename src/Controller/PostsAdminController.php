<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;
use App\Application\PDOSingleton;
use App\Model\PostManagerPDO;
use App\Model\CommentManagerPDO;

final class PostsAdminController extends AbstractController
{
    /**
     * executeShowAdmin.
     *
     * Controller to show the admin page
     *
     * @return HTTPResponse
     */
    public function executeAdminPosts(): HTTPResponse
    {
        $dao = PDOSingleton::getInstance()->getConnexion();
        // get list of all posts
        $postManager = new PostManagerPDO($dao);
        $listPosts = $postManager->getListPosts();
        // get number of waiting comments for each post
        $commentManager = new CommentManagerPDO($dao);
        $nbsWaitingComments = []; // array of waiting comments for each post of $listPosts
        foreach ($listPosts as $key => $post) {
            $nbsWaitingComments[$key] = $commentManager->getNbWaitingComments($post->getId());
        }

        return new HTTPResponse(
            $this->getAction().'.'.$this->getPage(),
            [
                'posts' => $listPosts,
                'nbsWaitingComments' => $nbsWaitingComments,
                'user' => $this->httpRequest->getUserSession(),
            ]
        );
    }
}
