<?php

namespace app\models;

use app\database\Connection;
use Exception;
use PDO;

class User
{

    private $pdo;

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    static public function store(string $firstName, string $lastName, string $email, string $password, string $avatar = null)
    {
        $user = new static();
        $stmt = $user->pdo->prepare("INSERT INTO users (firstname, lastname, email, password, avatar) VALUES (:firstName, :lastName, :email, :password, :avatar)");
        $stmt->execute([
            ":firstName" => $firstName,
            ":lastName" => $lastName,
            ":email" => $email,
            ":password" => $password,
            ":avatar" => $avatar,
        ]);
    }
    static public function update(string $id, string $firstName, string $lastName, string $email, string $password, string $avatar = null)
    {
        $user = new static();

        $stmt = $user->pdo->prepare("UPDATE users SET firstname = :firstName, lastname = :lastName, email = :email, password = :password, avatar = :avatar WHERE id = :id");
        $stmt->execute([
            ":id" => $id,
            ":firstName" => $firstName,
            ":lastName" => $lastName,
            ":email" => $email,
            ":password" => $password,
            ":avatar" => $avatar,
        ]);
    }

    public static function delete(int $id)
    {
        $user = new static();
        $stmt = $user->pdo->prepare("DELETE FROM public.users  WHERE id = :id");
        $stmt->execute(array(':id' => $id));
    }

    public static function select(bool $start = false, int $quantity = null)
    {
        $user = new static();
        $users = [];
        $stmt = "";

        if (is_null($quantity)) {
            $stmt = $user->pdo->prepare("SELECT * FROM public.users");
        } else {
            $stmt = $user->pdo->prepare("SELECT * FROM public.users LIMIT " . $quantity);
        }

        try {
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $th) {
            $th->getMessage();
        }

        $users = ($start) ? $users : array_reverse($users);

        return $users;
    }

    public static function selectBy(string $field, mixed $value)
    {
        $user = new static();
        $userFound = null;

        try {
            $stmt = $user->pdo->prepare("SELECT * FROM public.users WHERE $field = :$field");
            $stmt->execute([$field => $value]);
            $userFound = $stmt->fetchObject();
        } catch (Exception $excp) {
            var_dump($excp->getMessage());
        }

        return $userFound;
    }
}
