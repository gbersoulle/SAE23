<?php
// Require the database connection file

//create a table for data type translation
$sensor_translation = array(
    "temperature" => "Température",
    "humidity" => "Humidité",
    "activity" => "Activité",
    "co2" => "CO2",
    "tvoc" => "TVOC",
    "illumination" => "Illumination",
    "infrared" => "Infrarouge",
    "infrared_and_visible" => "Infrarouge et visible",
    "pressure" => "Pression"
);

// Function to display all buildings and their associated rooms and sensor data
function display_all_buildings($buildings, $numberOfValues, $nomCapteur,
$typeCapteur, $triDate, $jourChoisi, $triValeur, $salle) {
    // Access the global $connexion variable inside the function
    require 'connexion_bdd.php';
    // if building isn't specified take all of them
    if ($buildings === "all"){
        //get an array of all the building names
        $result = mysqli_query($connexion, "SELECT nom_bat FROM batiment");
        $buildings = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $buildings[] = $row['nom_bat'];
        }
    }

    // Loop through the buildings
    foreach ($buildings as $building) {
        require 'connexion_bdd.php';

        //get building id
        $requeteBatiment = "SELECT id_batiment FROM batiment WHERE nom_bat = '$building'";
        $resultatBatiment = mysqli_query($connexion, $requeteBatiment);
        $idBatiment = mysqli_fetch_assoc($resultatBatiment)['id_batiment'];

        // Create a basic sql request to find in the capteur table the sensors to display
        // we will this complete based on the parameters value
        $requeteCapteursFiltre = "SELECT Salle, nom_capteur FROM capteur WHERE id_batiment = '$idBatiment'";

        //we complete the request with any information that hasn't been let blank
        if (!empty($nomCapteur)) {
            $requeteCapteursFiltre .= " AND nom_capteur = '$nomCapteur'";
        }
        if (!empty($typeCapteur)) {
            $requeteCapteursFiltre .= " AND type_capteur = '$typeCapteur'";
        }
        if (!empty($salle)) {
            $requeteCapteursFiltre .= " AND Salle = '$salle'";
        }
        //Ultimately, execute the request
        $resultatCapteursFiltre = mysqli_query($connexion, $requeteCapteursFiltre);
        mysqli_close($connexion);
        $list_sensors = [];
        $rooms = [];
        //get all rooms
        while ($ligneCapteur = mysqli_fetch_assoc($resultatCapteursFiltre)) {
            $list_sensors[] = $ligneCapteur['nom_capteur'];
            $rooms[] = $ligneCapteur['Salle'];
        }
        //make sure each room appears only one time
        $rooms = array_unique($rooms);

        // if there is more than one : Add an accordion button for each building
        if (sizeof($buildings) > 1) {
            echo "<button class='accordion' onclick=\"Show_And_Hide(this.nextElementSibling)\">Batiment $building</button>";
            // Add a panel div for each building
            echo "<div class='panel' id='$building'>";
            echo "<p>Selectionnez une salle</p>";
        }

        // Loop through the rooms in the current building
        foreach ($rooms as $room) {
            // Add an accordion button for each room
            echo "<div class='roomDiv'>";
            echo "<button class='room' onclick=\"togglePanel(this.nextElementSibling); expand(document.getElementById('$building'))\">Salle $room</button>";
            // Add a panel div for each room
            echo "<div class='panel data'>";
            $data_type = Search_Type($room);
          // Loop through the sensor types in the current room
          foreach ($data_type as $type) {
              // Retrieve the sensor name based on the room and type
              $sensor_name = Search_Name($room, $type);
              //as this function is used to display avg to, it sends back an array of which we only need the fisrt cell
              $sensor_name = $sensor_name[0];
              //check if this sensor name is in common with the first request list of sensors
              if (in_array($sensor_name, $list_sensors)) {
                    global $sensor_translation;
                    // Display the sensor type heading
                    echo "<h2 class='t_center'>$sensor_translation[$type] : </h2>";
                    // Display the sensor data and store its values in the data history array
                    $history[$sensor_name] = display_data($sensor_name, $type, $numberOfValues, $triDate, $jourChoisi, $triValeur);
                }
            }
            echo "</div>";
            echo "</div>"; // close the panel div for this room
        }
        echo "</div>";
    }
    //if history isn't set it means no data corresponds to the filters
    if(isset($history)) {
        return $history; // Return the sensor data history if not empty
    }else {
        return null;
    }
}

