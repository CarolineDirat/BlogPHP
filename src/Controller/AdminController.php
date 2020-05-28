<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPRequest;
use App\Application\HTTPResponse;
use App\Application\PDOSingleton;
use App\Model\PostManagerPDO;

final class AdminController extends AbstractController
{
    /**
     * executeShowAdmin.
     *
     * Controller to show the admin page
     *
     * @return HTTPResponse
     */
    public function executeShowAdmin(): HTTPResponse
    {
        // get list of all posts
        $postManager = new PostManagerPDO(PDOSingleton::getInstance()->getConnexion());
        $listPosts = $postManager->getListPosts();

        return new HTTPResponse(
            $this->getPage().'.'.$this->getAction(),
            [
                'posts' => $listPosts,
                'user' => $this->httpRequest->getUserSession(),
            ]
        );
    }
}
