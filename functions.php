<?php
require_once 'connexion_bdd.php';

function display_all_buildings($buildings) {

    foreach ($buildings as $building) {
        echo "<button class=\"accordion\" onclick=\"togglePanel(this.nextElementSibling)\">Batiment $building</button>";
        echo "<div class=\"panel\" id=\"$building\">";
        echo "<p>Selectionnez une salle</p>";

        $rooms = Existing_Rooms($building);

        foreach ($rooms as $room) {
            echo "<button class=\"accordion\" onclick=\"togglePanel(this.nextElementSibling); togglePanel(document.getElementById('$building'))\">Salle $room</button>";
            echo "<div class=\"panel\">";
            $data_type = Search_Type($room);

          foreach ($data_type as $type) {
                echo "<h1>$type dans cette Salle : </h1>";
                $sensor_name = Search_Name($room, $type);
                $history[$sensor_name] = Display_Data($sensor_name, $type);
                echo "<canvas id=\"Chart_$sensor_name\"></canvas>";
            }
          echo "</div>";
        }
        echo "</div>"; // close the panel div for this room
      }
      return $history;
}


function Existing_Rooms($building) {

    global $connexion;

    $query = "SELECT DISTINCT Salle FROM capteur WHERE id_batiment IN (SELECT id_batiment FROM batiment WHERE nom_bat = '$building')";
    $result = mysqli_query($connexion, $query);

    if (!$result) {
        die("Error: Can't retrieve data from capteur. " . mysqli_error($connexion));
    }

    $rooms = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rooms[] = $row['Salle'];
    }

    return $rooms;
}

function Search_Type($room) {

    global $connexion;

    $query = "SELECT type_capteur FROM capteur WHERE Salle = '$room'";
    $result = mysqli_query($connexion, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $types[] = $row['type_capteur'];
    }

    return $types;
}

function Search_Name($room, $type) {


    global $connexion;

    $query = "SELECT nom_capteur FROM capteur WHERE Salle = '$room' AND type_capteur = '$type'";
    $result = mysqli_query($connexion, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['nom_capteur'];
    }

    return $name;
}

    
// Function to display data for a specific sensor
function Display_data($nom_capteur, $data_type) {
    
    global $connexion; // Access the global $connexion variable inside the function

    // Retrieve the mesure table content
    $request_content = mysqli_query($connexion, "SELECT * FROM mesure WHERE nom_capteur = '$nom_capteur' ORDER BY id_mesure DESC LIMIT 10");
    if (!$request_content) {
        die("Error: Can't retrieve data from mesure. " . mysqli_error($connexion));
    }

    // Count the number of rows
    $LineCount = mysqli_num_rows($request_content);

    if ($LineCount) {
        echo "
        <table>
            <tr> 
                <th>Date</th>
                <th>$data_type</th>
            </tr>
        ";

        while ($line = mysqli_fetch_assoc($request_content)) {
            // Display the values of each row and  store the 10 measurement values in value history for the chart
            echo "<tr><td>$line[date_mesure]</td><td>$line[valeur_mesure]</td></tr>";
            $values_history[] = $line['valeur_mesure'];
        }
        
        echo "</table>";
        echo "<br>";
        // Display the values stored in the values_history array
        return $values_history;
    } else {
        echo "Pas encore de mesures de $data_type pour cette salle";
        echo "<br>";
    }
}

function Display_moyenne($salle_ID, $nom_capteur, $data_type){

    global $connexion;

    // 
    $query = "SELECT AVG(valeur_mesure) as moyenne FROM ( SELECT valeur_mesure FROM mesure WHERE nom_capteur = '$nom_capteur' ORDER BY id_mesure DESC LIMIT 10) subquery";
    $result = mysqli_query($connexion, $query);
    $recup = mysqli_fetch_assoc($result) ;
    $mo = $recup['moyenne'] ;
    $format = number_format($mo, 2, ',' , ' ') ;


    $min = mysqli_query($connexion, "SELECT MIN(valeur_mesure) as mini FROM (SELECT valeur_mesure FROM mesure WHERE nom_capteur = '$nom_capteur' ORDER BY id_mesure DESC LIMIT 10) subquery" ) ;

    $max = mysqli_query($connexion, "SELECT MAX(valeur_mesure) as maxi FROM (SELECT valeur_mesure FROM mesure WHERE nom_capteur = '$nom_capteur' ORDER BY id_mesure DESC LIMIT 10) subquery") ;


    if (!$result) {
        die("Error: Can't retrieve data from mesure. " . mysqli_error($connexion));
    }

    if (!$min) {
        die("Error: Can't retrieve data from mesure. " . mysqli_error($connexion));
    }

    if (!$max) {
        die("Error: Can't retrieve data from mesure. " . mysqli_error($connexion));
    }

    
    while ($li = mysqli_fetch_assoc($min) and $lin = mysqli_fetch_assoc($max)) {
        echo "<tr>";
        echo "<td>$salle_ID</td>";
        echo "<td>$data_type</td>";
        echo "<td>$format </td>";
        echo "<td>" . $li['mini'] . "</td>" ;
        echo "<td>" . $lin['maxi'] . "</td>" ;
        echo "</tr>";
    }

    return $mo;
}

function Metrique_type($table, $d_type) {
    $total = 0;
    $minim = $table[0];
    $maxim = $table[1];

    for ($i = 0; $i < sizeof($table); $i++) {
        $n = $table[$i];
        $total += $n;
        if ($n > $maxim){
            $maxim = $n ;
        }
        if ( $n < $minim){
            $minim = $n ;
        }
    }

    $moy = $total / sizeof($table);
    $f_moy = number_format($moy, 2);
    $f_min = number_format($minim, 2);
    $f_max = number_format($maxim, 2);

    echo "<tr>";
    echo "<td>$d_type</td>";
    echo "<td>$f_moy</td>";
    echo "<td>$f_min</td>";
    echo "<td>$f_max</td>";
    echo "</tr>";
}


?>