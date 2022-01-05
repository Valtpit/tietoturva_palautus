<?php
require_once "inc/headers.php";
require_once "inc/functions.php";

if(isset($_SERVER["PHP_AUTH_USER"])){
    if(checkUser(createDbConnection(), $_SERVER["PHP_AUTH_USER"], $_SERVER["PHP_AUTH_PW"])){
        echo "salasana oikein, kirjauduttu sisään.";
        exit;
    }
}

header("WWW-Authenticate: Basic");
exit;

?>