<?php
    // Check if a session is started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }


    // Check if the user is logged in
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        // Check the user's source

        if (isset($_SESSION['source']) && $_SESSION['source'] != 'batiment') {
            $erreur = "ERROR: You do not have the necessary credentials to access this page";
            echo '<a href="index.php">Home</a><br>' ;
            die($erreur);
        }
    } 
    else {
        $message = "ERROR: You are not logged in";
        echo '<a href="index.php">Home</a><br>' ;
        die($message);
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Page</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="./scripts/gestion.js"></script>
</head>
<body>
    <?php
    require('header.php');
    //get the user name
    $nomUtilisateur = $_SESSION["user"];

    require_once 'connexion_bdd.php';

    //generate an sql request to get the user's building id and name
    $requeteBatiment = "SELECT id_batiment, nom_bat FROM batiment WHERE login_gest = '$nomUtilisateur'";
    $resultatBatiment = mysqli_query($connexion, $requeteBatiment);
    $ligneBatiment = mysqli_fetch_assoc($resultatBatiment);

    //extract the user's building id and name
    $idBatiment = $ligneBatiment['id_batiment'];
    $nomBatiment = $ligneBatiment['nom_bat'];
    echo "<h1>Page de gestion de $nomUtilisateur (Batiment : $nomBatiment)</h1>";
    //get the name of the building sensors
    $requeteCapteurs = "SELECT nom_capteur, type_capteur FROM capteur WHERE id_batiment = '$idBatiment'";
    $resultatCapteurs = mysqli_query($connexion, $requeteCapteurs);
    mysqli_close($connexion);
    ?>

    <!-- create the filter button -->
    <button id="filterButton">Filtrer la recherche</button>

    <fieldset class="gestion" id="gestion">
    <legend>Filter Search</legend>
    <form method='POST'>
    <!-- sensor name selection -->
    <label for='nom_capteur'>Choisir un capteur :</label>
    <select name='nom_capteur' id='nom_capteur'>
        <option value=''>Tous les capteurs</option>
        <?php
        //add every sensor as an option in the list
        while ($ligneCapteur = mysqli_fetch_assoc($resultatCapteurs)) {
            $nomCapteur = $ligneCapteur['nom_capteur'];
            echo "<option value='$nomCapteur'>$nomCapteur</option>"; 
        }
        ?>
    </select>
    <!-- sensor type selection -->
    <label for='type_capteur'>Choisir un type de capteur :</label>
    <select name='type_capteur' id='type_capteur'>
        <option value='' >Tous les types</option>
        <?php
        $typesCapteurs = array(
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
            //add every type from the array as an option of the list
            foreach ($typesCapteurs as $type => $nom) {
                echo "<option value='$type'>$nom</option>";
            }
            ?>
        </select>

        <!-- room name selection -->
        <label for='salle'>Choisir une salle :</label>
        <select name='salle' id='salle'>
            <option value=''>Toutes les salles</option>
            <?php
            //request all the rooms of the building from the DB
            $requeteSalles = "SELECT DISTINCT Salle FROM capteur WHERE id_batiment = '$idBatiment'";
            require 'connexion_bdd.php';
            $resultatSalles = mysqli_query($connexion, $requeteSalles);
            mysqli_close($connexion);
            //add every room collected as an option

            while ($ligneSalle = mysqli_fetch_assoc($resultatSalles)) {
                $salle = $ligneSalle['Salle'];
                echo "<option value='$salle'>$salle</option>";
            }
            ?>
        </select>

        <!-- add time based order selection -->
        <label for='tri_date'>Trier par date :</label>
        <select name='tri_date' id='tri_date'>
            <option value='asc'>Plus ancienne d'abord</option>
            <option value='desc' selected>Plus récente d'abord</option>
        </select>
        <!-- add order by value -->
        <label for='tri_valeur'>Trier par valeur :</label>
        <select name='tri_valeur' id='tri_valeur'>
            <option value=''>Aucun tri</option>
            <option value='asc'>Plus petite d'abord</option>
            <option value='desc'>Plus grande d'abord</option>
        </select>
        <!-- add date selection -->
        <label for='choix_jour'>Choisir un jour :</label>
        <input type='date' name='choix_jour' id='choix_jour'>

        <input type='submit' value='Filtrer'>
        </form>
    </fieldset>

    <!-- As the form content is being sent to this same script, we now need to handle it : -->
    <section>
        <h2 id="bg">Affichage des capteurs selon le filtre choisi</h2>
    <?php
    //handle the form reception (post), store every information sent if it's not the default one

    $nomCapteurSelectionne = isset($_POST['nom_capteur']) ? $_POST['nom_capteur'] : '';
    $typeCapteurSelectionne = isset($_POST['type_capteur']) ? $_POST['type_capteur'] : '';
    $triDate = isset($_POST['tri_date']) ? $_POST['tri_date'] : '';
    $jourChoisi = isset($_POST['choix_jour']) ? $_POST['choix_jour'] : '';
    $triValeur = isset($_POST['tri_valeur']) ? $_POST['tri_valeur'] : '';
    $salleSelectionnee = isset($_POST['salle']) ? $_POST['salle'] : '';

    echo "<div class='block'>";
        require_once 'functions.php';
        $history = display_all_buildings([$nomBatiment], 1000, $nomCapteurSelectionne,
        $typeCapteurSelectionne, $triDate, $jourChoisi, $triValeur, $salleSelectionnee);
        if(!isset($history)){
            echo "<div class='block'>";
            echo "<h3 class='center'>Aucune valeur à afficher</h3>"; //return null if empty
            echo "<img class='picture' src='images/nothing-here.png' alt='Aucune valeur'>";
            echo "</div>";
        }
    echo "</div>";
    ?>
    </section>
    <script src='./scripts/unroll.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
    <script src='./scripts/Make_Chart.js'></script>
<script>
        // Function to create a new chart (graph)
        function createChart(sensor_name, chartData, color) {
        // Get the canvas element by ID
        var canvas = document.getElementById("Chart_" + sensor_name);

        // reverse the array to have data classified in the right order
        var data = chartData[sensor_name].reverse();

        // Generate a random color (generate a random number between 0 and 16777215 and convert it to hexa)
        var randomColor = '#' + Math.floor(Math.random() * 16777215).toString(16);

        // Labels are the name of each point of the graph, each point being incremented by 1 (1 to i)
        // Create an array for the labels
        var labels = [];
        for (var i = 0; i < data.length; i++) {
            labels[i] = i + 1;
        }
        console.log(labels);

        // specify each characteristic of our chart for chart.js to make
        var chart = new Chart(canvas, {
            type: 'line',
            data: {
            // Labels are the name of each point of the graph
            labels: labels,
            datasets: [
                {
                label: "évolution des 10 dernières valeurs",
                pointRadius: 10,
                pointHoverRadius: 15,
                // Specify which data to use for the graph
                data: data,
                borderColor: randomColor,
                }
            ]
            }
        });
        }

        // Get the historical data from PHP and store it in the historyData variable
        var historyData = <?php echo json_encode($history); ?>;

        // Iterate over each sensor in the historyData object
        for (var sensor in historyData) {
            // Check if the sensor has data
            if (historyData[sensor] != null && historyData[sensor].length > 0) {
                // Call the createChart function to create a chart for the sensor using the historical data
                createChart(sensor, historyData, 'red');
            }
        }

</script>
</body>
</html>
