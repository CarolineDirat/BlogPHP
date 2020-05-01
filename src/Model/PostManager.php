<?php
namespace App\Model;

use \App\Application\Manager;

abstract class PostManager extends Manager
{
  /**
   * method which returns the instance of one Post, corresponding to an identifier
   *
   * @param  int $id 
   * @return Post
   */
  abstract public function getPost(int $id);
}