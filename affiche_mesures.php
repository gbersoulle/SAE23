<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/table.css">
    <title>Document</title>
</head>
<body>
<?php require_once 'header.php' ?>

<table>
    <tr>
      <th>ID</th>
      <th>Date</th>
      <th>Valeur</th>
      <th>ID_capteur</th>
    </tr>
<?php
// require the script used to connect to the DB
require_once('connexion_bdd.php');

// retrieve the mesure table content
$request_content = mysqli_query($connexion, "SELECT * FROM mesure");
if (!$request_content) {
    die("Error : can't retrieve data from mesure" . mysqli_error($connexion));
}

// Count the number of lines
$LineCount = mysqli_num_rows($request_content);

if ($LineCount) {

    while ($line = mysqli_fetch_assoc($request_content)) {

        // Affichage des valeurs des lignes
        echo "<tr>";
        echo "<td>";
        echo implode("</td><td>", $line);
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Pas de ligne";
}

echo "<br>";
// Fermeture de la connexion à la base de données
mysqli_close($connexion);
?>


</body>
</html>