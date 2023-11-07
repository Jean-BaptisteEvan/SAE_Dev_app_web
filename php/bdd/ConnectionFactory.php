<?php

namespace iutnc\touiteur\bdd;

use Exception;
use PDO;

/**
 * Class for connecting to the database
 * Usage :
 *
 * ConnectionFactory::makeConnection();
 * $bdd = ConnectionFactory::$bdd;
 */
class ConnectionFactory {

    /**
     * @var $bdd PDO Stores the connection to the database in a static attribute
     */
    public static $bdd;

    /**
     * Create a connection to the database
     * @return void
     */
    public static function makeConnection() {
        try {
            $bdd = new PDO("mysql:host=localhost; dbname=touiteur; charset=utf8","root", "");
            $bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$bdd = $bdd;
        } catch(Exception $e) {
            die('erreur: '.$e->getMessage());
        }
    }
}