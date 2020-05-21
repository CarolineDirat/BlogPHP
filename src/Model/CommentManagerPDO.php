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
     * getListComments.
     *
     * Method which returns a list of all comments from most recent to oldest. 
     * 
     * @return array[Comment]
     */
    public function getListComments(int $idPost): array
    {
        if (!$this->dao instanceof PDO) {
            throw new Exception('commentManangerPDO must use an instance of PDO to connect to a MySQL database');
        }
        // Resquest to the MySQL bdd
        $req = $this
            ->dao
            ->prepare(
                'SELECT comment.id as id, content, comment.date_creation as dateCreation, permit, id_post as idPost, user.pseudo as author
                FROM comment
                INNER JOIN user
                ON comment.id_user = user.id
                WHERE comment.id_post = :id
                ORDER BY dateCreation DESC'
            )
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('PDO request failed');
        }
        /**
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
                $listComments[] = $comment;   
            }    
        }
        return $listComments;
    }

    /**
     * getListComments.
     *
     * Method which returns a list of VALID comments from most recent to oldest. 
     * 
     * @return array[Comment]
     */
    public function getListValidComments(int $idPost): array
    {
        if (!$this->dao instanceof PDO) {
            throw new Exception('commentManangerPDO must use an instance of PDO to connect to a MySQL database');
        }
        // Resquest to the MySQL bdd
        $req = $this
            ->dao
            ->prepare(
                "SELECT comment.id as id, content, comment.date_creation as dateCreation, permit, id_post as idPost, user.pseudo as author
                FROM comment
                INNER JOIN user
                ON comment.id_user = user.id
                WHERE comment.id_post = :id
                AND comment.permit = 'valid'
                ORDER BY dateCreation DESC"
            )
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('PDO request failed');
        }
        /**
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
        $listValidComments = [];
        if (is_array($dataArray)) {
            foreach ($dataArray as $data) {
                $data['dateCreation'] = new DateTime($data['dateCreation']); // dateCreation must be an instantiation of DateTime
                $comment = new comment($data);
                $listValidComments[] = $comment;   
            }    
        }
        return $listValidComments;
    }
}
