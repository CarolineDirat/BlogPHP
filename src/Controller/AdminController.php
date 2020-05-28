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
        $httpRequest = $this->getHTTPRequest();
        $user = $httpRequest->getUserSession();
        // if doesn't exist : redirection to home page
        if (empty($user)) {
            return $this->home($httpRequest);
        }
        // if user does not have 'admin' rights : the user is disconnect
        if ('admin' !== $user->getRole()) {
            return $this->logout($httpRequest);
        }
        // get list of all posts
        $postManager = new PostManagerPDO(PDOSingleton::getInstance()->getConnexion());
        $listPosts = $postManager->getListPosts();

        return new HTTPResponse(
            $this->getPage().'.'.$this->getAction(),
            [
                'posts' => $listPosts,
                'user' => $user,
            ]
        );
    }

    /**
     * logout.
     *
     * disconnects the user (called when the user does not have 'admin' rights in AdminController controller methods)
     *
     * @return HTTPResponse
     */
    public function logout(HTTPRequest $httpResquest): HTTPResponse
    {
        $controller = new LoginController('login', 'logout', $httpResquest);

        return $controller->execute();
    }

    /**
     * home.
     *
     * redirect to home page (called when user doesn't exist in AdminController controller methods)
     *
     * @return HTTPResponse
     */
    public function home(HTTPRequest $httpResquest): HTTPResponse
    {
        $controller = new HomeController('home', 'show', $httpResquest);

        return $controller->execute();
    }
}
