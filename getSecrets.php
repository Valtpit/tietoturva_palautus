<?php
require_once "inc/headers.php";
require_once "inc/functions.php";

try {
    $dbcon = createDbConnection();

    $sql = "SELECT secret FROM secrets WHERE username=?";
    $prepare = $dbcon->prepare($sql);   //valmistellaan
    $prepare->execute(array($_SERVER["PHP_AUTH_USER"]));  //kysely tietokantaan
    
    

}catch(PDOException $e){
    echo '<br>'.$e->getMessage();
}

?>