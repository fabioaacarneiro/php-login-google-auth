<?php

use app\database\Connection;
use app\library\GoogleClient;
use app\models\User;

require "../vendor/autoload.php";

$googleClient = new GoogleClient();
$googleClient->init();
$googleClient->authorized();

$authUrl = $googleClient->generateAuthLink();

Connection::initConnection();

// echo "<pre>";
// var_dump(User::select());

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