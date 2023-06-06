<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Administration</title>
</head>
<body>
    <?php require('header.php');?>

    <!-- Ajouter ou supprimer un capteur -->
    <div class="add_c">
    <fieldset>
        <legend>Ajouter un capteur</legend>
        <form method="POST" action="script_admin.php">
            <label for="nom_capteur">Saisir le nom du capteur</label>
            <input type="texte" name="nom_capteur" placeholder="Ex : AM107-6" required>
            
            <label for="type_capteur">Choisir le type du capteur</label>
            <select name="type_capteur" required>
                <option value="temperature">Température</option>
                <option value="humidity">Humiditée</option>
                <option value="activity">Activitée</option>
                <option value="co2">CO2</option>
                <option value="tvoc">Tvoc</option>
                <option value="illumination">Illumination</option>
                <option value="infrared">Infrarouge</option>
                <option value="infrared_and_visible">Infrarouge et Visible</option>
                <option value="pressure">Pression</option>
            </select>


            <label for="nom_bat">Choisir le battiment attribué au capteur</label>
            <select name="nom_bat" required>
            <?php
                require('connexion_bdd.php');
                $requeteBattiment = mysqli_query($connexion, "SELECT nom_bat, id_batiment FROM batiment");
                if (!$requeteBattiment) {
                    die("Soucis de requête" . mysqli_error($connexion));
                }
                while ($ligne = mysqli_fetch_assoc($requeteBattiment)) {
                    $nomBatiment = $ligne['nom_bat'];
                    $idBatiment = $ligne['id_batiment'];
                    
                    // Ajout de l'option au select
                    echo '<option value="' . $idBatiment . '">' . $nomBatiment . '</option>';
                }
                mysqli_close($connexion);

            ?>
            </select>
            <label for="salle_capteur">Saisir la salle du capteur</label>
            <input type="texte" name="salle_capteur" placeholder="Ex : B206" required>
            <input type="submit" name="submit_ajouter_capteur" value="Valider">
        </form>
    </fieldset>
    </div>

    <div class="add_c">
    <fieldset>
        <legend>Supprimer un capteur</legend>
            <p>ATTENTION SUPPRIMER UN CAPTEUR SUPPRIMERA TOUTES LES valeurs associées</p>
    
    <!-- Afficher un tableau qui contiens tout les capteurs -->
    <form method="POST" action="script_admin.php">
  <table>
    <tr>
      <th>ID du Capteur</th>
      <th>Nom du Capteur</th>
      <th>Type de Capteur</th>
      <th>Bâtiment affecté</th>
      <th>Salle affecté</th>
      <th>Supprimer</th>
    </tr>
    <?php
    require('connexion_bdd.php');
    $sql = "SELECT capteur.*, batt.nom_bat
            FROM capteur
            INNER JOIN batiment batt ON capteur.id_batiment = batt.id_batiment";
    $ToutLesCapteurs = mysqli_query($connexion, $sql);
    mysqli_close($connexion);
    while ($ligne = mysqli_fetch_assoc($ToutLesCapteurs)) {
        $idCapteur = $ligne['id_capteur'];
        $nomCapteur = $ligne['nom_capteur'];
        $typeCapteur = $ligne['type_capteur'];
        $nomBatiment = $ligne['nom_bat'];
        $Salle = $ligne['Salle'];

        echo "<tr>";
        echo "<td>" . $idCapteur . "</td>";
        echo "<td>" . $nomCapteur . "</td>";
        echo "<td>" . $typeCapteur . "</td>";
        echo "<td>" . $nomBatiment . "</td>";
        echo "<td>" . $Salle . "</td>";
        echo "<td><input type='checkbox' name='capteurs[]' value='" . $idCapteur . "'></td>";
        echo "</tr>";
    }
?>
</table>
  <input type="submit" name="submit_supprimer_capteur" value="Supprimer les capteurs sélectionnés">
