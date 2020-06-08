<?php

namespace App\PHPMailer;

use App\Application\PHPMailerApp;
use InvalidArgumentException;
use Exception;

/**
 * CommentStatusPHPMailer
 */
class CommentStatusPHPMailer extends PHPMailerApp
{
    /**
     * sendEmail.
     *
     * Build the mail to notify comment author of his comment's status update
     * and send it by email
     *
     * the $params array must contains :
     *
     *  string $recipient       Recipient of the mail sent
     *  string $pseudo          pseudo of comment's author
     *  string $status          comment status
     *  string $comment         comment content
     *  string $date            comment date of save : from DateTime::format('d/m/Y \à H:i:s')
     *  strind $title           post title
     *
     * @param string[] $params
     *
     * @return bool false on error - See the ErrorInfo property for details of the error
     */
    public function sendEmail(array $params): bool
    {
        // We check that the $params array has the right keys
        foreach (array_keys($params) as $value) {
            if (!in_array($value, ['recipient', 'pseudo', 'status', 'comment', 'date', 'title'], true)) {
                throw new InvalidArgumentException('The params data array passed to sendEmail(params) method is not valid.');
            }
        }
        // Recipients
        $this->setFrom(EMAIL_ADMIN, 'CaroCode');
        $this->addAddress($params['recipient'], $params['pseudo']);   // Add a recipient (Name is optional)
        $this->addReplyTo(EMAIL_ADMIN, 'Status comment');
        $this->Subject = $params['pseudo'].' : Votre commentaire sur CaroCode est désormais '.$params['status'];    // Here is the subject
        // custom message
        switch ($params['status']) {
            case 'valide':
                $custom = 'Il est donc désormais visible parmi les autres commentaires validés. ';
            break;
            case 'rejeté' :
                $custom = 'Il ne sera pas lisible sur le site. ';
            break;
            case 'en attente' :
                $custom = 'Il est en attente d\'une validation. ';
            break;
            default:
                throw new Exception('comment status value'.$params['status'].' is not valid');
        }        
        // This is the HTML message body <b>in bold!</b>:
        $this->Body = 'Bonjour '.$params['pseudo'].', vous avez reçu un message depuis le site CaroCode : <br/> 
            Votre commentaire : <br/> << '.$params['comment'].' >> <br/> du '.$params['date'].' sur le post "'.$params['title'] . '" <br/>
            est désormais <b>'.$params['status']. '</b>. '.$custom;  
        // This is the body in plain text for non-HTML mail clients:
        $this->AltBody = 'Bonjour '.$params['pseudo'].', vous avez reçu un message depuis le site CaroCode : 
        Votre commentaire : << '.$params['comment'].' >> du '.$params['date'].' sur le post "'.$params['title'] .'"  
        est désormais '.$params['status'].'. '.$custom;

        return $this->send();
    }
}
