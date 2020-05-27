<?php

namespace App\Model;

use App\Entity\Comment;
use DateTime;
use Exception;
use PDO;
use PDOStatement;

/**
 * CommentManagerPDO.
 *
 * Manager of Comments, for a PDO connection to the database, $this->dao is an instance of PDO
 */
final class CommentManagerPDO extends CommentManager
{
    /**
     * getAllComments.
     *
     * Method which returns a list of all comments of one post, from most recent to oldest.
     *
     * @return array[Comment]
     */
    public function getAllComments(int $idPost): array
    {
        $sql = 'SELECT comment.id as id, content, comment.date_creation as dateCreation, permit, id_post as idPost, user.pseudo as author
                FROM comment
                INNER JOIN user
                ON comment.id_user = user.id
                WHERE comment.id_post = :id
                ORDER BY dateCreation DESC'
        ;

        return $this->getListComments($sql, $idPost);
    }

    /**
     * getValidComments.
     *
     * Method which returns a list of VALID comments of one post, from most recent to oldest.
     *
     * @return array[Comment]
     */
    public function getValidComments(int $idPost): array
    {
        $sql = "SELECT comment.id as id, content, comment.date_creation as dateCreation, permit, id_post as idPost, user.pseudo as author
                FROM comment
                INNER JOIN user
                ON comment.id_user = user.id
                WHERE comment.id_post = :id
                AND comment.permit = 'valid'
                ORDER BY dateCreation DESC"
        ;

        return $this->getListComments($sql, $idPost);
    }

    /**
     * getListComments.
     *
     * Method which returns a list of comments of one post, from most recent to oldest.
     *
     * @param string $sql    SQL request to get a list of comments of one post, wich can be customize
     *                       but with only one param : idPost
     * @param int    $idPost Post's id
     *
     * @return array[Comment]
     */
    public function getListComments(string $sql, int $idPost): array
    {
        if (!$this->dao instanceof PDO) {
            throw new Exception('commentManangerPDO must use an instance of PDO to connect to a MySQL database');
        }
        // Resquest to the MySQL bdd
        $req = $this
            ->dao
            ->prepare($sql)
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('PDO request failed');
        }
        /*
         * Data recovery :
         * I choose not to use PDO::FETCH_CLASS, with setFetchMode(), because my comment object has attribute typed in DateTime,
         * and I cannot ask the getter of a DateTime property to return a string
         * (when I want to instantiate a DateTime from the data retrieved in string from the database).
         */
        $req->bindValue(':id', $idPost, PDO::PARAM_INT);
        $req->execute();
        $dataArray = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        // build array of comment objects
        $listComments = [];
        if (is_array($dataArray)) {
            foreach ($dataArray as $data) {
                $data['dateCreation'] = new DateTime($data['dateCreation']); // dateCreation must be an instantiation of DateTime
                $comment = new comment($data);
                if (!$comment->isValid()) {
                    throw new Exception('The comment with id='.$comment->getId().' is not valid, at least one property is empty.');
                }
                $listComments[] = $comment;
            }
        }

        return $listComments;
    }
    /**
     * add
     * 
     * Method to add a comment in database
     *
     * @param  Comment $comment
     * @return void
     */
    public function add(Comment $comment): void
    {
        if (!$this->dao instanceof PDO) {
            throw new Exception('commentManangerPDO must use an instance of PDO to connect to a MySQL database');
        }
        // Resquest to the MySQL bdd
        $req = $this
            ->dao
            ->prepare(
                'INSERT INTO comment 
                SET content = :content, date_creation = NOW(), permit = :permit, id_post = :idPost, id_user = :idUser'
            )
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('PDO request failed');
        }
        $req->bindValue(':content', $comment->getContent(), PDO::PARAM_STR);
        $req->bindValue(':permit', 'waiting', PDO::PARAM_STR);
        $req->bindValue(':idPost', $comment->getIdPost(), PDO::PARAM_INT);
        $req->bindValue(':idUser', $comment->getIdUser(), PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
        //$comment->setId($this->dao->lastInsertId());
    }

    /**
     * modify
     * 
     * Method to modify a comment in database
     *
     * @param  Comment $comment
     * @return void
     */
    public function modify(Comment $comment): void
    {
        if (!$this->dao instanceof PDO) {
            throw new Exception('commentManangerPDO must use an instance of PDO to connect to a MySQL database');
        }
        // Resquest to the MySQL bdd
        $req = $this
            ->dao
            ->prepare(
                'UPDATE comment 
                SET content = :content, permit = :permit
                WHERE id = :id'
            )
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('PDO request failed');
        }
        $req->bindValue(':content', $comment->getContent(), PDO::PARAM_STR);
        $req->bindValue(':permit', $comment->getPermit(), PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }
}
