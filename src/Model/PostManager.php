<?php

namespace App\Model;

use App\Application\Manager;
use App\Entity\Post;

/**
 * PostManager.
 *
 * contains the methods which concern the management of Posts
 */
abstract class PostManager extends Manager
{
    /**
     * getPost.
     *
     * Method which returns the instance of one Post, corresponding to an identifier.
     */
    abstract public function getPost(int $id): Post;

    /**
     * getListPosts.
     *
     * Method which returns a list of posts, from $offset to $limit, from most recent to oldest.
     *
     * @return array[Post]
     */
    abstract public function getListPosts(): array;
}
