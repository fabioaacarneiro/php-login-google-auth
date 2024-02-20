<?php

namespace app\library;

use app\models\User;

class Authenticate
{

    public function authGoogle($data)
    {
        $userFound = User::selectBy("email", $data->email);
        if (!$userFound) {
            User::store(
                $data->givenName,
                $data->familyName,
                $data->email,
                $data->picture
            );
        }

        $_SESSION["user"] = $userFound;
        $_SESSION["auth"] = true;
        header("Location:/");
    }

    public function logout()
    {
        unset($_SESSION["user"], $_SESSION["auth"]);
        header("Location:/");
    }
}
