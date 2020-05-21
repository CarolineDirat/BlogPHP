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
     * getListComments.
     *
     * Method which returns a list of all comments from most recent to oldest.
     *
     * @return array[Comment]
     */
    abstract public function getListComments(int $idPost): array;

    /**
     * getListComments.
     *
     * Method which returns a list of VALID comments from most recent to oldest.
     *
     * @return array[Comment]
     */
    abstract public function getListValidComments(int $idPost): array;
}
