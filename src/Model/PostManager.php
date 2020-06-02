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
     * Method which returns a list of posts from most recent to oldest.
     *
     * @return array[Post]
     */
    abstract public function getListPosts(): array;

    /**
     * add.
     *
     * Method to add a post in database
     */
    abstract public function add(Post $post): bool;

    /**
     * update.
     *
     * Method to update a post in database
     */
    abstract public function update(Post $post): bool;

    /**
     * save.
     *
     * Method wich save a post in database :
     * - add it if it's new
     * - update it if it isn't new
     */
    public function save(Post $post): bool
    {
        if ($post->isValid()) {
            return empty($post->getId()) ? $this->add($post) : $this->update($post);
        }

        return false;
    }
}