</form>
</fieldset>
</div>

    <!-- Ajouter ou supprimer un batt -->
    <div class="add_b">
        <fieldset>
            <legend>Ajouter un battiment</legend>
        <form method="POST" action="script_admin.php">
            <label for="nom_bat">Saisir le nom du batiment</label>
            <input type="texte" name="nom_bat" placeholder="Par ici le texte" required></br></br>
            
            <label for="login_gest">Saisir le nom du gestionaire</label>
            <input type="texte" name="login_gest" placeholder="Par ici le texte" required></br></br>

            <label for="mdp_gest">Saisir le Mdp du gestionaire</label>
            <input type="password" name="mdp_gest" placeholder="Par ici le texte" required></br></br>

            <input class="bu" type="submit" name="submit_ajouter_battiment" value="Ajouter un Battiment">
        </form>
        </fieldset>
    </div>

    <div class="del_b">
    <!-- Afficher tout les batt -->
    <fieldset>
        <legend>Supprimer un bâtiment</legend>
        <p>ATTENTION SUPPRIMER UN BÂTIMENT SUPPRIMERA TOUS LES CAPTEURS ET LES MESURES ASSOCIÉES </p>

        <form method="POST" action="script_admin.php">
            <table>
                <tr>
                    <th>Nom du Bâtiment</th>
                    <th>Nombre Capteurs associés</th>
                    <th>Gestionnaire</th>
                    <th>Supprimer</th>
                </tr>
                <?php
                require('connexion_bdd.php');
                $sql = "SELECT batt.nom_bat AS nom_batiment, batt.login_gest, COUNT(capteur.id_capteur) AS nombre_capteurs, batt.id_batiment
                        FROM batiment batt 
                        LEFT JOIN capteur capteur ON batt.id_batiment = capteur.id_batiment 
                        GROUP BY batt.id_batiment"; // Left join --> Récupère les bâtiments même ceux qui n'ont pas de correspondance dans la base capteur
                $ToutLesBattiments = mysqli_query($connexion, $sql);
                mysqli_close($connexion);
                while ($ligne = mysqli_fetch_assoc($ToutLesBattiments)) {
                    $id_batiment = $ligne['id_batiment'];
                    $nomBatiment = $ligne['nom_batiment'];
                    $nombreCapteurs = $ligne['nombre_capteurs'];
                    $gestionnaire = $ligne['login_gest'];
                    echo "<tr>";
                    echo "<td>" . $nomBatiment . "</td>";
                    echo "<td>" . $nombreCapteurs . "</td>";
                    echo "<td>" . $gestionnaire . "</td>";
                    echo "<td><input type='checkbox' name='batiment[]' value='" . $id_batiment . "'></td>";
                    echo "</tr>";
                }
                ?>
            </table></br>
            <input class="bu" type="submit" name="submit_supprimer_batt" value="Supprimer les bâtiments sélectionnés">
        </form>
    </fieldset>
    </div>

<div class="updt_g">
<fieldset>
    <legend>Modifier un gestionnaire</legend>
    <form method="POST" action="script_admin.php">
    <label for="id_bat">Nom du gestionnaire à modifier</label>
        <select name="id_bat" required>
        <?php
            require('connexion_bdd.php');
            $sqlgestionnaire = mysqli_query($connexion, "SELECT login_gest, id_batiment FROM batiment");
            if (!$sqlgestionnaire) {
                die("Soucis de requête" . mysqli_error($connexion));
            }
            while ($ligne = mysqli_fetch_assoc($sqlgestionnaire)) {
                $login_gest = $ligne['login_gest'];
                $idBatiment = $ligne['id_batiment'];
                
                // Ajout de l'option au select
                echo '<option value="' . $idBatiment . '">' . $login_gest . '</option>';
            }
            mysqli_close($connexion);

        ?>
        </select>
        <label for="change_login_gest">Remplir pour changer le nom du gestionaire</label>
        <input type="texte" name="change_login_gest" placeholder="Par ici le texte"> 
        <label for="change_mdp_gest">Remplir pour changer le mdp du gestionaire</label>
        <input type="password" name="change_mdp_gest" placeholder="Par ici le texte"> 
        <input type="submit" name="submit_change_gestionnaire" value="Modifier">
    </form>
    </fieldset>
    </div>

    
</body>
</html>


