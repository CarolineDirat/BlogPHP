<?php

namespace App\Controller;

use App\Application\AbstractController;
//use App\Application\Form\Form;
use App\Application\HTTPResponse;
use App\Application\PDOSingleton;
use App\Entity\Form\Login;
use App\FormBuilder\LoginFormBuilder;
use App\FormHandler\LoginFormHandler;
use App\Model\UserManagerPDO;


final class LoginController extends AbstractController
{
    /**
     * Controller to show the Login Page.
     */
    public function executeShowLogin(): HTTPResponse
    {
        if ('POST' === $this->httpRequest->method()) {
            $login = new Login([
                'username' => $this->httpRequest->postData('username'),
                'pseudo' => $this->httpRequest->postData('pseudo'),
                'password' => $this->httpRequest->postData('password')
            ]);
            $formBuilder = new LoginFormBuilder($login);
            $formBuilder->build();
            $loginForm = $formBuilder->getForm();
            // check honeypot
            if(!empty($login->getUsername()))
            {
                return new HTTPResponse($this->getPage(), ['loginForm' => $loginForm]);
            }
            $manager = new UserManagerPDO(PDOSingleton::getInstance()->getConnexion());
            $formHandler = new LoginFormHandler($loginForm, $manager, $this->httpRequest);
            if ($formHandler->process()) {
                return new HTTPResponse(
                    $this->getPage(),
                    [
                        'messageLogin' => "Bonjour ". $this->httpRequest->getSession('user')->getPseudo() ." ! Vous êtes connecté.",
                        'user' => $this->httpRequest->getSession('user')
                    ]
                );
            }
            return new HTTPResponse(
                    $this->getPage(),
                    ['messageLogin' => "Une erreur de pseudo ou de mot de passe.", 'loginForm' => $loginForm ]
                );
        }
        
        // Build empty login form
        $login = new Login();
        $FormBuilder = new LoginFormBuilder($login);
        $FormBuilder->build();
        $loginForm = $FormBuilder->getForm();

        return new HTTPResponse($this->getPage(), ['loginForm' => $loginForm]);
    }
}
