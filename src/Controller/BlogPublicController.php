<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;
use App\Application\PDOSingleton;
use App\Model\PostManagerPDO;

final class BlogPublicController extends AbstractController
{
    /**
     * controller to show the blog page, a list of posts from most recent to oldest.
     */
    public function executeShowBLog(): HTTPResponse
    {
        // get the list of all posts
        $postManager = new PostManagerPDO(PDOSingleton::getInstance()->getConnexion());
        $listPosts = $postManager->getListPosts();

        return new HTTPResponse($this->getPage(), ['listPosts' => $listPosts, 'user' => $this->httpRequest->getUserSession()]);
    }
}
