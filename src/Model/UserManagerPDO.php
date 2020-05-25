<?php

namespace App\Model;

use Exception;
use PDO;
use PDOStatement;

/**
 * UserManagerPDO.
 *
 * Manager of Users for a PDO connection to the database
 */
final class UserManagerPDO extends UserManager
{
    public function getPseudo(int $id): string
    {
        if (!$this->dao instanceof PDO) {
            throw new Exception('PostManangerPDO must use an instance of PDO to connect to a MySQL database');
        }
        $req = $this->dao->prepare('SELECT pseudo FROM user WHERE id = :id');
        if (!$req instanceof PDOStatement) {
            throw new Exception('The SQL request failed');
        }
        $req->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $req->execute();
        $pseudo = $req->fetch();
        if ($pseudo) {
            return $pseudo['pseudo'];
        }

        throw new Exception('The nickname of the author of the article could not be recovered');
    }
}
