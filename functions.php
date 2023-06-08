<?php
// Require the database connection file
require_once 'connexion_bdd.php';

// Function to display all buildings and their associated rooms and sensor data
function display_all_buildings($buildings) {
    // Loop through the buildings
    foreach ($buildings as $building) {
        // Add an accordion button for each building
        echo "<button class=\"accordion\" onclick=\"Show_And_Hide(this.nextElementSibling)\">Batiment $building</button>";
        // Add a panel div for each building
        echo "<div class=\"panel\" id=\"$building\">";
        echo "<p>Selectionnez une salle</p>";

        // Retrieve the rooms in the current building
        $rooms = Existing_Rooms($building);

        // Loop through the rooms in the current building
        foreach ($rooms as $room) {
            // Add an accordion button for each room
            echo "<div class=\"roomDiv\">";
            echo "<button class=\"room\" onclick=\"togglePanel(this.nextElementSibling); expand(document.getElementById('$building'))\">Salle $room</button>";
            
            // Add a panel div for each room
            echo "<div class=\"panel data\">";
            // Retrieve the sensor types in the current room
            $data_type = Search_Type($room);
           
          // Loop through the sensor types in the current room
          foreach ($data_type as $type) {
                // Display the sensor type heading
                echo "<h1>$type : </h1>";
                // Retrieve the sensor name based on the room and type
                $sensor_name = Search_Name($room, $type);
                // Display the sensor data and store it in the history array
                $history[$sensor_name] = Display_Data($sensor_name, $type);
            }
            echo "</div>";
            echo "</div>"; // close the panel div for this room
        }
        echo "</div>";
    }
    return $history; // Return the sensor data history

}

// Function to retrieve the existing rooms in a given building
function Existing_Rooms($building) {
    // Access the global $connexion variable inside the function
    global $connexion;
    // Query to retrieve distinct room names in the given building
    $query = "SELECT DISTINCT Salle FROM capteur WHERE id_batiment IN (SELECT id_batiment FROM batiment WHERE nom_bat = '$building')";
    $result = mysqli_query($connexion, $query);
    
    // Error handling for the query execution
    if (!$result) {
        die("Error: Can't retrieve data from capteur. " . mysqli_error($connexion));
    }

    // Initialize an empty array to store the room names
    $rooms = [];
    // Loop through the query result and add the room names to the array
    while ($row = mysqli_fetch_assoc($result)) {
        $rooms[] = $row['Salle'];
    }

    return $rooms; // Return the array of room names

}

// Function to retrieve the sensor types in a given room
function Search_Type($room) {
    // Access the global $connexion variable inside the function
    global $connexion;

    // Query to retrieve the sensor types in the given room
    $query = "SELECT type_capteur FROM capteur WHERE Salle = '$room'";
    $result = mysqli_query($connexion, $query);

    // Loop through the query result and add the sensor types to the array
    while ($row = mysqli_fetch_assoc($result)) {
        $types[] = $row['type_capteur'];
    }

    return $types; // Return the array of sensor types
}

// Function to retrieve the sensor name based on the room and sensor type
function Search_Name($room, $type) {

    // Access the global $connexion variable inside the function
    global $connexion;

    // Query to retrieve the sensor name based on the room and type
    $query = "SELECT nom_capteur FROM capteur WHERE Salle = '$room' AND type_capteur = '$type'";
    $result = mysqli_query($connexion, $query);

    // Loop through the query result and store the sensor name
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['nom_capteur'];
    }

    return $name; // Return the sensor name
}

    
// Define the function Display_data with parameters $nom_capteur and $data_type
function Display_data($nom_capteur, $data_type) {
    // Access the global $connexion variable inside the function
    global $connexion;

    // Retrieve the mesure table content based on the sensor name, limited to the last 10 measurements
    $request_content = mysqli_query($connexion, "SELECT * FROM mesure WHERE nom_capteur = '$nom_capteur' ORDER BY id_mesure DESC LIMIT 10");
    
    // Check if there was an error in the query execution
    if (!$request_content) {
        die("Error: Can't retrieve data from mesure. " . mysqli_error($connexion));
    }

    // Count the number of rows in the result
    $LineCount = mysqli_num_rows($request_content);

    // If there are rows in the result, proceed to display the data
    if ($LineCount) {
        // Add a canvas element for charting sensor data
        echo "<canvas id=\"Chart_$nom_capteur\"></canvas>";
        // Begin an HTML table to display the data
        echo "
        <table>
            <tr> 
                <th>Date</th>
                <th>$data_type</th>
            </tr>
        ";

        // Loop through each row in the result
        while ($line = mysqli_fetch_assoc($request_content)) {
            // Display the date and value of each measurement in a new table row
            echo "<tr><td>$line[date_mesure]</td><td>$line[valeur_mesure]</td></tr>";
            // Store the values of each measurement in the values_history array for later use in a chart
            $values_history[] = $line['valeur_mesure'];
        }
        
        // Close the HTML table
        echo "</table>";
        echo "<br>";
        // Return the values_history array for further processing
        return $values_history;
    } else {
        // If there are no rows in the result, display an appropriate message
        echo "Pas encore de mesures de $data_type pour cette salle";
        echo "<br>";
    }
}

