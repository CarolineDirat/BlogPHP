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
        $httpRequest = $this->httpRequest;
        if ('POST' === $httpRequest->method()) {
            $login = new Login([
                'username' => $httpRequest->postData('username'),
                'pseudo' => $httpRequest->postData('pseudo'),
                'password' => $httpRequest->postData('password'),
            ]);
            $loginForm = $this->buildLoginForm($login);
            $manager = new UserManagerPDO(PDOSingleton::getInstance()->getConnexion());
            $formHandler = new LoginFormHandler($loginForm, $manager, $httpRequest);
            if ($formHandler->process()) {
                // check if user is enabled :
                $user = $httpRequest->getUserSession();
                if (!$user->isEnabled()) {
                    // $_SESSION['user'] is unset if user is not enabled
                    $httpRequest->unsetSession('user');
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
                // user requested another URI before login
                if ($httpRequest->hasSession('url')) {
                    header('Location: ' . SERVER_HOST . $httpRequest->getSession('url'));
                    $httpRequest->unsetSession('url');
                    exit;
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
                ['messageLogin' => 'Pseudo et/ou de mot de passe incorrect(s).', 'loginForm' => $loginForm]
            );
        }

        // Build empty login form
        $login = new Login();
        $loginForm = $this->buildLoginForm($login);
        $correctPath = null;
        if ($httpRequest->hasSession('correctPath')) {
            $correctPath = $httpRequest->getSession('correctPath');
        }

        return new HTTPResponse(
            $this->getPage(),
            [
                'loginForm' => $loginForm,
                'correctPath' => $correctPath,
            ]
        );
    }

    /**
     * Controller to logout : unset $_SESSION['user'] and display login page.
     */
    public function executeLogoutLogin(): HTTPResponse
    {
        // delete user session and his tokens
        $this->httpRequest->unsetSession('user');
        $this->httpRequest->unsetSession('token');
        $this->httpRequest->unsetSession('token_time');
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
