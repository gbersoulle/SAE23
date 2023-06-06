<?php

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
