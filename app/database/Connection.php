<?php

namespace app\database;

use PDO;
use Dotenv\Dotenv;

class Connection
{
    private $dotenv;
    private $databaseManager = "";
    private $host = "";
    private $port = "";
    private $username = "";
    private $password = "";
    private $database = "";

    function __construct()
    {

        if (!isset($this->dotenv)) {
            $this->dotenv = Dotenv::createImmutable(__DIR__ . "/../..");
        }

        $this->dotenv->load();
        $this->databaseManager = $_ENV["DATABASEMANAGER"];
        $this->host = $_ENV["HOST"];
        $this->port = $_ENV["PORT"];
        $this->database = $_ENV["DATABASE_POSTGRES"];
        $this->username = $_ENV["USER_POSTGRES"];
        $this->password = $_ENV["PASSWORD_POSTGRES"];
    }

    public static function initConnection()
    {
        $connection = new static();
        $connection->getConnection();
    }

    public function getConnection()
    {

        $pdo = new PDO(
            $this->databaseManager .
            ":host=" . $this->host .
            ";port=" . $this->port .
            ";dbname=" . $this->database,
            $this->username,
            $this->password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            firstName VARCHAR(50),
            lastName VARCHAR(50),
            email VARCHAR(150),
            password VARCHAR(255),
            avatar VARCHAR(255) NULL
        )");

        return $pdo;
    }
}
