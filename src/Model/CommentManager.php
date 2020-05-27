<?php

namespace App\Model;

use App\Application\Manager;
use App\Entity\Comment;
use Exception;

/**
 * CommentManager.
 *
 * Contains the methods which concern the management of Comments
 */
abstract class CommentManager extends Manager
{
    /**
     * getAllComments.
     *
     * Method which returns a list of all comments of one post, from most recent to oldest.
     *
     * @return array[Comment]
     */
    abstract public function getAllComments(int $idPost): array;

    /**
     * getValidComments.
     *
     * Method which returns a list of VALID comments of one post, from most recent to oldest.
     *
     * @return array[Comment]
     */
    abstract public function getValidComments(int $idPost): array;
        
    /**
     * add
     * 
     * Method to add a comment in database
     *
     * @param  Comment $comment
     * @return void
     */
    abstract public function add(Comment $comment): void;
        
    /**
     * modify
     * 
     * Method to modify a comment in database
     *
     * @param  Comment $comment
     * @return void
     */
    abstract public function modify(Comment $comment): void;
    
    /**
     * save
     * 
     * Method wich save a comment in database :
     * - add it if it's new
     * - modify it if it isn't new
     *
     * @param  Comment $comment
     * @return void
     */
    public function save(Comment $comment): void
    {
        if ($comment->isValid()) {
            $comment->isNew() ? $this->add($comment) : $this->modify($comment);
        } else {
            throw new Exception("The comment must be valid to be saved.");
        }
    }
}
