<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPRequest;
use App\Application\HTTPResponse;
use App\Application\PDOSingleton;
use App\Model\PostManagerPDO;
use App\Entity\Post;
use App\FormBuilder\PostFormBuilder;

final class PostAdminController extends AbstractController
{
    public function executeAddPost() : HTTPResponse
    {
        $post = new Post();
        $formBuilder = new PostFormBuilder($post, $this->httpRequest);
        $formBuilder->build();
        $postForm = $formBuilder->getForm();
        
        return new HTTPResponse(
            $this->getAction().'.'.$this->getPage(),
            [
                'postForm' => $postForm,
                'user' => $this->httpRequest->getUserSession(),
            ]
        );
    }

}
