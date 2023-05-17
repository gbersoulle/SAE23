<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Document</title>
</head>
<body>
<?php require_once 'header.php' ?>

<?php
// Inclusion du fichier de connexion à la base de données
require_once('connexion_bdd.php');

// Récupération des noms de toutes les tables
$requeteTables = mysqli_query($connexion, "SHOW TABLES");
if (!$requeteTables) {
    die("Erreur : bébou y'a un blème avec les tables" . mysqli_error($connexion));
}

// Affichage des tables et de leur contenu
while ($table = mysqli_fetch_array($requeteTables)) {
    $nomTable = $table[0];
    echo "<h2>Table : $nomTable</h2>";

    // Récupération des lignes de la table
    $requeteLignes = mysqli_query($connexion, "SELECT * FROM $nomTable");
    if (!$requeteLignes) {
        die("Erreur : frérot t'as merdé" . mysqli_error($connexion));
    }

    // Vérification du nombre de lignes
    $nombreLignes = mysqli_num_rows($requeteLignes);
    if ($nombreLignes > 0) {
        // Affichage des lignes
        echo "<table>";
        echo "<tr>";
        while ($ligne = mysqli_fetch_assoc($requeteLignes)) {
            // Affichage des en-têtes de colonnes
            if ($nombreLignes === mysqli_num_rows($requeteLignes)) {
                echo "<th>";
                echo implode("</th><th>", array_keys($ligne));
                echo "</th>";
            }

            // Affichage des valeurs des lignes
            echo "<tr>";
            echo "<td>";
            echo implode("</td><td>", $ligne);
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Pas de ligne";
    }

    echo "<br>";
}

// Fermeture de la connexion à la base de données
mysqli_close($connexion);
?>


</body>
</html>