<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


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

        if (!$this->httpRequest->postData('email1') || !$this->httpRequest->postData('email1') || $this->httpRequest->postData('email1') !== $this->httpRequest->postData('email2')) {
            return new HTTPResponse('home', ['messageInfo' => "Le mail n'a pas pu être envoyé car au moins un des emails n'est pas valide."]);
        }
   
        $firstName = $this->httpRequest->postData('firstName');
        $lastName = $this->httpRequest->postData('lastName');
        $email = $this->httpRequest->postData('email1');
        $messageContact = $this->httpRequest->postData('messageContact');

        ////////// Create the email and send the message //////////////////
        // Instantiation of PHPMailer and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        $mail->set('CharSet', PHPMailer::CHARSET_UTF8);  // define the character set of the message at utf-8.
        
        //Server settings
        $mail->SMTPDebug = 0;                      // Enable verbose debug output with SMTP::DEBUG_SERVER
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = SMTP_SERVER;  // @phpstan-ignore-line   // Set the SMTP server to send through, defined in config.php
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = SMTP_USER;    // @phpstan-ignore-line   // SMTP username, defined in config.php
        $mail->Password   = SMTP_PASS;    // @phpstan-ignore-line   // SMTP password, defined in config.php
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('ne-pas-repondre@carocode.com', 'Contact Form');
        $mail->addAddress(EMAIL_CONTACT); // @phpstan-ignore-line   // Add a recipient (Name is optional)
        $mail->addReplyTo($email, $firstName.' '.$lastName);

        // Content
        $mail->isHTML(true);                                                                // Set email format to HTML
        $mail->Subject = "Formulaire de contact à CaroCode : ".$firstName." ".$lastName;    // Here is the subject
        // This is the HTML message body <b>in bold!</b>:
        $mail->Body    = "Vous avez reçu un message depuis le formulaire de contact de CaroCode. Voici les details :<br/><br/><b>Prénom : </b>".$firstName."<br/><br/><b>Nom :</b> ".$lastName."<br/><br/><b>Email :</b> ".$email."<br/><br/><b>Message :</b> ".$messageContact;
        // This is the body in plain text for non-HTML mail clients:
        $mail->AltBody = $messageContact ;
        
        if ($mail->send()) {
            return new HTTPResponse('home', ['messageInfo' => "Votre message a bien été envoyé."]);
        } 
        throw new \Exception("L'envoie du mail a échoué :".$mail->ErrorInfo);
    }
}
