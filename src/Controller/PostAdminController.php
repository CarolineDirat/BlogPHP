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
        
    /**
     * executeAddPost
     * 
     * controller corresponding to the route(admin,add,post)
     * to go to the page to add a post : add.post.twig
     *
     * @return HTTPResponse
     */
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
     * executeUpdatePost
     * 
     *  * controller corresponding to the route(admin,update,post)
     * to go to the page to update a post : update.post.twig
     *
     * @return HTTPResponse
     */
    public function executeUpdatePost(): HTTPResponse
    {
        if ($this->httpRequest->hasGet('id')) {
            // connexion to the database
            $dao = PDOSingleton::getInstance()->getConnexion();
            // get post from database 
            $postManager = new PostManagerPDO($dao);
            $post = $postManager->getPost((int) $this->httpRequest->getData('id'));
            // build postForm with post object
            $postForm = $this->buildPostForm($post, $this->httpRequest);

            return new HTTPResponse(
                $this->getAction().'.'.$this->getPage(),
                [
                    'postForm' => $postForm,
                    'user' => $this->httpRequest->getUserSession(),
                ]
            );

        }

        // if $_GET['id'] doesn't exists, redirection to home page with message info
        return new HTTPResponse(
            'home',
            [
                'messageInfo' => 'Vous avez été redirigé sur la page d\'accueil parce qu\'il manque l\'id du post à modifier dans votre requête',
                'user' => $this->httpRequest->getUserSession(),
            ]
        );
    }
}
