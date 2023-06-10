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
    <script src="./scripts/index.js"></script>
</head>
<body>
    <?php
    require('header.php');
    $nomUtilisateur = $_SESSION["user"];

    require_once 'connexion_bdd.php';

    $requeteBatiment = "SELECT id_batiment, nom_bat FROM batiment WHERE login_gest = '$nomUtilisateur'";
    $resultatBatiment = mysqli_query($connexion, $requeteBatiment);
    $ligneBatiment = mysqli_fetch_assoc($resultatBatiment);
    $idBatiment = $ligneBatiment['id_batiment']; // Get the building managed by this user
    $nomBatiment = $ligneBatiment['nom_bat'];
    echo "<h1>Management Page for $nomUtilisateur (Building: $nomBatiment)</h1>";
    $requeteCapteurs = "SELECT nom_capteur, type_capteur FROM capteur WHERE id_batiment = '$idBatiment'";
    $resultatCapteurs = mysqli_query($connexion, $requeteCapteurs); // Get all the sensors for the specified building
    ?>

    <button id="filterButton">Filter Search</button>
    <fieldset class="gestion" id="gestion">
    <legend>Filter Search</legend>
    <form method='POST'>
        <label for='nom_capteur'>Select a sensor:</label>
        <select name='nom_capteur' id='nom_capteur'>
            <option value=''>All sensors</option>
            <?php
            while ($ligneCapteur = mysqli_fetch_assoc($resultatCapteurs)) {
                $nomCapteur = $ligneCapteur['nom_capteur'];
                echo "<option value='$nomCapteur'>$nomCapteur</option>"; // Add all available sensors to the list
            }
            ?>
        </select>

        <label for='type_capteur'>Select a sensor type:</label>
        <select name='type_capteur' id='type_capteur'>
            <option value='' >All types</option>
            <?php
            $typesCapteurs = array(
                "temperature" => "Temperature",
                "humidity" => "Humidity",
                "activity" => "Activity",
                "co2" => "CO2",
                "tvoc" => "TVOC",
                "illumination" => "Illumination",
                "infrared" => "Infrared",
                "infrared_and_visible" => "Infrared and visible",
                "pressure" => "Pressure"
            );

            foreach ($typesCapteurs as $type => $nom) {
                echo "<option value='$type'>$nom</option>";
            }
            ?>
        </select>

        <label for='salle'>Select a room:</label>
        <select name='salle' id='salle'>
            <option value=''>All rooms</option>
            <?php
            $requeteSalles = "SELECT DISTINCT Salle FROM capteur WHERE id_batiment = '$idBatiment'";
            $resultatSalles = mysqli_query($connexion, $requeteSalles);
            while ($ligneSalle = mysqli_fetch_assoc($resultatSalles)) {
                $salle = $ligneSalle['Salle'];
                echo "<option value='$salle'>$salle</option>";
            }
            ?>
        </select>

        <label for='tri_date'>Sort by date:</label>
        <select name='tri_date' id='tri_date'>
            <option value='asc'>Oldest first</option>
            <option value='desc' selected>Newest first</option>
        </select>

        <label for='tri_valeur'>Sort by value:</label>
        <select name='tri_valeur' id='tri_valeur'>
            <option value=''>No sorting</option>
            <option value='asc'>Smallest first</option>
            <option value='desc'>Largest first</option>
        </select>

        <label for='choix_jour'>Select a day:</label>
        <input type='date' name='choix_jour' id='choix_jour'>

        <input type='submit' value='Filter'>
    </form>
</fieldset>


