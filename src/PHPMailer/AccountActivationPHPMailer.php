<?php

namespace App\PHPMailer;

use App\Application\PHPMailerApp;
use InvalidArgumentException;

/**
 * AccountActivationPHPMailer.
 *
 * Build and send the mail to new user to activate his account by clicking on a link
 */
class AccountActivationPHPMailer extends PHPMailerApp
{
    /**
     * sendEmail.
     *
     * Create and send a email to new user to activate his account by clicking on a link
     * ex : 'http://blogphp/activation-log='.urlencode($pseudo).'&key='.urlencode($key).'
     *
     * the $params array must contains :
     *
     *  string $recipient       email recipient
     *  string $pseudo          user's pseudo
     *  string $key             user's activation key
     *
     * @param string[] $params
     *
     * @return bool false on error - See the ErrorInfo property for details of the error
     */
    public function sendEmail(array $params): bool
    {
        // We check that the $params array has the right keys
        foreach (array_keys($params) as $value) {
            if (!in_array($value, ['recipient', 'pseudo', 'key'], true)) {
                throw new InvalidArgumentException('The params data array passed to sendEmail(params) method is not valid.');
            }
        }
        // Recipients
        $this->setFrom('ne-pas-repondre@carocode.com', 'CaroCode');
        $this->addAddress($params['recipient'], $params['pseudo'] );   // Add a recipient (Name is optional)
        $this->Subject = 'Activer votre compte pour le blog CaroCode : ';    // Here is the subject
        // This is the HTML message body <b>in bold!</b>:
        $this->Body = 'Bienvenue sur CaroCode, <br/>
        Pour activer votre compte, veuillez cliquer sur le lien ci-dessous ou le copier/coller dans votre navigateur internet : <br/>
        <a href="'.SERVER_HOST.'/activation-log='.urlencode($params['pseudo']).'&key='.urlencode($params['key']).'">
        Activer mon compte sur CaroCode</a>';
        // This is the body in plain text for non-HTML mail clients:
        $this->AltBody = 'Bienvenue sur CaroCode.
        Pour activer votre compte, veuillez cliquer sur le lien ci-après ou le copier/coller dans votre navigateur internet : 
        '.SERVER_HOST.'/activation-log='.urlencode($params['pseudo']).'&key='.urlencode($params['key']);
        
        return $this->send();
    }
}
