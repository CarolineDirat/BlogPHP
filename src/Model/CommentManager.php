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
}
