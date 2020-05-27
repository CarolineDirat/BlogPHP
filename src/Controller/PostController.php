<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;
use App\Application\PDOSingleton;
use App\Model\CommentManagerPDO;
use App\Model\PostManagerPDO;
use App\Entity\Post;
use App\Entity\Comment;
use App\FormBuilder\CommentFormBuilder;

final class PostController extends AbstractController
{
    /**
     * controller to show the page of a post.
     */
    public function executeShowPost(): HTTPResponse
    {
        $httpRequest = $this->getHTTPRequest();

        if ($httpRequest->hasGet('id') && $httpRequest->hasGet('slug')) {
            // connexion to the database
            $dao = PDOSingleton::getInstance()->getConnexion();
            // get the post from the id, with its author's pseudo
            $postManager = new PostManagerPDO($dao);
            $post = $postManager->getPost((int) $httpRequest->getData('id'));
            // build comment form
            $comment = new Comment();
            $formBuilder = new CommentFormBuilder($comment);
            $formBuilder->build();
            $commentForm = $formBuilder->getForm();
            // get list of post's comments
            $commentManager = new CommentManagerPDO($dao);
            $listComments = $commentManager->getValidComments($post->getId());

            return new HTTPResponse(
                $this->getPage(),
                [
                    'post' => $post,
                    'comments' => $listComments,
                    'user' => $this->httpRequest->getUserSession(),
                    'commentForm' => $commentForm
                ]
            );
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

        return new HTTPResponse($this->getPage(), ['listPosts' => $listPosts, 'user' => $this->httpRequest->getUserSession()]);
    }
}
