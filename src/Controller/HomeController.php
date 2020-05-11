<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;

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
        return new HTTPResponse($this->getPage());
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

        if(!$this->httpRequest->postData('email1') || !$this->httpRequest->postData('email1') || $this->httpRequest->postData('email1') !== $this->httpRequest->postData('email2')){
            return new HTTPResponse('home', ['messageInfo' => "Le mail n'a pas pu être envoyé car au moins un des emails n'est pas valide."]);
        }      
        
        $firstName = $this->httpRequest->postData('firstName');
        $lastName = $this->httpRequest->postData('lastName');
        $email = $this->httpRequest->postData('email1');
        $messageContact = $this->httpRequest->postData('messageContact');
        
        // Create the email and send the message
        $to = MAIL; // @phpstan-ignore-line // define your email address in config/config.php file, replacing yourname@yourdomain.com - This is where the form will send a message to.
        $emailSubject = "Formulaire de contact à CaroCode : ".$firstName." ".$lastName;
        $emailBody = "Vous avez reçu un message depuis le formulaire de contact de CaroCode\n\n"."Voici les details:\n\nNom : ".$lastName."\n\nPrénom : ".$firstName."\n\nEmail : ".$email."\n\nMessage:\n".$messageContact;
        $headers = "From: noreply@gmail.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
        $headers .= "Reply-To: ".$email;
        
        if(mail($to, $emailSubject, $emailBody, $headers)){
            return new HTTPResponse('home', ['messageInfo' => "Votre message a bien été envoyé."]);
        } else {
            throw new \Exception("Nous sommes désolés, l'envoie du mail a échoué.");
        }
    }
}
