<?php

namespace App\Model;

use App\Entity\Form\Login;
use App\Entity\User;
use DateTime;
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
            throw new Exception('The SQL request failed with getPseudo($id)');
        }
        $req->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $req->execute();
        $pseudo = $req->fetch();
        $req->closeCursor();
        if ($pseudo) {
            return $pseudo['pseudo'];
        }

        throw new Exception('The nickname of the author of the article could not be recovered');
    }

    public function hasLogin(Login $login): bool
    {
        if (!$this->dao instanceof PDO) {
            throw new Exception('PostManangerPDO must use an instance of PDO to connect to a MySQL database');
        }
        // check the presence of the pseudo in the database
        $pseudo = $login->getPseudo();
        $req = $this->dao->prepare('SELECT user.password FROM user WHERE pseudo = :pseudo');
        if (!$req instanceof PDOStatement) {
            throw new Exception('The SQL request failed with hasLogin($login)');
        }
        $req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $req->execute();
        $data = $req->fetch();
        $req->closeCursor();
        $password = $data['password'];
        if (empty($password)) {
            return false;
        }
        // checks password
        if (!empty($login->getPassword())) {
            return password_verify($login->getPassword(), $password);
        }
        
        return false;
    }

    public function getUser(?string $pseudo): User
    {
        if (!$this->dao instanceof PDO) {
            throw new Exception('PostManangerPDO must use an instance of PDO to connect to a MySQL database');
        }
        $req = $this->dao->prepare(
            'SELECT user.id, pseudo, user.password, user.email, date_creation as dateCreation, user.enabled, role_user.role
            FROM user
            INNER JOIN role_user
            ON user.id = role_user.id 
            WHERE pseudo = :pseudo'
        );
        if (!$req instanceof PDOStatement) {
            throw new Exception('The SQL request failed with getUser($pseudo)');
        }
        $req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $req->execute();
        $data = $req->fetch();
        $req->closeCursor();
        // Instantiate User object
        $data['dateCreation'] = new DateTime($data['dateCreation']); // dateCreation must be instantiations of DateTime
        $user = new User($data);
        if (!$user->isValid()) {
            throw new Exception('The user '.$user->getPseudo().' with id='.$user->getId().' is not valid, at least one property is empty.');
        }

        return $user;
    }
}
