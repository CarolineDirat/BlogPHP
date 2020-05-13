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
     * method which returns the instance of one Post, corresponding to an identifier.
     *
     * @return \App\Entity\Post
     */
    abstract public function getPost(int $id);

    /**
     * method which returns a list of posts, from $offset to $limit, from most recent to oldest.
     *
     * @return array[Post]
     */
    abstract public function getListPosts();
}
