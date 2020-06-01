<?php

namespace App\Model;

use App\Application\Manager;
use App\Entity\Comment;

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
     * add.
     *
     * Method to add a comment in database
     */
    abstract public function add(Comment $comment): bool;

    /**
     * update.
     *
     * Method to update a comment in database
     */
    abstract public function update(Comment $comment): bool;

    /**
     * save.
     *
     * Method wich save a comment in database :
     * - add it if it's new
     * - update it if it isn't new
     */
    public function save(Comment $comment): bool
    {
        if ($comment->isValid()) {
            return $comment->isNew() ? $this->add($comment) : $this->update($comment);
        }

        return false;
    }
}
