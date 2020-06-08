<?php

namespace App\Model\Email;

use App\Entity\Comment;
use App\Entity\Post;
use App\PHPMailer\CommentStatusPHPMailer;
use Exception;

/**
 * CommentEmailManager.
 * 
 */
class CommentEmailManager
{    
    /**
     * sendStatus
     * 
     * define params to send to sendMail() method of CommentStatusPHPMailer to
     * send a mail to comment author to notify him the update of its comment's status
     *
     * @param  Comment $comment
     * @param  Post $post
     * @return bool
     */
    public function sendStatus(Comment $comment, Post $post): bool
    {
        $mail = new CommentStatusPHPMailer(true);    // Instantiation of PHPMailer and passing `true` enables exceptions
        $status = '';
        // status name will be in french in the email body
        switch ($comment->getStatus()) {
            case 'valid':
                $status = 'valide';
            break;
            case 'rejected' :
                $status = 'rejeté';
            break;
            case 'waiting' :
                $status = 'en attente';
            break;
        }        
        // define $params for sendMail() method
        $params = [
            'recipient' => $comment->getEmail(),
            'pseudo' => $comment->getAuthor(),
            'status' => $status,
            'comment' => $comment->getContent(),
            'date' => $comment->getDateCreation()->format('d/m/Y \à H:i:s'),
            'title' => $post->getTitle(),
        ];
        // send the mail
        if ($mail->sendEmail($params)) {
            return true;
        }

        throw new Exception('Sending email to notify update of comment\'s status failed:'.$mail->ErrorInfo);
    }
}