<?php
namespace App\Model;

use \App\Entity\User;

class UserManagerPDO extends UserManager
{
    public function getPseudo(int $id) : string
    {
        $sql = 'SELECT pseudo FROM user WHERE id = :id';
        $req = $this->dao->prepare($sql);
        $req->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $req->execute();
        
        if($pseudo = $req->fetch()){
            return $pseudo
        } else {
            throw new \Exception('le pseudo de l\'auteur de l\'article n\'a pas pu être récupéré');
        }
        
        return null;
    }

}

