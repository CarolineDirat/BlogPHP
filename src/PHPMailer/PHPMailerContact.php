<?php

namespace App\PHPMailer;

use App\Application\PHPMailerApp;
use InvalidArgumentException;

/**
 * PHPMailerContact
 * 
 * Build the mail to send a contact message
 */
class PHPMailerContact extends PHPMailerApp
{
    /**
     * sendEmail.
     *
     * Create a message (from the data's contact form (in the home page))
     * and send it.
     * 
     * the $params array must contains :
     *
     *  string $recipient      Recipient of the mail sent
     *  string $firstName      First name from the contact form
     *  string $lastName       Last name from the contact form
     *  string $email          E-mail from the contact form
     *  string $messageContact Message from the contact form
     * 
     * @param string[] $params
     *
     * @return bool false on error - See the ErrorInfo property for details of the error
     */
    public function sendEmail(array $params): bool
    {
        // We check that the $params array has the right keys
        foreach ($params as $key => $value) {
            if (!in_array($key, ['recipient', 'firstName', 'lastName', 'email', 'messageContact'])) {
                throw new InvalidArgumentException("The params data array passed to sendEmail(params) method is not valid.");
            }
        }
        // Recipients
        $this->setFrom('ne-pas-repondre@carocode.com', 'Contact Form');
        $this->addAddress($params['recipient']);   // Add a recipient (Name is optional)
        $this->addReplyTo($params['email'], $params['firstName'] .' '. $params['lastName']);
        $this->Subject = 'Formulaire de contact à CaroCode : '. $params['firstName'] .' '.$params['lastName'];    // Here is the subject
        // This is the HTML message body <b>in bold!</b>:
        $this->Body = 'Vous avez reçu un message depuis le formulaire de contact de CaroCode. Voici les details :<br/><br/><b>Prénom : </b>'. $params['firstName'] .'<br/><br/><b>Nom :</b> '. $params['lastName'] .'<br/><br/><b>Email :</b> '. $params['email'] .'<br/><br/><b>Message :</b> '. $params['messageContact'];
        // This is the body in plain text for non-HTML mail clients:
        $this->AltBody = $params['messageContact'];

        return $this->send();
    }
}
