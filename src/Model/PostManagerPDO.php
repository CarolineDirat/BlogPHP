<?php
namespace App\Model;

use \App\Entity\Post;

class PostManagerPDO extends PostManager
{    
    /**
     * getPost
     *
     * @param  int $id
     * @return App\Entity\Post
     */
    public function getPost(int $id)
    {
        $sql = 'SELECT  id, title, slug, content, abstract, date_creation as dateCreation, date_update as dateUpdate, id_user as idUser FROM post WHERE id = :id';
        $req = $this->dao->prepare($sql);
        $req->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $req->execute();
        
        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\App\Entity\Post');
        
        if ($post = $req->fetch())
        {
            $post->setDateCreation(new \DateTime($post->getDateCreation()));
            $post->setDateUpdate(new \DateTime($post->getDateUpdate()));
            
            return $post;
        } else {
            throw new \Exception('un problème lors de la récupération de l\'article');
        }
        
        return null;
    }

}

