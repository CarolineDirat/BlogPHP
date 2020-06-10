<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\Form\Form;
use App\Application\HTTPResponse;
use App\Application\PDOSingleton;
use App\Entity\Form\Register;
use App\FormBuilder\RegisterFormBuilder;
//use App\FormHandler\RegisterFormHandler;
//use App\Model\UserManagerPDO;

/**
 * RegisterPublicController
 * 
 * Controller to manage a user registration
 */
final class RegisterPublicController extends AbstractController
{
    public function executeShowRegister(): HTTPResponse
    {
        // Build empty registration form
        $register = new Register();
        $formbuilder = new RegisterFormBuilder($register);
        $registerForm = $formbuilder->build()->getForm();       

        return new HTTPResponse($this->getPage(), ['registerForm' => $registerForm]);
    }
}
