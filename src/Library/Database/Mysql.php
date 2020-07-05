<?php

namespace NanoPHP\Library\Database;

class Mysql implements DatabaseInterface
{
    public static $dbInstance = null;
    
    private function __construct()
    {
    }

    public static function getInstance(array $options): \PDO
    {
        try {
            $hostname = $options["DB_HOST"];
            $dbname   = $options["DB_NAME"];
            $user     = $options["DB_USER"];
            $pass     = $options["DB_PASS"];
            
            if (static::$dbInstance == null) {
                static::$dbInstance = new \PDO("mysql:host=$hostname;dbname=$dbname", $user, $pass, [\PDO::ATTR_PERSISTENT => true]);
            }

            return static::$dbInstance;
        } catch (\PDOException $e) {
            echo "Errore: " . $e->getMessage();
            die();
        }
        
        return null;
    }
}
