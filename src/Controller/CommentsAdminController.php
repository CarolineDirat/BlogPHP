<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;
use App\Application\PDOSingleton;
use App\Model\CommentManagerPDO;
use App\Model\Email\CommentEmailManager;
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
                    'token' => $this->httpRequest->getSession('token'),
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
            // -> get the post from the id
            $post = $postManager->getPost((int) $httpRequest->getData('idPost'));
            // if the request wants to edit a comment's status
            if ($httpRequest->hasGet('idComment')) {
                // I get the comment from the bdd
                $comment = $commentManager->getComment($httpRequest->getData('idComment'));
                // Edition of comment's status ...
                if ($httpRequest->hasPost('status')) {
                    // ... from post data ...
                    // $status can only be 'waiting', 'valid' and 'rejected' in setStatus() method and it will be 'waiting' by default
                    $comment->setStatus($httpRequest->postData('status'));
                }
                if ($httpRequest->hasGet('status')) {
                    // ... or from get data
                    // $status can only be 'waiting', 'valid' and 'rejected' in setStatus() method and it will be 'waiting' by default
                    $comment->setStatus($httpRequest->getData('status'));
                }
                // update the comment with its new status
                if (!$commentManager->save($comment)) {
                    throw new Exception('The request to update comment\'s status failed');
                }
                // send the mail to notify comment author of its status modification
                $mailManager = new CommentEmailManager();
                $mailManager->sendStatus($comment, $post); // if the send failed, an Exception will be throw
            }
            // display the page to manage comments :
            // -> get list of post's comments
            $comments = $commentManager->getAllComments((int) $post->getId());

            return new HTTPResponse(
                'admin.comments',
                [
                    'post' => $post,
                    'comments' => $comments,
                    'user' => $this->httpRequest->getUserSession(),
                    'correctPath' => '../../',
                    'token' => $this->httpRequest->getSession('token'),
                ]
            );
        }

        throw new Exception("The request to update a comment's status failed");
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
            // if the request wants to delete a comment's status, and if session token are checks
            if (
                $httpRequest->hasGet('idComment') &&
                'delete' === $httpRequest->getData('status') &&
                $httpRequest->hasGet('token') &&
                $httpRequest->getSession('token') === $httpRequest->getData('token') &&
                $httpRequest->getTokenTime() >= (time() - LENGTH_SESSION)
            ) {
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
                    'token' => $this->httpRequest->getSession('token'),
                ]
            );
        }

        throw new Exception("update comment's status failed");
    }
}
