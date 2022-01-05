<?php
require_once "inc/headers.php";
require_once "inc/functions.php";

$input = json_decode(file_get_contents("php://input"));
$username = filter_var($input->username, FILTER_SANITIZE_STRING);
$secret= filter_var($input->secret, FILTER_SANITIZE_STRING);

if(isset($_SERVER["PHP_AUTH_USER"])){
    try {
        $db = createDbConnection();

        $query = $db->prepare("insert into secrets (username, secret) values (:username, :secret)");
        $query->bindValue(":username",$username,PDO::PARAM_STR);
        $query->bindValue(":secret",$secret,PDO::PARAM_STR);
        $query->execute();

    }catch(PDOException $e){
        echo '<br>'.$e->getMessage();
    }
} else {
    echo "ei kirjautuneena";
}
    
?>