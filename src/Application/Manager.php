<?php

namespace App\Application;

/**
 * Manager.
 *
 * manager inherited from managers of entities, retrieves the connection to the database when instantiating a manager
 */
abstract class Manager
{
    /**
     * dao : the connection to the database.
     *
     * @var object
     */
    protected $dao;

    public function __construct(object $dao)
    {
        $this->dao = $dao;
    }
}
