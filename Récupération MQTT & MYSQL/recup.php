<?php

// Include the database connection file
require_once '../connexion_bdd.php';

# MQTT configuration
$mqtt_host = "mqtt.iut-blagnac.fr";
$mqtt_port = 1883;
$mqtt_topic = "Student/by-room/#";

while (true) {
    $jsonString = shell_exec("mosquitto_sub -h \"$mqtt_host\" -p \"$mqtt_port\" -t \"$mqtt_topic\" -C 1");
    // Convert the JSON string to an associative array
    $output = json_decode($jsonString, true);
    // Get information about existing sensors from the "capteur" table
    $query = "SELECT nom_capteur FROM capteur";
    $result = mysqli_query($connexion, $query);
    $capteurs_existants = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $capteurs_existants[] = $row['nom_capteur'];
    }
    // Iterate over the output array and insert data for existing sensors into the database
    $room = $output[1]['room'];
    foreach ($output[0] as $capteur => $valeur) {
        // Construct the nom_capteur
        $nom_capteur = $room . $capteur;
        // Check if the sensor exists in the "capteur" table
        if (in_array($nom_capteur, $capteurs_existants)) {
            // Insert data into the "mesure" table
            $query = "INSERT INTO mesure (valeur_mesure, nom_capteur) VALUES ('$valeur', '$nom_capteur')";
            mysqli_query($connexion, $query);
            echo "$query executed <br>";
        }
    }
    // Close the database result
    mysqli_free_result($result);
    // Add a delay between iterations to prevent constant querying
    sleep(0,5);
}
?>
