<?php
require_once "inc/headers.php";
require_once "inc/functions.php";

//Input tiedot JSON muodosta
$input = json_decode(file_get_contents("php://input"));
//Sanitoidaan.
$username = filter_var($input->username, FILTER_SANITIZE_STRING);
$password= filter_var($input->password, FILTER_SANITIZE_STRING);

try {
    $dbcon = createDbConnection();

    $hash_pw = password_hash($password, PASSWORD_DEFAULT); //salasanan hash
    $sql = "INSERT IGNORE INTO users VALUES (?,?)"; //komento, arvot parametreina
    $prepare = $dbcon->prepare($sql); //valmistellaan
    $prepare->execute(array($username, $hash_pw));  //parametrit tietokantaan

}catch(PDOException $e){
    echo '<br>'.$e->getMessage();
}

?>