function Search_Type($room) {
    // Access the global $connexion variable inside the function
    require 'connexion_bdd.php';

    // Query to retrieve the sensor types in the given room
    $query = "SELECT DISTINCT type_capteur FROM capteur";
    if (!empty($room)) {
        $query .= " WHERE Salle = '$room'";
    }
    $result = mysqli_query($connexion, $query);
    mysqli_close($connexion);
    // Loop through the query result and add the sensor types to the array
    while ($row = mysqli_fetch_assoc($result)) {
        $types[] = $row['type_capteur'];
    }

    return $types; // Return the array of sensor types
}
// Function to retrieve the sensor name based on the room and sensor type
function Search_Name($room, $type) {
    // Access the global $connexion variable inside the function
    require 'connexion_bdd.php';
    
    // Initialize the $name variable
    $name = '';

    // Query to retrieve the sensor name based on the room and type
    $query = "SELECT nom_capteur FROM capteur WHERE type_capteur = '$type'";
    if (!empty($room)) {
        $query .= " AND Salle = '$room'";
    }
    $result = mysqli_query($connexion, $query);
    mysqli_close($connexion);
    $name = [];
    // Loop through the query result and store the sensor name
    while ($row = mysqli_fetch_assoc($result)) {
        $name[] = $row['nom_capteur'];
    }

    return $name; // Return the sensor name
}

    
// Define the function display_data with parameters $nom_capteur and $data_type
function display_data($nom_capteur, $data_type, $numberOfValues, $triDate, $jourChoisi, $triValeur) {
    // Access the global $connexion variable inside the function
    require 'connexion_bdd.php';

    // Récupérer et afficher les valeurs historiques en fonction du tri (asc ou desc)
    $request_content = "SELECT * FROM mesure WHERE nom_capteur = '$nom_capteur'";

    if (!empty($jourChoisi)) {
        $request_content .= " AND DATE(date_mesure) = '$jourChoisi'";
    }
    if (!empty($triValeur)) {
        if ($triValeur == 'asc') {
            $request_content .= " ORDER BY valeur_mesure ASC";
        } elseif ($triValeur == 'desc') {
            $request_content .= " ORDER BY valeur_mesure DESC";
        }
    }
    if (!empty($triDate)) {
        if (!empty($triValeur)) {
            $request_content .= ", date_mesure";
        } else {
            $request_content .= " ORDER BY date_mesure";
        }
        
        if ($triDate == 'asc') {
            $request_content .= " ASC";
        } elseif ($triDate == 'desc') {
            $request_content .= " DESC";
        }
    } else {
        if (empty($triValeur)) {
            $request_content .= " ORDER BY date_mesure DESC"; // Tri par date par défaut si aucun tri n'est spécifié
        }
    }
           
    $SQL_data = mysqli_query($connexion, $request_content);
    mysqli_close($connexion);
    // Count the number of rows in the result
    $LineCount = mysqli_num_rows($SQL_data);


    // If there are rows in the result, proceed to display the data
    if ($LineCount && $numberOfValues > 1) {
        // Add a canvas element for charting sensor data
        echo "<canvas id='Chart_$nom_capteur'></canvas>";
        // Determining the unit of measurement based on the sensor type
        $unite = "";
        switch ($data_type) {
            case "temperature":
                $unite = "°C";
                break;
            case "humidity":
                $unite = "%rh";
                break;
            case "activity":
                $unite = "activité";
                break;
            case "co2":
                $unite = "ppm";
                break;
            case "tvoc":
                $unite = "ppb";
                break;
            case "illumination":
                $unite = "lux";
                break;
            case "infrared":
                $unite = "infrarouge";
                break;
            case "infrared_and_visible":
                $unite = "infrarouge et visible";
                break;
            case "pressure":
                $unite = "hPa";
                break;
            default:
                $unite = "";
        }
        // Begin an HTML table to display the data
        echo "
        <table>
            <tr> 
            <th>ID Mesure</th>
            <th>Date Mesure</th>
            <th>Valeur Mesure ($unite)</th>
            <th>Nom Capteur</th>
            </tr>
        ";

        // Loop through each row in the result
        while ($line = mysqli_fetch_assoc($SQL_data)) {
           // Display value of each element
           echo "<tr>";
           echo "<td>";
           //concatenates each element of $line separated with </td><td> 
           echo implode("</td><td>", $line);
           echo "</td>";
           echo "</tr>";
           // Store the values of each measurement in the values_history array for later use in a chart
           $values_history[] = $line['valeur_mesure'];
        }
        // Close the HTML table
        echo "</table>";
        echo "<br>";
        global $sensor_translation;
        //sum of all the history array values divided its size, rounded to the second decimal place
        $moyenneAffichee = round(array_sum($values_history) / sizeof($values_history), 2);

        //get the total average for this sensor
        $requeteMoyCapteur = "SELECT ROUND(AVG(valeur_mesure), 2) AS moyenne FROM mesure WHERE nom_capteur = '$nom_capteur'";
        $resultatMoyCapteur = mysqli_query($connexion, $requeteMoyCapteur);
        $ligneMoyCapteur = mysqli_fetch_assoc($resultatMoyCapteur);
        $moyenneCapteur = $ligneMoyCapteur['moyenne'];
        mysqli_close($connexion);

        //display these averages
        echo "<h3 class='bot_block'>Moyenne du capteur de $sensor_translation[$data_type] : $moyenneCapteur $unite</h3>";
        echo "<h3 class='bot_block add_space'>Moyenne des mesures affichées : $moyenneAffichee $unite</h3>";
        // Return the values_history array for graph making
        return $values_history;
    //if there is only one value, display it as a gauge
    } else if ($LineCount) {
        $values_history[] = mysqli_fetch_assoc($SQL_data)['valeur_mesure'];
        echo "<div id='$nom_capteur' class='gauge' data-value='$values_history[0]' dataType='$data_type'></div>";
    } else
        // If there are no rows in the result, display this message
        echo "<p class='center'> Aucune mesure à afficher </p>";
        echo "<br>";
    }


