<?php
$host = 'mysql_db';   
$user = 'root';      
$pass = 'toor';      
$dbname = 'koffee';   
$con = new mysqli($host, $user, $pass, $dbname);
if ($con->connect_error) {
    die('Conexiunea la baza de date a eșuat: ' . $con->connect_error);
}
?>
