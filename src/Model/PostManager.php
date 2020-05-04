<?php
namespace App\Model;

use \App\Application\Manager;
use \App\Entity\Post;

/**
 * PostManager
 * 
 * contains the methods which concern the management of Posts
 */
abstract class PostManager extends Manager
{
  /**
   * method which returns the instance of one Post, corresponding to an identifier
   *
   * @param  int $id 
   * @return \App\Entity\Post
   */
  abstract public function getPost(int $id);
}
