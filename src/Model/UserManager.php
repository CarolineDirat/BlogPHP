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
     * method which returns the user's pseudo, corresponding to an identifier.
     */
    abstract public function getPseudo(int $id): string;

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
