<?php

namespace App\Model;

use App\Application\Manager;
use App\Entity\Form\Login;
use App\Entity\User;

/**
 * UserManager.
 *
 * contains the methods which concern the management of Users
 */
abstract class UserManager extends Manager
{   
    /**
     * getPseudo
     * 
     * method which returns the user's pseudo, corresponding to an identifier.
     *
     * @param  int $id
     * @return string
     */
    abstract public function getPseudo(int $id): string;

    /**
     * getPseudos
     * 
     * method which returns all user's pseudos.
     *
     * @return array
     */
    abstract public function getPseudos(): array;

    /**
     * getEmails
     * 
     * method which returns all user's emails.
     *
     * @return array
     */
    abstract public function getEmails(): array;


    /**
     * hasLogin.
     *
     * Checks if login(pseudo, password) is in database
     */
    abstract public function hasLogin(Login $login): bool;

    /**
     * getUser.
     *
     * Get user object from pseudo in the database
     */
    abstract public function getUser(string $pseudo): User;
}
