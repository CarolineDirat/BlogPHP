<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\Form\Form;
use App\Application\HTTPRequest;
use App\Application\HTTPResponse;
use App\Application\PDOSingleton;
use App\Entity\Comment;
use App\Entity\Post;
use App\FormBuilder\CommentFormBuilder;
use App\FormBuilder\PostFormBuilder;
use App\FormHandler\PostFormHandler;
use App\Model\PostManagerPDO;

final class PostAdminController extends AbstractController
{
    /**
     * buildPostForm.
     *
     * @return Form
     */
    public function buildPostForm(Post $post, HTTPRequest $httpRequest): Form
    {
        $formBuilder = new PostFormBuilder($post, $httpRequest);
        $formBuilder->build();

        return $formBuilder->getForm();
    }

    /**
     * executeAddPost.
     *
     * controller corresponding to the route(admin,add,post)
     * to go to the page to add a post : add.post.twig
     * and process a form post to add a post
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
     * executeUpdatePost.
     *
     * controller corresponding to the route(admin,update,post)
     * to go to the page to update a post : update.post.twig
     * and process a post form to update a post
     *
     * @return HTTPResponse
     */
    public function executeUpdatePost(): HTTPResponse
    {
        $httpRequest = $this->httpRequest;
        if ($httpRequest->hasGet('id')) {
            // connexion to the database
            $dao = PDOSingleton::getInstance()->getConnexion();
            // if form have been submit
            if ('POST' === $this->httpRequest->method()) {
                // get post from post form
                $post = new Post([
                    'title' => $httpRequest->postData('title'),
                    'abstract' => $httpRequest->postData('abstract'),
                    'content' => $httpRequest->postData('content'),
                    'author' => $httpRequest->postData('author'),
                    'idUser' => $httpRequest->getUserSession()->getId(),
                    'id' => $httpRequest->getData('id'),
                ]);
                // build a post form with fields values
                $postForm = $this->buildPostForm($post, $httpRequest);
                // instantiate PostFormHandler
                $manager = new PostManagerPDO($dao);
                $formHandler = new PostFormHandler($postForm, $manager, $httpRequest);
                // process post form
                if ($formHandler->process()) {
                    // if process ok: we stay on update post page with new values, with a message of success
                    $messageInfo = 'La modification du post a été enregistrée';
                    // we get post from database
                    $postManager = new PostManagerPDO($dao);
                    $post = $postManager->getPost((int) $httpRequest->getData('id'));
                    // build postForm with post object
                    $postForm = $this->buildPostForm($post, $httpRequest);
                } else {
                    // if process fails : a message alerts the user
                    $messageInfo = 'La modification du  post a échoué, veuillez vérifier les valeurs des champs';
                    // and the content of the form remains that before validation
                }

                return new HTTPResponse(
                    $this->getAction().'.'.$this->getPage(),
                    [
                        'postForm' => $postForm,
                        'user' => $httpRequest->getUserSession(),
                        'messageInfo' => $messageInfo,
                        'post' => $post,
                    ]
                );
            }
            // else, if mehod request is not 'POST'
            // we get post from database
            $postManager = new PostManagerPDO($dao);
            $post = $postManager->getPost((int) $httpRequest->getData('id'));
            // build postForm with post object
            $postForm = $this->buildPostForm($post, $httpRequest);

            return new HTTPResponse(
                $this->getAction().'.'.$this->getPage(),
                [
                    'postForm' => $postForm,
                    'user' => $httpRequest->getUserSession(),
                    'post' => $post,
                ]
            );
        }

        // if $_GET['id'] doesn't exists, redirection to home page with message info
        return new HTTPResponse(
            'home',
            [
                'messageInfo' => 'Vous avez été redirigé sur la page d\'accueil parce qu\'il manque l\'id du post à modifier dans votre requête',
                'user' => $httpRequest->getUserSession(),
            ]
        );
    }
    
    /**
     * executeDeletePost
     * 
     * controller corresponding to the route(admin,delete,post)
     * to go to the page to confirm to delete a post : delete.post.twig
     * and it manages the deletion of the post when it is confirmed
     *
     * @return HTTPResponse
     */
    public function executeDeletePost(): HTTPResponse
    {
        $httpRequest = $this->httpRequest;
        if ($httpRequest->hasGet('id')) {
            // connexion to the database
            $dao = PDOSingleton::getInstance()->getConnexion();
            // get the post from the id, with its author's pseudo
            $postManager = new PostManagerPDO($dao);
            $post = $postManager->getPost((int) $httpRequest->getData('id'));

            return new HTTPResponse(
                $this->getAction().'.'.$this->getPage(),
                [
                    'user' => $httpRequest->getUserSession(),
                    'post' => $post,
                ]
            );
             
        }

        // if $_GET['id'] doesn't exists, redirection to home page with message info
        return new HTTPResponse(
            'home',
            [
                'messageInfo' => 'Vous avez été redirigé sur la page d\'accueil parce qu\'il manque l\'id du post à supprimer dans votre requête',
                'user' => $httpRequest->getUserSession(),
            ]
        );

    }
}
