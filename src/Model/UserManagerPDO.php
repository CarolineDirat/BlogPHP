<?php

namespace App\Model;

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
        $req->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $req->execute();

        if ($pseudo = $req->fetch()) {
            return $pseudo['pseudo'];
        }

        throw new \Exception('le pseudo de l\'auteur de l\'article n\'a pas pu être récupéré');
    }
}
