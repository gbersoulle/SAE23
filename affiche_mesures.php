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


    <?php 
        require_once 'header.php';
        require_once 'Display_one_sensor.php'; 
        // Require the script used to connect to the DB
        require_once('connexion_bdd.php');

        // display the last 10 measurements for the room B203
        echo "<h1>Salle B203</h1>";
        // Call the function to display data for a specific sensor
        Display_one("24e124128c011778", "Humidité");

        echo "<h1>Salle E102</h1>";
        Display_one("24e124128c016122", "Humidité");

        echo "<h1>Salle B001</h1>";
        Display_one("24e124128c012259", "CO2");

        echo "<h1>Salle E006</h1>";
        Display_one("24e124128c016509", "CO2");
    ?>

<?php // Close the database connection
        mysqli_close($connexion);
?>

</body>
</html>