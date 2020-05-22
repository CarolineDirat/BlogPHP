<?php

namespace App\Controller;

use Exception;
use App\Application\AbstractController;
use App\Application\Form\Form;
use App\Application\HTTPResponse;
use App\Entity\User;
use App\FormBuilder\LoginFormBuilder;

final class LoginController extends AbstractController
{
    /**
     * Controller to show the Login Page.
     */
    public function executeShowLogin(): HTTPResponse
    {
        // Build login form
        $user = new User();
        $loginForm = new LoginFormBuilder($user);

        // return response
        return new HTTPResponse($this->getPage(), ['loginForm' => $loginForm]);
    }
}
