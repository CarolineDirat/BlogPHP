<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\Form\Form;
use App\Application\HTTPResponse;
use App\Application\PDOSingleton;
use App\Entity\Form\Login;
use App\FormBuilder\LoginFormBuilder;
use App\FormHandler\LoginFormHandler;
use App\Model\UserManagerPDO;

final class LoginPublicController extends AbstractController
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
                'password' => $this->httpRequest->postData('password'),
            ]);
            $loginForm = $this->buildLoginForm($login);
            // check honeypot
            if (!empty($login->getUsername())) {
                return new HTTPResponse($this->getPage(), ['loginForm' => $loginForm]);
            }
            $manager = new UserManagerPDO(PDOSingleton::getInstance()->getConnexion());
            $formHandler = new LoginFormHandler($loginForm, $manager, $this->httpRequest);
            if ($formHandler->process()) {
                // check if user is enabled :
                $user = $this->httpRequest->getUserSession();
                if (!$user->isEnabled()) {
                    // $_SESSION['user'] is unset if user is not enabled
                    $this->httpRequest->unsetSession('user');
                    // Build empty login form
                    $login = new Login();
                    $loginForm = $this->buildLoginForm($login);

                    return new HTTPResponse(
                        $this->getPage(),
                        [
                            'loginForm' => $loginForm,
                            'messageLogin' => "Votre compte n'est pas encore activé ! \n Veuillez vérifier vos emails, un mail vous a été envoyé pour l'activer.",
                        ]
                    );
                }

                return new HTTPResponse(
                    $this->getPage(),
                    [
                        'messageLogin' => 'Bonjour ',
                        'user' => $user,
                    ]
                );
            }

            return new HTTPResponse(
                $this->getPage(),
                ['messageLogin' => 'Pseudo et/ou de mot de pas incorrect(s).', 'loginForm' => $loginForm]
            );
        }

        // Build empty login form
        $login = new Login();
        $loginForm = $this->buildLoginForm($login);

        return new HTTPResponse($this->getPage(), ['loginForm' => $loginForm]);
    }

    /**
     * Controller to logout : unset $_SESSION['user'] and display login page.
     */
    public function executeLogoutLogin(): HTTPResponse
    {
        $this->httpRequest->unsetSession('user');
        // Build empty login form
        $login = new Login();
        $loginForm = $this->buildLoginForm($login);

        return new HTTPResponse($this->getPage(), ['loginForm' => $loginForm, 'messageLogin' => 'Vous êtes déconnecté.']);
    }

    /**
     * buildLoginForm.
     *
     * create a login form from Login object
     */
    public function buildLoginForm(Login $login): Form
    {
        $formBuilder = new LoginFormBuilder($login);

        return $formBuilder->build()->getForm();
    }
}
