<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost'); //vart servern ligger
define('DB_USERNAME', 'login_user'); //namn på usern jag skapat
define('DB_PASSWORD', 'hej123'); //lösenord
define('DB_NAME', 'login_db'); //databasen jag skapat

//försök att connecta SQL
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//är den connectad
if($link == false){
    die("ERROR: Could not connect" . mysqli_connect_error());
}

?>