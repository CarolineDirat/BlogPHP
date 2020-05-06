<?php
namespace App\Application;

use \PDO;

/**
 * PDOSingleton
 *
 * to get the connection to the database (MySQL) by PDO
 * must be instantiated only once
 */
final class PDOSingleton
{
    /**
     * instance
     *
     * Will contain the instance of our class
     *
     * @var PDOSingleton | bool
     */
    private static $instance = false;
    
    /**
     * connexion
     *
     * connection to the database (MySQL) by PDO
     *
     * @var PDO
     */
    protected $connexion;

    private function __construct() // must be private for the Singleton pattern
    {
        $this->connexion = new PDO(PDO_DSN, USER, PASSWD); // @phpstan-ignore-line
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function __clone() // must be private for the Singleton pattern
    {
    }

    public static function getInstance() : PDOSingleton
    {
        if (self::$instance === false) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnexion() : PDO
    {
        return $this->connexion;
    }
}
