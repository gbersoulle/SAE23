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

$query = "SELECT * FROM user";

// Exécution de la requête
$result = mysqli_query($connexion, $query);

// Vérification des erreurs lors de l'exécution de la requête
if (!$result) {
    echo "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
    exit();
}

// Boucle pour parcourir les résultats et afficher les éléments de la table "user"
while ($row = mysqli_fetch_assoc($result)) {
    // Traitez chaque ligne de la table "user" ici
    // Par exemple, affichez les valeurs des colonnes
    echo "ID : " . $row['id'] . "<br>";
    echo "Nom : " . $row['user'] . "<br>";
    echo "Email : " . $row['password'] . "<br>";
    // et ainsi de suite...
}

// Fermeture de la connexion à la base de données
mysqli_close($connexion);
?>
