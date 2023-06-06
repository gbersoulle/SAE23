<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Gestion</title>
</head>
<body>
    <?php
    require('header.php');
    $nomUtilisateur = $_SESSION["user"];
    ?>
    <h1>Page de gestion de <?php echo $nomUtilisateur ?> (affichage des capteurs du bâtiment du gestionnaire qui s'est connecté)</h1>
    <?php
    require_once 'connexion_bdd.php';

    $requeteBatiment = "SELECT id_batiment FROM batiment WHERE login_gest = '$nomUtilisateur'";
    $resultatBatiment = mysqli_query($connexion, $requeteBatiment);
    $ligneBatiment = mysqli_fetch_assoc($resultatBatiment);
    $idBatiment = $ligneBatiment['id_batiment']; //Récupère le bâtiment géré par cet utilisateur

    $requeteCapteurs = "SELECT nom_capteur, type_capteur FROM capteur WHERE id_batiment = '$idBatiment'";
    $resultatCapteurs = mysqli_query($connexion, $requeteCapteurs); //récupère tous les capteurs du bâtiment en question
    ?>
    <form method='GET'>
    <label for='capteur'>Choisir un capteur :</label>
    <select name='capteur' id='capteur'>
    <option value=''>Tous les capteurs</option>
        <?php
        // Ajout des options pour chaque capteur
        while ($ligneCapteur = mysqli_fetch_assoc($resultatCapteurs)) {
            $nomCapteur = $ligneCapteur['nom_capteur'];
            echo "<option value='$nomCapteur'>$nomCapteur</option>";
        }
        ?>
    </select>
    <input type='submit' value='Filtrer'>
    </form>



    <?php
    $capteurSelectionne = isset($_GET['capteur']) ? $_GET['capteur'] : ''; //capteur sélectionné

    // Requête SQL pour obtenir les capteurs en fonction du filtre
    $requeteCapteursFiltre = "SELECT nom_capteur, type_capteur FROM capteur WHERE id_batiment = '$idBatiment'";

    if (!empty($capteurSelectionne)) {
        $requeteCapteursFiltre .= " AND nom_capteur = '$capteurSelectionne'";
    }

    $resultatCapteursFiltre = mysqli_query($connexion, $requeteCapteursFiltre);

    // pour chaque capteur, en fonction de son type, avoir l'unité et en faire un tableau
    while ($ligneCapteur = mysqli_fetch_assoc($resultatCapteursFiltre)) {//fait un tableau pour chaque capteur sélectionné dans la requete SQL (qui font parti du filtre)
        $nomCapteur = $ligneCapteur['nom_capteur'];
        $type_capteur = $ligneCapteur['type_capteur'];

        $unite = "";
        switch ($type_capteur) {
            case "temperature":
                $unite = "°C";
                break;
            case "humidity":
                $unite = "%";
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
                $unite = "Pa";
                break;
            default:
                $unite = "";
        }

        // Obtenir la moyenne pour le capteur
        $requeteMoyCapteur = "SELECT AVG(valeur_mesure) AS moyenne FROM mesure WHERE nom_capteur = '$nomCapteur'";
        $resultatMoyCapteur = mysqli_query($connexion, $requeteMoyCapteur);
        $ligneMoyCapteur = mysqli_fetch_assoc($resultatMoyCapteur);
        $moyenneCapteur = $ligneMoyCapteur['moyenne'];

        echo "<h2>Moyenne du capteur de $type_capteur : $nomCapteur : $moyenneCapteur $unite</h2>";

        // Récupérer et afficher les valeurs historiques
        $requeteValHistorique = "SELECT * FROM mesure WHERE nom_capteur = '$nomCapteur'";
        $resultatValHistorique = mysqli_query($connexion, $requeteValHistorique);

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
                echo "<tr>
                        <td>$idMesure</td>
                        <td>$dateMesure</td>
                        <td>$valeurMesure $unite</td>
                        <td>$nomCapteur</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Ce capteur n'a pas de valeurs renseignées.</p>";
        }
    }
    ?>
</body>
</html>
