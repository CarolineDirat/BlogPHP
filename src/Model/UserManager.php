<?php

namespace App\Model;

use App\Application\Manager;

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
}
