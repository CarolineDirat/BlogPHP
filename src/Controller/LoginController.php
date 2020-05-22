<?php

namespace App\Controller;

use Exception;
use App\Application\AbstractController;
use App\Application\Form\Form;
use App\Application\HTTPResponse;
use App\Entity\Form\Login;
use App\FormBuilder\LoginFormBuilder;

final class LoginController extends AbstractController
{
    /**
     * Controller to show the Login Page.
     */
    public function executeShowLogin(): HTTPResponse
    {
        // Build login form
        $login = new Login();
        $FormBuilder = new LoginFormBuilder($login);
        $FormBuilder->build();
        $loginForm = $FormBuilder->getForm();

        return new HTTPResponse($this->getPage(), ['loginForm' => $loginForm]);
    }
}
