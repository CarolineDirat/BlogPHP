<?php
namespace App\Model;

/**
 * PostManagerPDO
 *
 * Manager of Posts, for a PDO connection to the database, $this->dao is an instance of \PDO
 */
final class PostManagerPDO extends PostManager
{
    public function getPost(int $id) : \App\Entity\Post
    {
        if (!$this->dao instanceof \PDO) {
            throw new \Exception('PostManangerPDO must use an instance of PDO to connect to a MySQL database');
        }
        $req = $this->dao
                    ->prepare('SELECT  id, title, slug, content, abstract, date_creation as dateCreation, date_update as dateUpdate, id_user as idUser FROM post WHERE id = :id');
        $req->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\App\Entity\Post', []);
        
        $req->execute();
                
        if ($post = $req->fetch()) {

            $post->setDateCreation(new \DateTime($post->getDateCreation()));
            $post->setDateUpdate(new \DateTime($post->getDateUpdate()));

            $req->closecursor();           

            return $post;
        }
        throw new \Exception('The article with id='.filter_var($id, FILTER_VALIDATE_INT).' was not found');
    }

    public function getListPosts()
    {
        if (!$this->dao instanceof \PDO) {
            throw new \Exception('PostManangerPDO must use an instance of PDO to connect to a MySQL database');
        }
        $req = $this->dao->query('SELECT  id, title, slug, content, abstract, date_creation as dateCreation, date_update as dateUpdate, id_user as idUser FROM post ORDER BY dateUpdate DESC');
        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\App\Entity\Post', []);
        $listPosts = $req->fetchAll();
        
        foreach ($listPosts as $post)
        {
            $post->setDateCreation(new \DateTime($post->getDateCreation()));
            $post->setDateUpdate(new \DateTime($post->getDateUpdate()));
        }
        
        $req->closeCursor();
        
        return $listPosts;
    }
}