function Display_moyenne($salle_ID, $nom_capteur, $data_type){
    // Access the global $connexion variable inside the function
    global $connexion;

    // Query to calculate the average value for the given sensor within the last 10 measurements
    $query = "SELECT AVG(valeur_mesure) as moyenne FROM (SELECT valeur_mesure FROM mesure WHERE nom_capteur = '$nom_capteur' ORDER BY id_mesure DESC LIMIT 10) subquery";
    $result = mysqli_query($connexion, $query);
    $recup = mysqli_fetch_assoc($result);
    $mo = $recup['moyenne'];
    $format = number_format($mo, 2, ',', ' ');

    // Query to retrieve the minimum value for the given sensor within the last 10 measurements
    $min = mysqli_query($connexion, "SELECT MIN(valeur_mesure) as mini FROM (SELECT valeur_mesure FROM mesure WHERE nom_capteur = '$nom_capteur' ORDER BY id_mesure DESC LIMIT 10) subquery");

    // Query to retrieve the maximum value for the given sensor within the last 10 measurements
    $max = mysqli_query($connexion, "SELECT MAX(valeur_mesure) as maxi FROM (SELECT valeur_mesure FROM mesure WHERE nom_capteur = '$nom_capteur' ORDER BY id_mesure DESC LIMIT 10) subquery");

    // Error handling for the query execution
    if (!$result) {
        die("Error: Can't retrieve data from mesure. " . mysqli_error($connexion));
    }

    if (!$min) {
        die("Error: Can't retrieve data from mesure. " . mysqli_error($connexion));
    }

    if (!$max) {
        die("Error: Can't retrieve data from mesure. " . mysqli_error($connexion));
    }

    // Display the average, minimum, and maximum values for the sensor
    while ($li = mysqli_fetch_assoc($min) and $lin = mysqli_fetch_assoc($max)) {
        echo "<tr>";
        echo "<td>$salle_ID</td>";
        echo "<td>$data_type</td>";
        echo "<td>$format</td>";
        echo "<td>" . $li['mini'] . "</td>";
        echo "<td>" . $lin['maxi'] . "</td>";
        echo "</tr>";
    }

    return $mo; // Return the average value
}

function Metrique_type($table, $d_type) {
    $total = 0;
    $minim = $table[0];
    $maxim = $table[1];

    // Calculate the total sum, minimum, and maximum values from the given table
    for ($i = 0; $i < sizeof($table); $i++) {
        $n = $table[$i];
        $total += $n;
        if ($n > $maxim) {
            $maxim = $n;
        }
        if ($n < $minim) {
            $minim = $n;
        }
    }

    // Calculate the average value and format the numbers
    $moy = $total / sizeof($table);
    $f_moy = number_format($moy, 2);
    $f_min = number_format($minim, 2);
    $f_max = number_format($maxim, 2);

    // Display the metric information in a table row
    echo "<tr>";
    echo "<td>$d_type</td>";
    echo "<td>$f_moy</td>";
    echo "<td>$f_min</td>";
    echo "<td>$f_max</td>";
    echo "</tr>";
}


?>