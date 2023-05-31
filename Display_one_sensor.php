<?php

// Function to display data for a specific sensor
function Display_one($Sensor_ID, $data_type) {
    echo "
    <table>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>$data_type</th>
            <th>ID du capteur</th>
        </tr>
    ";

    global $connexion; // Access the global $connexion variable inside the function
    // Retrieve the mesure table content
    $request_content = mysqli_query($connexion, "SELECT * FROM mesure WHERE id_capteur = '$Sensor_ID' ORDER BY id_mesure DESC LIMIT 10");
    if (!$request_content) {
        die("Error: Can't retrieve data from mesure. " . mysqli_error($connexion));
    }

    // Count the number of rows
    $LineCount = mysqli_num_rows($request_content);

    if ($LineCount) {
        while ($line = mysqli_fetch_assoc($request_content)) {
            // Display the values of each row
            echo "<tr>";
            echo "<td>";
            echo implode("</td><td>", $line);
            echo "</td>";
            echo "</tr>";
            // store the 10 measurement values in this array for the chart
            $values_history[] = $line["valeur_mesure"];

        }
        echo "</table>";
    } else {
        echo "Pas de ligne";
    }

    echo "<br>";

    // Display the values stored in the values_history array
    return $values_history;
}

function Display_moyenne($salle_ID,$Sensor_ID,$data_type){

    global $connexion;

    $query = "SELECT AVG(valeur_mesure) as moyenne FROM mesure WHERE id_capteur = '$Sensor_ID' ORDER BY date_mesure DESC LIMIT 10";
    $result = mysqli_query($connexion, $query);

    if (!$result) {
        die("Error: Can't retrieve data from mesure. " . mysqli_error($connexion));
    }
    
    while ($line = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>$salle_ID</td>";
        echo "<td>$data_type</td>";
        echo "<td>" . $line['moyenne'] . "</td>";
        echo "</tr>";
    }


    return $result;
}

function Moyenne_type($data_type){
    
}

?>