<section>
    <h2 id="bg">Displaying sensors based on the selected filters</h2>
    <?php
    $nomCapteurSelectionne = isset($_POST['nom_capteur']) ? $_POST['nom_capteur'] : '';
    $typeCapteurSelectionne = isset($_POST['type_capteur']) ? $_POST['type_capteur'] : '';
    $triDate = isset($_POST['tri_date']) ? $_POST['tri_date'] : '';
    $jourChoisi = isset($_POST['choix_jour']) ? $_POST['choix_jour'] : '';
    $triValeur = isset($_POST['tri_valeur']) ? $_POST['tri_valeur'] : '';
    $salleSelectionnee = isset($_POST['salle']) ? $_POST['salle'] : '';

    // SQL query to get sensors based on the filters
    $requeteCapteursFiltre = "SELECT * FROM capteur WHERE id_batiment = '$idBatiment'";

    if (!empty($nomCapteurSelectionne)) {
        $requeteCapteursFiltre .= " AND nom_capteur = '$nomCapteurSelectionne'";
    }
    if (!empty($typeCapteurSelectionne)) {
        $requeteCapteursFiltre .= " AND type_capteur = '$typeCapteurSelectionne'";
    }
    if (!empty($salleSelectionnee)) {
        $requeteCapteursFiltre .= " AND Salle = '$salleSelectionnee'";
    }

    $resultatCapteursFiltre = mysqli_query($connexion, $requeteCapteursFiltre);

    while ($ligneCapteur = mysqli_fetch_assoc($resultatCapteursFiltre)) {
        $nomCapteur = $ligneCapteur['nom_capteur'];
        $type_capteur = $ligneCapteur['type_capteur'];
        $salleCapteur = $ligneCapteur['Salle'];

        $unite = "";
        switch ($type_capteur) {
            case "temperature":
                $unite = "°C";
                break;
            case "humidity":
                $unite = "%rh";
                break;
            case "activity":
                $unite = "activity";
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
                $unite = "infrared";
                break;
            case "infrared_and_visible":
                $unite = "infrared and visible";
                break;
            case "pressure":
                $unite = "hPa";
                break;
            default:
                $unite = "";
        }

        $requeteMoyCapteur = "SELECT ROUND(AVG(valeur_mesure), 2) AS moyenne FROM mesure WHERE nom_capteur = '$nomCapteur'";
        $resultatMoyCapteur = mysqli_query($connexion, $requeteMoyCapteur);
        $ligneMoyCapteur = mysqli_fetch_assoc($resultatMoyCapteur);
        $moyenneCapteur = $ligneMoyCapteur['moyenne'];

        echo "<div class='block'>
        <h3 class='top_block'>$type_capteur Sensor: $nomCapteur (Room: $salleCapteur)</h3>";

        $requeteValHistorique = "SELECT *,
                (SELECT MAX(valeur_mesure) FROM mesure WHERE nom_capteur = '$nomCapteur'";
                
        // rajoute le maximum avec les filtres choisis
        if (!empty($jourChoisi)) {
            $requeteValHistorique .= " AND DATE(date_mesure) = '$jourChoisi'";
        }

        $requeteValHistorique .= ") AS maximum,
            (SELECT MIN(valeur_mesure) FROM mesure WHERE nom_capteur = '$nomCapteur'";
                
        // rajoute le minimum avec les filtres choisis
        if (!empty($jourChoisi)) {
            $requeteValHistorique .= " AND DATE(date_mesure) = '$jourChoisi'";
        }

        $requeteValHistorique .= ") AS minimum,
            (SELECT AVG(valeur_mesure) FROM mesure WHERE nom_capteur = '$nomCapteur'";
                
        // rajoute la moyenne avec les filtres choisis
        if (!empty($jourChoisi)) {
            $requeteValHistorique .= " AND DATE(date_mesure) = '$jourChoisi'";
        }

        $requeteValHistorique .= ") AS moyenne
            FROM mesure
            WHERE nom_capteur = '$nomCapteur'";

        // filter the general condition
        if (!empty($jourChoisi)) {
            $requeteValHistorique .= " AND DATE(date_mesure) = '$jourChoisi'";
        }

        if (!empty($triValeur)) {
            if ($triValeur == 'asc') {
                $requeteValHistorique .= " ORDER BY valeur_mesure ASC";
            } elseif ($triValeur == 'desc') {
                $requeteValHistorique .= " ORDER BY valeur_mesure DESC";
            }
        }

        if (!empty($triDate)) {
            if (!empty($triValeur)) {
                $requeteValHistorique .= ", date_mesure";
            } else {
                $requeteValHistorique .= " ORDER BY date_mesure";
            }

            if ($triDate == 'asc') {
                $requeteValHistorique .= " ASC";
            } elseif ($triDate == 'desc') {
                $requeteValHistorique .= " DESC";
            }
        } else {
            if (empty($triValeur)) {
                $requeteValHistorique .= " ORDER BY date_mesure DESC";
            }
        }

        $resultatValHistorique = mysqli_query($connexion, $requeteValHistorique);


        if (!$resultatValHistorique) {
            die("Erreur de requête : " . mysqli_error($connexion));
        }

        if (mysqli_num_rows($resultatValHistorique) > 0) {
            echo "<table>
                    <tr>
                        <th>Measurement ID</th>
                        <th>Measurement Date</th>
                        <th>Measurement Value</th>
                        <th>Sensor Name</th>
                    </tr>";
            while ($ligneValHistorique = mysqli_fetch_assoc($resultatValHistorique)) {
                $idMesure = $ligneValHistorique['id_mesure'];
                $dateMesure = $ligneValHistorique['date_mesure'];
                $valeurMesure = $ligneValHistorique['valeur_mesure'];
                $nomCapteur = $ligneValHistorique['nom_capteur'];
                $maximum = $ligneValHistorique['maximum'];
                $minimum = $ligneValHistorique['minimum'];
                $moyenne = $ligneValHistorique['moyenne'];

                echo "<tr>
                        <td>$idMesure</td>
                        <td>$dateMesure</td>
                        <td>$valeurMesure $unite</td>
                        <td>$nomCapteur</td>
                    </tr>";
            }
            echo "</table>";
            echo "<h3 class='bot_block'>Average for $type_capteur Sensor: $moyenneCapteur $unite</h3>";
            echo "<h3 class='bot_block'>Info of the displayed measurements: Max : $maximum - Min : $minimum - Moy : $moyenne  $unite</h3>";

        } else  {
            echo "<p>This sensor does not have any values recorded with the chosen filters.</p>";
        }
        echo "</div>";
    }
    ?>
</section>
</body>
</html>
