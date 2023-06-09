<?php
    // Check if a session is start
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        // Vérifier la source de l'utilisateur
        if (isset($_SESSION['source']) && $_SESSION['source'] != 'batiment') {
            $erreur = "ERREUR : Vous n'avez pas l'accréditation nécessaire pour accéder à cette page";
            echo '<a href="index.php">Accueil</a><br>' ;
            die($erreur);
        }
    } 
    else {
        $message = "ERREUR : Vous n'êtes pas connecté";
        echo '<a href="index.php">Accueil</a><br>' ;
        die($message);
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Gestion</title>
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
    $idBatiment = $ligneBatiment['id_batiment']; //Récupère le bâtiment géré par cet utilisateur
    $nomBatiment = $ligneBatiment['nom_bat'];
    echo "<h1>Page de gestion de $nomUtilisateur (Batiment : $nomBatiment)</h1>";
    $requeteCapteurs = "SELECT nom_capteur, type_capteur FROM capteur WHERE id_batiment = '$idBatiment'";
    $resultatCapteurs = mysqli_query($connexion, $requeteCapteurs); //récupère tous les capteurs du bâtiment en question
    ?>

    <button id="filterButton">Filtrer la recherche</button>
    <fieldset class="gestion" id="gestion">
        <legend>Filtrer la recherche</legend>
    <form method='POST'>
    <label for='nom_capteur'>Choisir un capteur :</label>
    <select name='nom_capteur' id='nom_capteur'>
        <option value=''>Tous les capteurs</option>
        <?php
        while ($ligneCapteur = mysqli_fetch_assoc($resultatCapteurs)) {
            $nomCapteur = $ligneCapteur['nom_capteur'];
            echo "<option value='$nomCapteur'>$nomCapteur</option>"; //rajoute tout les capteurs disponibles dans la liste
        }
        ?>
    </select>
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

                foreach ($typesCapteurs as $type => $nom) {
                    echo "<option value='$type'>$nom</option>";
                }
                ?>
            </select>
            <label for='salle'>Choisir une salle :</label>
            <select name='salle' id='salle'>
                <option value=''>Toutes les salles</option>
                <?php
                $requeteSalles = "SELECT DISTINCT Salle FROM capteur WHERE id_batiment = '$idBatiment'";
                $resultatSalles = mysqli_query($connexion, $requeteSalles);
                while ($ligneSalle = mysqli_fetch_assoc($resultatSalles)) {
                    $salle = $ligneSalle['Salle'];
                    echo "<option value='$salle'>$salle</option>";
                }
                ?>
            </select>

            <label for='tri_date'>Trier par date :</label>
            <select name='tri_date' id='tri_date'>
                <option value='asc'>Plus ancienne d'abord</option>
                <option value='desc' selected>Plus récente d'abord</option>
            </select>
            <label for='tri_valeur'>Trier par valeur :</label>
            <select name='tri_valeur' id='tri_valeur'>
                <option value=''>Aucun tri</option>
                <option value='asc'>Plus petite d'abord</option>
                <option value='desc'>Plus grande d'abord</option>
            </select>

            <label for='choix_jour'>Choisir un jour :</label>
            <input type='date' name='choix_jour' id='choix_jour'>

            <input type='submit' value='Filtrer'>
            </form>
    </fieldset>

    <section>
        <h2 id="bg">Affichage des capteurs selon le filtre choisi</h2>
    <?php
    $nomCapteurSelectionne = isset($_POST['nom_capteur']) ? $_POST['nom_capteur'] : '';
    $typeCapteurSelectionne = isset($_POST['type_capteur']) ? $_POST['type_capteur'] : '';
    $triDate = isset($_POST['tri_date']) ? $_POST['tri_date'] : '';
    $jourChoisi = isset($_POST['choix_jour']) ? $_POST['choix_jour'] : '';
    $triValeur = isset($_POST['tri_valeur']) ? $_POST['tri_valeur'] : '';
    $salleSelectionnee = isset($_POST['salle']) ? $_POST['salle'] : '';


    // Requête SQL pour obtenir les capteurs en fonction des filtres
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
    // pour chaque capteur, en fonction de son type, avoir l'unité et en faire un tableau
    while ($ligneCapteur = mysqli_fetch_assoc($resultatCapteursFiltre)) {//fait un tableau pour chaque capteur sélectionné dans la requete SQL (qui font parti du filtre)
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

        // Obtenir la moyenne pour le capteur
        $requeteMoyCapteur = "SELECT ROUND(AVG(valeur_mesure), 2) AS moyenne FROM mesure WHERE nom_capteur = '$nomCapteur'";
        $resultatMoyCapteur = mysqli_query($connexion, $requeteMoyCapteur);
        $ligneMoyCapteur = mysqli_fetch_assoc($resultatMoyCapteur);
        $moyenneCapteur = $ligneMoyCapteur['moyenne'];

        echo "<div class='block'>
        <h3 class='top_block'>Capteur de $type_capteur : $nomCapteur (Salle : $salleCapteur)</h3>";

        // Récupérer et afficher les valeurs historiques en fonction du tri (asc ou desc)
        $requeteValHistorique = "SELECT * FROM mesure WHERE nom_capteur = '$nomCapteur'";

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
                $requeteValHistorique .= " ORDER BY date_mesure DESC"; // Tri par date par défaut si aucun tri n'est spécifié
            }
        }

        $resultatValHistorique = mysqli_query($connexion, $requeteValHistorique);
        
        $sommeMesures = 0;
        $nombreMesures = 0;

        if (mysqli_num_rows($resultatValHistorique) > 0) {
            echo "<table>
                    <tr>
                        <th>ID Mesure</th>
                        <th>Date Mesure</th>
                        <th>Valeur Mesure</th>
                        <th>Nom Capteur</th>
                    </tr>";
            while ($ligneValHistorique = mysqli_fetch_assoc($resultatValHistorique)) {
                $idMesure = $ligneValHistorique['id_mesure'];
                $dateMesure = $ligneValHistorique['date_mesure'];
                $valeurMesure = $ligneValHistorique['valeur_mesure'];
                $nomCapteur = $ligneValHistorique['nom_capteur'];
                $sommeMesures += $valeurMesure;
                $nombreMesures++;

                echo "<tr>
                        <td>$idMesure</td>
                        <td>$dateMesure</td>
                        <td>$valeurMesure $unite</td>
                        <td>$nomCapteur</td>
                    </tr>";
            }
            echo "</table>";
            $moyenneAffichee = round($sommeMesures / $nombreMesures, 2);
            echo "<h3 class='bot_block'>Moyenne du capteur de $type_capteur : $moyenneCapteur $unite</h3>";
            echo "<h3 class='bot_block'>Moyenne des mesures affichées : $moyenneAffichee $unite</h3>";
        
        } else  {
            echo "<p>Ce capteur n'a pas de valeurs renseignées avec les filtres choisis.</p>";
        }
        echo "</div>";
    }
    ?>
    </section>
</body>
</html>
