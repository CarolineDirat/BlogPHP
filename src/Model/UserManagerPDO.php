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
    public function __construct(PDO $dao)
    {
        $this->dao = $dao;
    }

    public function getPseudo(int $id): string
    {
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

    public function getPseudos(): array
    {
        $req = $this->dao->query('SELECT pseudo FROM user');
        if (!$req instanceof PDOStatement) {
            throw new Exception('The SQL request failed with getPseudos()');
        }
        $pseudos = $req->fetchAll(PDO::FETCH_COLUMN);
        $req->closeCursor();
        //var_dump($pseudos);exit;
        if (false !== $pseudos) {
            return $pseudos;
        }

        throw new Exception('fetchAll() line 64 in getEmails() failed');
    }

    public function getEmails(): array
    {
        $req = $this->dao->query('SELECT email FROM user');
        if (!$req instanceof PDOStatement) {
            throw new Exception('The SQL request failed with getEamils()');
        }
        $emails = $req->fetchAll(PDO::FETCH_COLUMN);
        $req->closeCursor();
        //var_dump($emails);exit;
        if (false !== $emails) {
            return $emails;
        }

        throw new Exception('fetchAll() line 64 in getEmails() failed');
    }

    public function hasLogin(Login $login): bool
    {
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
        $req = $this->dao->prepare(
            'SELECT user.id, pseudo, user.password, user.email, date_creation as dateCreation, user.activation_key as activationKey, user.enabled, role_user.role
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

    public function add(User $user): bool
    {
        // Resquest to the MySQL bdd
        $req = $this
            ->dao
            ->prepare(
                'INSERT INTO user ( pseudo, password, email, date_creation, activation_key, enabled )
                VALUES ( :pseudo, :password, :email, NOW(), :activation_key, :enabled )'
            )
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('PDO request to add user failed');
        }
        $req->bindValue(':pseudo', $user->getPseudo());
        $req->bindValue(':password', password_hash($user->getPassword(), PASSWORD_DEFAULT)); // hash password
        $req->bindValue(':email', $user->getEmail());
        $req->bindValue(':activation_key', sha1(microtime().$user->getPseudo()));
        $req->bindValue(':enabled', 1, PDO::PARAM_INT);
        $result = $req->execute();
        $req->closeCursor();
        if (!$result) {
            throw new Exception('Insert request to add user failed');
        }
        // now we add role to user, adding user id and his role in user_role table
        $idUser = $this->dao->lastInsertId();
        $req = $this
            ->dao
            ->prepare(
                'INSERT INTO role_user ( id, role )
                VALUES ( :id, :role )'
            )
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('PDO request to add user in role_user failed');
        }
        $req->bindValue(':id', $idUser, PDO::PARAM_INT);
        $req->bindValue(':role', $user->getRole());
        $result = $req->execute();
        $req->closeCursor();

        return $result;
    }

    public function update(User $user): bool
    {
        // Resquest to the MySQL bdd
        $req = $this
            ->dao
            ->prepare(
                'UPDATE user 
                SET enabled = :enabled
                WHERE user.id = :id'
            )
        ;
        if (!$req instanceof PDOStatement) {
            throw new Exception('PDO request to update user failed');
        }
        $req->bindValue(':enabled', $user->getEnabled(), PDO::PARAM_INT);
        $req->bindValue(':id', $user->getId(), PDO::PARAM_INT);
        $result = $req->execute();
        $req->closeCursor();

        return $result;
    }
}
