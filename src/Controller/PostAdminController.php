<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;
use App\Application\HTTPRequest;
use App\Application\PDOSingleton;
use App\Application\Form\Form;
use App\Entity\Comment;
use App\Entity\Post;
use App\FormBuilder\CommentFormBuilder;
use App\FormBuilder\PostFormBuilder;
use App\FormHandler\PostFormHandler;
use App\Model\PostManagerPDO;

final class PostAdminController extends AbstractController
{
    public function executeAddPost(): HTTPResponse
    {
        $httpRequest = $this->httpRequest;
        if ('POST' === $httpRequest->method()) {
            // hydrate post entity with values from post form
            $post = new Post([
                'title' => $httpRequest->postData('title'),
                'abstract' => $httpRequest->postData('abstract'),
                'content' => $httpRequest->postData('content'),
                'author' => $httpRequest->postData('author'),
                'idUser' => $httpRequest->getUserSession()->getId(),
            ]);
            // build a post form with fields values
            $postForm = $this->buildPostForm($post, $httpRequest);
            // instantiate PostFormHandler
            $dao = PDOSingleton::getInstance()->getConnexion();
            $manager = new PostManagerPDO($dao);
            $formHandler = new PostFormHandler($postForm, $manager, $httpRequest);
            // process post form
            if ($formHandler->process()) {
                // if process ok : go to the post page
                // get the  post from the last id created
                $postManager = new PostManagerPDO($dao);
                $post = $postManager->getPost((int) $dao->lastInsertId());
                // build empty comment form
                $comment = new Comment();
                $formBuilder = new CommentFormBuilder($comment);
                $formBuilder->build();
                $commentForm = $formBuilder->getForm();

                return new HTTPResponse(
                    $this->getPage(),
                    [
                        'post' => $post,
                        'user' => $this->httpRequest->getUserSession(),
                        'commentForm' => $commentForm,
                    ]
                );
            }
            // else, display post form with last values and alert messages
            return new HTTPResponse(
                $this->getAction().'.'.$this->getPage(),
                [
                    'postForm' => $postForm,
                    'user' => $this->httpRequest->getUserSession(),
                    'messageInfo' => "L'article n'a pas pu être créé, verifiez les champs du formulaire",
                ]
            );
        }
        // else, we only need an empty post form
        $post = new Post();
        $postForm = $this->buildPostForm($post, $httpRequest);

        return new HTTPResponse(
            $this->getAction().'.'.$this->getPage(),
            [
                'postForm' => $postForm,
                'user' => $httpRequest->getUserSession(),
            ]
        );
    }
    
    /**
     * buildPostForm
     *
     * @param  Post $post
     * @param  HTTPRequest $httpRequest
     * @return Form
     */
    public function buildPostForm(Post $post, HTTPRequest $httpRequest): Form
    {
        $formBuilder = new PostFormBuilder($post, $httpRequest);
        $formBuilder->build();
        return $formBuilder->getForm();
    }
}
