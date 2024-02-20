<?php

use app\database\Connection;
use app\library\Authenticate;
use app\library\GoogleClient;
use app\models\User;

require "../vendor/autoload.php";

session_start();

$googleClient = new GoogleClient();
$googleClient->init();
$auth = new Authenticate;

if ($googleClient->authorized()) {
    $auth->authGoogle($googleClient->getData());
    echo "authenticated!";
}

if (isset($_GET["logout"])) {
    $auth->logout();
}

$authUrl = $googleClient->generateAuthLink();

Connection::initConnection();

// echo "<pre>";
// User::store("Fabio", "Carneiro", "fabio@email.com", "senha");
// User::store("Benidito", "Cunha", "bene@email.com", "senha");
// User::update(6, "Benedito", "Cunha", "bene@email.com", "senha");

// User::delete(7);

// $usersList = User::select(false);
// var_dump($usersList);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Document</title>
</head>

<body>

    <div class="header header-primary">
        <div class="header-start">
            <?php
            if (isset($_SESSION["user"])) {
                echo '<p class="alert alert-success">Olá, ' . $_SESSION["user"]->firstname . ' ' . $_SESSION["user"]->lastname . '</p>';
            }
            ?>
        </div>
        <div class="header-end">
            <?php
            if (isset($_SESSION["user"])) {
                echo '<a href="?logout=true" class="btn btn-alert">Deslogar</a>';
            } else {
                echo '<a href="/signup" class="btn btn-secondary">Cadastrar</a>';
            }
            ?>
        </div>
    </div>

    <div class="container">
        <form class="form-container" action="">
            <input class="form-input" type="text" name="email" placeholder="email">
            <input class="form-input" type="text" name="password" placeholder="password">
            <button class="btn btn-primary" type="submit">Login</button>
            <a class="btn btn-primary" href="<?php echo $authUrl ?>">Login with google</a>
        </form>
    </div>
</body>

</html>