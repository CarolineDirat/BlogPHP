<?php
namespace App\Application;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PHPMailerApp extends PHPMailer
{
    public function settings()
    {
        $this->set('CharSet', PHPMailer::CHARSET_UTF8);  // define the character set of the message at utf-8.
        
        // Server settings
        $this->SMTPDebug = 0;                      // Enable verbose debug output with SMTP::DEBUG_SERVER, in develop environment (0 in production environment)
        $this->isSMTP();                                            // Send using SMTP
        $this->Host       = SMTP_SERVER;  // @phpstan-ignore-line   // Set the SMTP server to send through, defined in config.php
        $this->SMTPAuth   = true;                                   // Enable SMTP authentication
        $this->Username   = SMTP_USER;    // @phpstan-ignore-line   // SMTP username, defined in config.php
        $this->Password   = SMTP_PASS;    // @phpstan-ignore-line   // SMTP password, defined in config.php
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $this->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
        // Content
        $this->isHTML(true);   // Set email format to HTML
    }

    public function sendContact($recipient, $firstName, $lastName, $email, $messageContact)
    {           
        // Recipients
        $this->setFrom('ne-pas-repondre@carocode.com', 'Contact Form');
        $this->addAddress($recipient);   // Add a recipient (Name is optional)
        $this->addReplyTo($email, $firstName.' '.$lastName);

        $this->Subject = "Formulaire de contact à CaroCode : ".$firstName." ".$lastName;    // Here is the subject
        // This is the HTML message body <b>in bold!</b>:
        $this->Body    = "Vous avez reçu un message depuis le formulaire de contact de CaroCode. Voici les details :<br/><br/><b>Prénom : </b>".$firstName."<br/><br/><b>Nom :</b> ".$lastName."<br/><br/><b>Email :</b> ".$email."<br/><br/><b>Message :</b> ".$messageContact;
        // This is the body in plain text for non-HTML mail clients:
        $this->AltBody = $messageContact;

        return $this->send(); 
    }
}
