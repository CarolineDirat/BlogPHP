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
     * getComment.
     *
     * Method which return a comment from database with its id's post
     */
    abstract public function getComment(int $id): Comment;

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
            return empty($comment->getId()) ? $this->add($comment) : $this->update($comment);
        }

        return false;
    }

    /**
     * delete.
     *
     * delete a comment from database
     */
    abstract public function delete(int $id): bool;
}
