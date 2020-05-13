<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;
use App\Application\PHPMailerApp;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

//use App\Application\TwigRenderer;

final class HomeController extends AbstractController
{
    /**
     * Controller to show the Home Page.
     *
     * @return HTTPResponse
     */
    public function executeShowHome(): HTTPResponse
    {
        // Creating the captcha instance and setting the phrase in the session to store
        // it for check when the form is submitted
        $captcha = new CaptchaBuilder();
        $this->httpRequest->setSession('phrase', $captcha->getPhrase());

        // Retrieve the captcha to insert it directly into the home.twig page:
        return new HTTPResponse($this->getPage(), ['captcha' => $captcha->build()->inline()]);
    }

    /**
     * Controller to process the contact form.
     *
     * @return HTTPResponse
     */
    public function executeProcessContact(): HTTPResponse
    {
        // Check for empty fields
        if (
            !$this->httpRequest->hasPost('phrase')
            || !$this->httpRequest->hasPost('firstName')
            || !$this->httpRequest->hasPost('lastName')
            || !$this->httpRequest->hasPost('email1')
            || !$this->httpRequest->hasPost('email2')
            || !$this->httpRequest->hasPost('messageContact')
        ) {
            return new HTTPResponse('home', ['messageInfo' => "Le mail n'a pas pu être envoyé car il manque au moins un champs"]);
        }

        // Check captcha
        // Checking that the posted phrase match the phrase stored in the session
        if (!PhraseBuilder::comparePhrases($this->httpRequest->getSession('phrase'), $this->httpRequest->postData('phrase'))) {
            return new HTTPResponse(
                'home',
                ['messageInfo' => "Le code recopié ne correspond pas à l'image, veuillez cliquer sur <<Accueil>> du menu pour réessayer"]
            );
        }
        // The captcha's phrase can't be used twice
        $this->httpRequest->unsetSession('phrase');

        // Check emails equality
        if (
            !$this->httpRequest->postData('email1')
            || !$this->httpRequest->postData('email1')
            || $this->httpRequest->postData('email1') !== $this->httpRequest->postData('email2')
        ) {
            return new HTTPResponse(
                'home',
                ['messageInfo' => "Le mail n'a pas pu être envoyé car au moins un des emails n'est pas valide."]
            );
        }
        $mail = new PHPMailerApp(true);    // Instantiation of PHPMailer and passing `true` enables exceptions
        if (
            $mail->sendContact(
                EMAIL_CONTACT,  // @phpstan-ignore-line
                $this->httpRequest->postData('firstName'),
                $this->httpRequest->postData('lastName'),
                $this->httpRequest->postData('email1'),
                $this->httpRequest->postData('messageContact')
            )
        ) {
            return new HTTPResponse('home', ['messageInfo' => 'Votre message a bien été envoyé.']);
        }

        throw new \Exception("L'envoie du mail a échoué :".$mail->ErrorInfo);
    }
}
