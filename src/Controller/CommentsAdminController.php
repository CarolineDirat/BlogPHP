<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;
use App\Application\PDOSingleton;
use App\Model\CommentManagerPDO;
use App\Model\PostManagerPDO;
use Exception;

final class CommentsAdminController extends AbstractController
{
    /**
     * executeAdminCommments.
     *
     * Controller to go to the page which manage comments
     */
    public function executeAdminComments(): HTTPResponse
    {
        $httpRequest = $this->getHTTPRequest();
        if ($httpRequest->hasGet('idPost')) {
            // connexion to the database
            $dao = PDOSingleton::getInstance()->getConnexion();
            // get the post from the id, with its author's pseudo
            $postManager = new PostManagerPDO($dao);
            $post = $postManager->getPost((int) $httpRequest->getData('idPost'));
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

        throw new Exception("display page of comments's management failed");
    }

    /**
     * executeUpdateComment.
     *
     * Controller to edit one are severals comment's status
     */
    public function executeUpdateComments(): HTTPResponse
    {
        $httpRequest = $this->getHTTPRequest();
        if ($httpRequest->hasGet('idPost')) {
            // connexion to the database to instantiate managers of posts and comments
            $dao = PDOSingleton::getInstance()->getConnexion();
            $postManager = new PostManagerPDO($dao);
            $commentManager = new CommentManagerPDO($dao);
            // if the request wants to edit a comment's status
            if ($httpRequest->hasGet('idComment')) {
                // I get the comment from the bdd
                $comment = $commentManager->getComment($httpRequest->getData('idComment'));
                // Edition of comment's status ...
                if ($httpRequest->hasPost('status')) {
                    // ... from post data ...
                    $comment->setStatus($httpRequest->postData('status'));
                }
                if ($httpRequest->hasGet('status')) {
                    // ... or from get data
                    $comment->setStatus($httpRequest->getData('status'));
                }
                // update the comment with its new status
                if (!$commentManager->update($comment)) {
                    throw new Exception('The request to edit comment\'s status failed');
                }
                $comment = $commentManager->getComment($httpRequest->getData('idComment'));
            }
            // display the page to manage comments :
            // -> get the post from the id, with its author's pseudo
            $post = $postManager->getPost((int) $httpRequest->getData('idPost'));
            // -> get list of post's comments
            $comments = $commentManager->getAllComments((int) $post->getId());

            return new HTTPResponse(
                'admin.comments',
                [
                    'post' => $post,
                    'comments' => $comments,
                    'user' => $this->httpRequest->getUserSession(),
                    'correctPath' => '../../',
                ]
            );
        }

        throw new Exception("update comment's status failed");
    }

    /**
     * executeDeleteComment.
     *
     * Controller to delete one or severals comment
     */
    public function executeDeleteComments(): HTTPResponse
    {
        $httpRequest = $this->getHTTPRequest();
        if ($httpRequest->hasGet('idPost')) {
            // connexion to the database to instantiate managers of posts and comments
            $dao = PDOSingleton::getInstance()->getConnexion();
            $postManager = new PostManagerPDO($dao);
            $commentManager = new CommentManagerPDO($dao);
            // if the request wants to delete a comment's status
            if ($httpRequest->hasGet('idComment') && 'delete' === $httpRequest->getData('status')) {
                // delete the comment
                if (!$commentManager->delete($httpRequest->getData('idComment'))) {
                    throw new Exception('The request to delete comment\'s status failed');
                }
            }
            // display the page to manage comments :
            // -> get the post from the id, with its author's pseudo
            $post = $postManager->getPost((int) $httpRequest->getData('idPost'));
            // -> get list of post's comments
            $comments = $commentManager->getAllComments((int) $post->getId());

            return new HTTPResponse(
                'admin.comments',
                [
                    'post' => $post,
                    'comments' => $comments,
                    'user' => $this->httpRequest->getUserSession(),
                    'correctPath' => '../../',
                ]
            );
        }

        throw new Exception("update comment's status failed");
    }
}