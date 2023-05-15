<?php 

$servername = "localhost";
$username = "mysql_user";
$password = "mysql_password";
$dbname = "bdd_sae23";


// Connexion à la base de données avec host,user,mdp,nom_BDD
  $connexion = mysqli_connect('$servername', '$username', '$password', '$dbname');

  // Vérifier la connexion
  if (!$connexion) {
    die("La connexion a échoué: " . mysqli_connect_error());
  }
?>