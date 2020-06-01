<?php

namespace App\Model;

use App\Entity\Post;
use DateTime;
use Exception;
use PDO;
use PDOStatement;
use Cocur\Slugify\Slugify;

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
            ->prepare(
                'SELECT post.id, title, slug, content, abstract, post.date_creation as dateCreation, post.date_update as dateUpdate, user.pseudo as author
                FROM post
                INNER JOIN user
                ON post.id_user = user.id
                WHERE post.id = :id'
            )
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('The article with id='.filter_var($id, FILTER_VALIDATE_INT).' was not found');
        }
        /*
        * Data recovery :
        * I choose not to use PDO::FETCH_CLASS, with setFetchMode(), because my post object has attributes typed in DateTime,
        * and I cannot ask the getter of a DateTime property to return a string
        * (when I want to instantiate a DateTime from the data retrieved in string from the database)
        */
        $req->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closecursor();
        // Instantiate Post object
        $data = $this->stringToDateTime($data); // dateCreation and dateUpdate must be instantiations of DateTime
        $post = new Post($data);
        if ($post->isValid()) {
            return $post;
        }

        throw new Exception('The article collected from database, with id='.filter_var($id, FILTER_VALIDATE_INT).', is not valid, at least one property is empty.');
    }

    public function getListPosts(): array
    {
        if (!$this->dao instanceof PDO) {
            throw new Exception('PostManangerPDO must use an instance of PDO to connect to a MySQL database');
        }
        // Resquest to the MySQL bdd
        $req = $this
            ->dao
            ->query('SELECT  id, title, slug, content, abstract, date_creation as dateCreation, date_update as dateUpdate, id_user as idUser FROM post ORDER BY dateUpdate DESC')
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('PDO request failed');
        }
        /**
         * Data recovery :
         * I choose not to use PDO::FETCH_CLASS, with setFetchMode(), because my post object has attributes typed in DateTime,
         * and I cannot ask the getter of a DateTime property to return a string
         * (when I want to instantiate a DateTime from the data retrieved in string from the database).
         */
        $dataArray = $req->fetchAll();
        $req->closeCursor();
        // build array of Post objects
        $listPosts = [];
        if (is_array($dataArray)) {
            foreach ($dataArray as $data) {
                $data = $this->stringToDateTime($data); // dateCreation and dateUpdate must be instantiations of DateTime
                $post = new Post($data);
                if (!$post->isValid()) {
                    throw new Exception('The post with id='.$post->getId().' is not valid, one property is empty.');
                }
                $listPosts[] = $post;
            }
        }

        return $listPosts;
    }

    /**
     * stringToDateTime.
     *
     * dateCreation and dateUpdate, Post's properties, must be instantiations of DateTime
     */
    public function stringToDateTime(array $data): array
    {
        $data['dateCreation'] = new DateTime($data['dateCreation']);
        $data['dateUpdate'] = new DateTime($data['dateUpdate']);

        return $data;
    }

    /**
     * add.
     *
     * Method to add a post in database
     */
    public function add(Post $post): bool
    {
        $slugify = new Slugify();
        if (!$this->dao instanceof PDO) {
            throw new Exception('PostManangerPDO must use an instance of PDO to connect to a MySQL database');
        }
        // Resquest to the MySQL bdd
        $req = $this
            ->dao
            ->prepare(
                'INSERT INTO post (title, slug, content, abstract, date_creation, date_update, id_user )
                VALUES ( :title, :slug, :content, :abstract, NOW(), NOW(), :idUser )'
            )
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('PDO request failed');
        }
        $slugify = new Slugify();
        $req->bindValue(':title', $post->getTitle());
        $req->bindValue(':slug', $slugify->slugify($post->getTitle()));
        $req->bindValue(':content', $post->getContent());
        $req->bindValue(':abstract', $post->getAbstract());
        $req->bindValue(':idUser', $post->getIdUser(), PDO::PARAM_INT);
        $result = $req->execute();
        $req->closeCursor();

        return $result;
    }

    /**
     * update.
     *
     * Method to update a post in database
     */
    public function update(Post $post): bool
    {
        if (!$this->dao instanceof PDO) {
            throw new Exception('postManangerPDO must use an instance of PDO to connect to a MySQL database');
        }
        // Resquest to the MySQL bdd
        $req = $this
            ->dao
            ->prepare(
                'UPDATE post 
                SET title = :title, slug = :slug, content = :content, abstract = :abstract, date_update = NOW()
                WHERE id = :idPost'
            )
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('PDO request failed');
        }
        $slugify = new Slugify();
        $req->bindValue(':title', $post->getTitle());
        $req->bindValue(':slug', $slugify->slugify($post->getTitle()));
        $req->bindValue(':content', $post->getContent());
        $req->bindValue(':abstract', $post->getAbstract());
        $result = $req->execute();
        $req->closeCursor();

        return $result;
    }
}
