<?php

use app\database\Connection;
use app\library\GoogleClient;

require "../vendor/autoload.php";

$googleClient = new GoogleClient();
$googleClient->init();
$googleClient->authorized();

$authUrl = $googleClient->generateAuthLink();

Connection::initConn();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="">
        <input type="text" name="email" placeholder="email">
        <input type="text" name="password" placeholder="password">
        <button type="submit">Login</button>
        <a href="<?php echo $authUrl ?>">Login with google</a>
    </form>
</body>

</html>