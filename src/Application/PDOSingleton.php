<?php

namespace App\Application;

use PDO;

/**
 * PDOSingleton.
 *
 * to get the connection to the database (MySQL) by PDO
 * must be instantiated only once
 */
final class PDOSingleton
{
    /**
     * instance.
     *
     * Will contain the instance of our class
     *
     * @var bool|PDOSingleton
     */
    private static $instance = false;

    /**
     * connection.
     *
     * connection to the database (MySQL) by PDO
     *
     * @var PDO
     */
    private $connection;

    private function __construct() // must be private for the Singleton pattern
    {
        $this->connection = new PDO(PDO_DSN, USER, PASSWD); // @phpstan-ignore-line
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function __clone() // must be private for the Singleton pattern
    {
    }

    public static function getInstance(): PDOSingleton
    {
        if (false === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnexion(): PDO
    {
        return $this->connection;
    }
}
