<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;
use App\Application\PHPMailerApp;
use Gregwar\Captcha\CaptchaBuilder;

//use App\Application\TwigRenderer;

final class HomeController extends AbstractController
{
        
    /**
     * controller to show the Home Page
     *
     * @return HTTPResponse
     */
    public function executeShowHome() : HTTPResponse
    {
        // Creating the captcha instance and setting the phrase in the session to store
        // it for check when the form is submitted
        $captcha = new CaptchaBuilder;
        $_SESSION['phrase'] = $captcha->getPhrase();

        // Retrieve the captcha to insert it directly into the HTML page:
        return new HTTPResponse($this->getPage(), [ 'captcha' => $captcha->build()->inline() ]);
    }

    /**
     * controller to process the contact form
     *
     * @return HTTPResponse
     */
    public function executeProcessContact() : HTTPResponse
    {
        // Check for empty fields
        if (!$this->httpRequest->hasPost('firstName') ||
            !$this->httpRequest->hasPost('lastName')  ||
            !$this->httpRequest->hasPost('email1')    ||
            !$this->httpRequest->hasPost('email2')    ||
            !$this->httpRequest->hasPost('messageContact')) {
            return new HTTPResponse('home', ['messageInfo' => "Le mail n'a pas pu être envoyé car il manque au moins un champs"]);
        }

        if (!$this->httpRequest->postData('email1') || !$this->httpRequest->postData('email1') || $this->httpRequest->postData('email1') !== $this->httpRequest->postData('email2')) {
            return new HTTPResponse('home', ['messageInfo' => "Le mail n'a pas pu être envoyé car au moins un des emails n'est pas valide."]);
        }
   
        $firstName = $this->httpRequest->postData('firstName');
        $lastName = $this->httpRequest->postData('lastName');
        $email = $this->httpRequest->postData('email1');
        $messageContact = $this->httpRequest->postData('messageContact');
        $recipient = EMAIL_CONTACT; // @phpstan-ignore-line

        ////////// Create the email and send the message //////////////////
        $mail = new PHPMailerApp(true);    // Instantiation of PHPMailer and passing `true` enables exceptions
        
        if ($mail->sendContact($recipient, $firstName, $lastName, $email, $messageContact)) {
            return new HTTPResponse('home', ['messageInfo' => "Votre message a bien été envoyé."]);
        }
        throw new \Exception("L'envoie du mail a échoué :".$mail->ErrorInfo);
    }
}