function Display_moyenne(){
    $type = Search_Type("");

    foreach ($type as $data_type){
        $name_sensor = [];
        $name_sensor = Search_Name("", $data_type);
        
        
        // Query to calculate the average value for the given sensors within the last 10 measurements
        $query = "SELECT AVG(valeur_mesure) as moyenne,  MIN(valeur_mesure) as minimum, MAX(valeur_mesure) as maximum FROM mesure WHERE nom_capteur IN (";
        $query .= "'" . $name_sensor[0] . "'";
        
        // Remove the first element of the array
        array_shift($name_sensor);
        
        // Add each sensor name to the query
        foreach ($name_sensor as $name) {
            $query .= ", '" . $name . "'";
        }
        
        $query .= ")";
        require 'connexion_bdd.php';

        $result = mysqli_query($connexion, $query);
        mysqli_close($connexion);
        // Error handling for the query execution
        if (!$result) {
            die("Error: Can't retrieve data from mesure. " . mysqli_error($connexion));
        }

        // Display the average, minimum, and maximum values for the sensor
        while ($line = mysqli_fetch_assoc($result)) {
            $average_formated = number_format($line['moyenne'], 2, ',', ' ');
            echo "<tr>";
            echo "<td>$data_type</td>";
            echo "<td>$average_formated</td>";
            echo "<td>{$line['minimum']}</td>";
            echo "<td>{$line['maximum']}</td>";
            echo "</tr>";
        }
    }

}
?>