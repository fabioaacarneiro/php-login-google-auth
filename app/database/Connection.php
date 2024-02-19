<?php

namespace app\database;

use PDO;
use Dotenv\Dotenv;

abstract class Connection
{


    private static $dbSystem = "";
    private static $host = "";
    private static $port = "";
    private static $user = "";
    private static $password = "";
    private static $database = "";

    public static function initConn()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../..");
        $dotenv->load();

        static::$dbSystem = $_ENV["DATABASEMANAGER"];
        static::$host = $_ENV["HOST"];
        static::$port = $_ENV["PORT"];
        static::$database = $_ENV["DATABASE_POSTGRES"];
        static::$user = $_ENV["USER_POSTGRES"];
        static::$password = $_ENV["PASSWORD_POSTGRES"];

        $pdo = new PDO(
            static::$dbSystem .
                ":host=" . static::$host .
                ";port=" . static::$port .
                ";dbname=" . static::$database,
            static::$user,
            static::$password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        // id firstName lastName email password avatar
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                firstName VARCHAR(50),
                lastName VARCHAR(50),
                email VARCHAR(150),
                password VARCHAR(255),
                avatar VARCHAR(255)
            )");
    }
}
