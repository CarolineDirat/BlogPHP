<?php

namespace App\Model;

use App\Entity\Post;
use DateTime;
use Exception;
use PDO;

/**
 * PostManagerPDO.
 *
 * Manager of Posts, for a PDO connection to the database, $this->dao is an instance of PDO
 */
final class PostManagerPDO extends PostManager
{
    public function getPost(int $id): Post
    {
        if (!$this->dao instanceof PDO) {
            throw new Exception('PostManangerPDO must use an instance of PDO to connect to a MySQL database');
        }
        $req = $this
            ->dao
            ->prepare('SELECT  id, title, slug, content, abstract, date_creation as dateCreation, date_update as dateUpdate, id_user as idUser FROM post WHERE id = :id')
        ;
        $req->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, '\App\Entity\Post', []);
        $req->execute();
        if ($post = $req->fetch()) {
            $post
                ->setDateCreation(new DateTime($post->getDateCreation()))
                ->setDateUpdate(new DateTime($post->getDateUpdate()))
            ;
            $req->closecursor();
            if ($post->isValid()) {
                return $post;
            }

            throw new Exception('The article collected from database, with id='.filter_var($id, FILTER_VALIDATE_INT).', is not valid, one property is empty.');
        }

        throw new Exception('The article with id='.filter_var($id, FILTER_VALIDATE_INT).' was not found');
    }

    public function getListPosts(): array
    {
        if (!$this->dao instanceof PDO) {
            throw new Exception('PostManangerPDO must use an instance of PDO to connect to a MySQL database');
        }
        $req = $this
            ->dao
            ->query('SELECT  id, title, slug, content, abstract, date_creation as dateCreation, date_update as dateUpdate, id_user as idUser FROM post ORDER BY dateUpdate DESC')
        ;
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, '\App\Entity\Post', []);
        $listPosts = $req->fetchAll();
        foreach ($listPosts as $post) {
            if (!$post->isValid()) {
                throw new Exception('The post with id='.$post->getId().' is not valid, one property is empty.');
            }
            $post
                ->setDateCreation(new DateTime($post->getDateCreation()))
                ->setDateUpdate(new DateTime($post->getDateUpdate()))
            ;
        }
        $req->closeCursor();

        return $listPosts;
    }
}
