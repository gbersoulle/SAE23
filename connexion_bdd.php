<?php
$servername = "lhcp3164.webapps.net";
$username = "ku55c1se_mysqluser";
$password = "mysqlpassroot";
$dbname = "ku55c1se_sae23";

// Connexion à la base de données avec host, user, mdp, nom_BDD
$connexion = mysqli_connect($servername, $username, $password, $dbname);

// Vérifier la connexion
if (!$connexion) {
    die("La connexion a échoué: " . mysqli_connect_error());
}

?>
