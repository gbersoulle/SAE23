<?php

function Existing_Rooms($building) {

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


    $query = "SELECT Salle FROM capteur WHERE id_batiment IN (SELECT id_batiment FROM batiment WHERE nom_bat = '$building')";
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

    $query = "SELECT type_capteur FROM capteur WHERE Salle = '$room'";
    $result = mysqli_query($connexion, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $types[] = $row['type_capteur'];
    }

    return $types;

}
    
// Function to display data for a specific sensor
function Display_one($nom_capteur, $data_type) {
    echo "
    <table>
        <tr> 
            <th>Date</th>
            <th>$data_type</th>
        </tr>
    ";

    global $connexion; // Access the global $connexion variable inside the function
    // Retrieve the mesure table content
    $request_content = mysqli_query($connexion, "SELECT * FROM mesure WHERE nom_capteur = '$nom_capteur' ORDER BY id_mesure DESC LIMIT 10");
    if (!$request_content) {
        die("Error: Can't retrieve data from mesure. " . mysqli_error($connexion));
    }

    // Count the number of rows
    $LineCount = mysqli_num_rows($request_content);

    if ($LineCount) {
        while ($line = mysqli_fetch_assoc($request_content)) {
            // Display the values of each row and  store the 10 measurement values in value history for the chart
            echo "<tr><td>$line[date_mesure]</td><td>$line[valeur_mesure]</td></tr>";
            $values_history[] = $line['valeur_mesure'];


        }
        echo "</table>";
    } else {
        echo "Pas de ligne";
    }

    echo "<br>";
    // Display the values stored in the values_history array
    return $values_history;
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
