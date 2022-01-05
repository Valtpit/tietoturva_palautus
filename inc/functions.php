<?php

/**
 * Tarkistaa onko käyttäjä tietokannassa ja onko salasana validi
 */
function checkUser(PDO $dbcon, $username, $password){

    //Sanitoidaan. Lisätty tuntien jälkeen
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    try{
        $sql = "SELECT password FROM users WHERE username=?";  //komento, arvot parametreina
        $prepare = $dbcon->prepare($sql);   //valmistellaan
        $prepare->execute(array($username));  //kysely tietokantaan

        $rows = $prepare->fetchAll(); //haetaan tulokset (voitaisiin hakea myös eka rivi fetch ja tarkistus)

        //Käydään rivit läpi (max yksi rivi tässä tapauksessa) 
        foreach($rows as $row){
            $pw = $row["password"];  //password sarakkeen tieto (hash salasana tietokannassa)
            if( password_verify($password, $pw) ){  //tarkistetaan salasana tietokannan hashia vasten
                return true;
            }
        }

        //Jos ei löytynyt vastaavuutta tietokannasta, palautetaan false
        return false;

    }catch(PDOException $e){
        echo '<br>'.$e->getMessage();
    }
}

/**
 * Luo tietokantaan uuden käyttäjän ja hashaa salasanan
 */
function createUser(PDO $dbcon, $username, $password){

    //Sanitoidaan.
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    try{
        $hash_pw = password_hash($password, PASSWORD_DEFAULT); //salasanan hash
        $sql = "INSERT IGNORE INTO users VALUES (?,?)"; //komento, arvot parametreina
        $prepare = $dbcon->prepare($sql); //valmistellaan
        $prepare->execute(array($username, $hash_pw));  //parametrit tietokantaan
    }catch(PDOException $e){
        echo '<br>'.$e->getMessage();
    }
}

/**
 * Luo ja palauttaa tietokantayhteyden.
 */
function createDbConnection(){
        //oman koneen xamp sanoo portiksi 3306, tehtävänannossa mainittu 3307
    try{
        $dbcon = new PDO('mysql:host=localhost:3306;dbname=n0piri01', 'root', '');
        $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo '<br>'.$e->getMessage();
    }

    return $dbcon;
}

?>