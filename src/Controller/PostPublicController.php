<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;
use App\Application\PDOSingleton;
use App\Entity\Comment;
use App\Entity\Post;
use App\FormBuilder\CommentFormBuilder;
use App\FormHandler\CommentFormHandler;
use App\Model\CommentManagerPDO;
use App\Model\Email\CommentEmailManager;
use App\Model\PostManagerPDO;

final class PostPublicController extends AbstractController
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
            // get list of post's comments
            $commentManager = new CommentManagerPDO($dao);
            $listComments = $commentManager->getValidComments($post->getId());
            // if a comment has been sent
            if ('POST' === $httpRequest->method()) {
                if (empty($httpRequest->getUserSession())) {
                   $httpRequest->redirection('/login'); 
                }
                // instantiation Comment object with data
                $comment = new Comment([
                    'content' => $httpRequest->postData('content'),
                    'idPost' => $httpRequest->getData('id'),
                    'idUser' => $httpRequest->getUserSession()->getId(),
                ]);
                // build comment form from $comment
                $formBuilder = new CommentFormBuilder($comment);
                $commentForm = $formBuilder->build()->getForm();
                // instantiation of form handler and comment manager to process the form
                $manager = new CommentManagerPDO($dao);
                $formHandler = new CommentFormHandler($commentForm, $manager, $httpRequest);
                // process comment form and display post page consequently to the process result
                if ($formHandler->process()) {
                    // send a mail to Admin to notify him of creation of a comment to validate
                    $manager = new CommentEmailManager();
                    $manager->sendReportComment($comment, $post);
                    // build empty comment form
                    $comment = new Comment();
                    $formBuilder = new CommentFormBuilder($comment);
                    $commentForm = $formBuilder->build()->getForm();
                    // send HTTP response
                    return new HTTPResponse(
                        $this->getPage(),
                        [
                            'post' => $post,
                            'comments' => $listComments,
                            'user' => $this->httpRequest->getUserSession(),
                            'commentForm' => $commentForm,
                            'messageInfo' => "Votre commentaire a été envoyé pour validation. \n Vous recevrez un mail lorsqu'il sera validé.",
                        ]
                    );
                }

                return new HTTPResponse(
                    $this->getPage(),
                    [
                        'post' => $post,
                        'comments' => $listComments,
                        'user' => $this->httpRequest->getUserSession(),
                        'commentForm' => $commentForm,
                        'messageInfo' => "Votre commentaire n'a pas put être enregistré. \n Veuillez vérifier le contenu de votre commentaire.",
                    ]
                );
            }
            // else, if a comment hasn't been sent :
            // build empty comment form
            $comment = new Comment();
            $formBuilder = new CommentFormBuilder($comment);
            $commentForm = $formBuilder->build()->getForm();
            // URI is store in user session to be redirected after log in
            if (empty($this->httpRequest->getUserSession())) {
                $this->httpRequest->setSession('url', $this->httpRequest->requestURI());
            }

            return new HTTPResponse(
                $this->getPage(),
                [
                    'post' => $post,
                    'comments' => $listComments,
                    'user' => $this->httpRequest->getUserSession(),
                    'commentForm' => $commentForm,
                ]
            );
        }

        throw new \Exception('id or slug is missing in the request');
    }
}
