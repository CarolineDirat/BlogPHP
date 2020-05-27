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
     * @return bool
     */
    abstract public function add(Comment $comment): bool;
        
    /**
     * modify
     * 
     * Method to modify a comment in database
     *
     * @param  Comment $comment
     * @return bool
     */
    abstract public function modify(Comment $comment): bool;
    
    /**
     * save
     * 
     * Method wich save a comment in database :
     * - add it if it's new
     * - modify it if it isn't new
     *
     * @param  Comment $comment
     * @return bool
     */
    public function save(Comment $comment): bool
    {
        if ($comment->isValid()) {
            if ($comment->isNew()) {
                return $this->add($comment);
            }
              
            return $this->modify($comment);
        } else {
            throw new Exception("The comment must be valid to be saved.");
        }
    }
}
