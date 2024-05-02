<?php

namespace app\database;

use PDO;
use PDOException;

class Database
{
    private static string $datasource = 'pgsql:host=localhost;port=5432;dbname=produtos_db;';
    private static string $username = 'postgres';
    private static string $password = 'root';
    private static PDO|NULL $database;

    private function __construct(){}

    public static function getConnection () {
        if(!isset(self::$database)){
            try{
                self::$database = new PDO(self::$datasource, self::$username, self::$password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
                exit();
            }
        }
        return self::$database;
    }

    public static function close () {
        return self::$database = NULL;
    }
}