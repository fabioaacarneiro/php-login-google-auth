<?php

namespace app\models;

use app\database\Connection;
use PDO;

abstract class User
{

    private $pdo = Connection::getConnection();

    static public function store(string $firstName, string $lastName, string $email, string $password, string $avatar = null)
    {
        $stmt = static::$pdo->prepare("INSERT INTO users (firstName, lastName, email, password, avatar) VALUES (:nome, :email, :senha)");
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
        $stmt = static::$pdo->prepare("UPDATE users SET nome = :nome, email = :email, senha = :senha WHERE id = :id");
        $stmt->execute([
            ":id" => $id,
            ":firstName" => $firstName,
            ":lastName" => $lastName,
            ":email" => $email,
            ":password" => $password,
            ":avatar" => $avatar,
        ]);
    }

    public static function delete($id)
    {
        $stmt = static::$pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->execute(array(':id' => $id));
    }

    public static function select(int $quantity = null)
    {
        if (is_null($quantity)) {
            $stmt = static::$pdo->prepare("SELECT * FROM public.users");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } else {
            $stmt = static::$pdo->prepare("SELECT * FROM public.users ORDER BY id DESC LIMIT $quantity");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        }
    }
}
