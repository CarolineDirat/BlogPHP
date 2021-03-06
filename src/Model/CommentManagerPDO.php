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
    public function __construct(PDO $dao)
    {
        $this->dao = $dao;
    }

    /**
     * getComment.
     *
     * Method which return a comment from database with its id's post
     */
    public function getComment(int $id): Comment
    {
        // Resquest to the MySQL bdd
        $req = $this
            ->dao
            ->prepare(
                'SELECT comment.id, content, comment.date_creation as dateCreation, comment.status, id_post as idPost, id_user as idUser,user.pseudo as author, user.email as email
                FROM comment
                INNER JOIN user
                ON comment.id_user = user.id
                WHERE comment.id = :id'
            )
        ;
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        // Instanciate the comment
        $data['dateCreation'] = new DateTime($data['dateCreation']); // dateCreation must be instantiations of DateTime
        $comment = new Comment($data);
        if ($comment->isValid()) {
            return $comment;
        }

        throw new Exception('The comment collected from database, with id='.filter_var($id, FILTER_VALIDATE_INT).', is not valid, at least one property is empty.');
    }

    /**
     * getAllComments.
     *
     * Method which returns a list of all comments of one post, from most recent to oldest.
     *
     * @return array[Comment]
     */
    public function getAllComments(int $idPost): array
    {
        $sql = 'SELECT comment.id as id, content, comment.date_creation as dateCreation, comment.status, id_post as idPost, user.pseudo as author
                FROM comment
                INNER JOIN user
                ON comment.id_user = user.id
                WHERE comment.id_post = :id
                ORDER BY dateCreation'
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
        $sql = "SELECT comment.id as id, content, comment.date_creation as dateCreation, comment.status, id_post as idPost, user.pseudo as author
                FROM comment
                INNER JOIN user
                ON comment.id_user = user.id
                WHERE comment.id_post = :id
                AND comment.status = 'valid'
                ORDER BY dateCreation"
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
     * getNbWaitingComments.
     *
     * Method which returns the number of waiting comments for one post
     *
     * @return int
     */
    public function getNbWaitingComments(int $idPost): int
    {
        // Resquest to the MySQL bdd
        $req = $this
            ->dao
            ->prepare(
                "SELECT COUNT(*) FROM comment WHERE comment.id_post = :id AND comment.status = 'waiting'"
            )
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('PDO request failed');
        }
        $req->bindValue(':id', $idPost, PDO::PARAM_INT);
        $req->execute();
        $nbWaitingComments = $req->fetch();
        $req->closeCursor();

        return (int) $nbWaitingComments[0];
    }

    /**
     * add.
     *
     * Method to add a comment in database
     */
    public function add(Comment $comment): bool
    {
        // Resquest to the MySQL bdd
        $req = $this
            ->dao
            ->prepare(
                'INSERT INTO comment ( content, date_creation, status, id_post, id_user )
                VALUES ( :content, NOW(), :status, :idPost, :idUser )'
            )
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('PDO request failed');
        }
        $req->bindValue(':content', $comment->getContent(), PDO::PARAM_STR);
        $req->bindValue(':status', 'waiting', PDO::PARAM_STR);
        $req->bindValue(':idPost', $comment->getIdPost(), PDO::PARAM_INT);
        $req->bindValue(':idUser', $comment->getIdUser(), PDO::PARAM_INT);
        $result = $req->execute();
        $req->closeCursor();

        return $result;
    }

    /**
     * update.
     *
     * Method to update a comment in database
     */
    public function update(Comment $comment): bool
    {
        // Resquest to the MySQL bdd
        $req = $this
            ->dao
            ->prepare(
                'UPDATE comment 
                SET content = :content, comment.status = :statuss
                WHERE id = :id'
            )
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('PDO request failed');
        }
        $req->bindValue(':content', $comment->getContent(), PDO::PARAM_STR);
        $req->bindValue(':statuss', $comment->getStatus(), PDO::PARAM_STR);
        $req->bindValue(':id', $comment->getId(), PDO::PARAM_INT);
        $result = $req->execute();
        $req->closeCursor();

        return $result;
    }

    /**
     * delete.
     *
     * delete a comment from database
     */
    public function delete(int $id): bool
    {
        // Resquest to the MySQL bdd
        $req = $this
            ->dao
            ->prepare('DELETE FROM comment WHERE comment.id = :id')
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('PDO prepared request failed');
        }
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $result = $req->execute();
        $req->closeCursor();

        return $result;
    }
}
