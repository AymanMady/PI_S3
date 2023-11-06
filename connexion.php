<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ptt";

// Connexion
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérification de la connexion
if (!$conn) {
    die("La connexion a échoué : " . mysqli_connect_error());
}
?>