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
    $idBatiment = $ligneBatiment['id_batiment']; //Récupère le batiment géré par cet utilisateur

    $requeteCapteurs = "SELECT nom_capteur, type_capteur FROM capteur WHERE id_batiment = '$idBatiment'";
    $resultatCapteurs = mysqli_query($connexion, $requeteCapteurs); //récup tout les capteurs du bat en question

    // pour chaque capteur, en fonction de son type, avoir l'unitée, et en faire un tableau
    while ($ligneCapteur = mysqli_fetch_assoc($resultatCapteurs)) {
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

        echo "<h2>Moyenne du capteur $nomCapteur : $moyenneCapteur $unite</h2>";

        // Recup et afficher Les valeurs historiques
        $requeteHistorique = "SELECT * FROM mesure WHERE nom_capteur = '$nomCapteur'";
        $resultatHistorique = mysqli_query($connexion, $requeteHistorique);

        if (mysqli_num_rows($resultatHistorique) > 0) {
            echo "<table>
                    <tr>
                        <th>ID Mesure</th>
                        <th>Date Mesure</th>
                        <th>Valeur Mesure</th>
                        <th>Nom Capteur</th>
                    </tr>";
            while ($ligneHistorique = mysqli_fetch_assoc($resultatHistorique)) {
                $idMesure = $ligneHistorique['id_mesure'];
                $dateMesure = $ligneHistorique['date_mesure'];
                $valeurMesure = $ligneHistorique['valeur_mesure'];
                $nomCapteur = $ligneHistorique['nom_capteur'];
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
