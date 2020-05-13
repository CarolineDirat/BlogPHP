<?php

namespace App\Model;

use Exception;
use PDO;

/**
 * UserManagerPDO.
 *
 * Manager of Users for a PDO connection to the database
 */
final class UserManagerPDO extends UserManager
{
    public function getPseudo(int $id): string
    {
        $req = $this->dao->prepare('SELECT pseudo FROM user WHERE id = :id');
        $req->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $req->execute();
        if ($pseudo = $req->fetch()) {
            return $pseudo['pseudo'];
        }

        throw new Exception('The nickname of the author of the article could not be recovered');
    }
}
