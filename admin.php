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
    <fieldset>
        <legend>Ajouter un capteur</legend>
    <form method="POST">
        <label for="nom_capteur">Saisir le nom du capteur</label>
        <input type="texte" name="nom_capteur" placeholder="Par ici le texte">
        
        <p>Choisir le type du capteur</p>
        <input type="radio" name="type_capteur" value="oxygene">
        <label for="oxygene">Oxygèene</label><br>
        <input type="radio" name="type_capteur" value="lux">
        <label for="lux">lux</label><br>
        <input type="radio" name="type_capteur" value="co2">
        <label for="co2">co2</label><br>  

        <select name="nom_bat">
        <?php
            require('connexion_bdd.php');
            $requeteBattiment = mysqli_query($connexion, "SELECT nom_bat, id_batiment FROM batiment");
            mysqli_close($connexion);
            if (!$requeteBattiment) {
                die("Soucis de requête" . mysqli_error($connexion));
            }
            while ($ligne = mysqli_fetch_assoc($requeteBattiment)) {
                $nomBatiment = $ligne['nom_bat'];
                $idBatiment = $ligne['id_batiment'];
                
                // Ajout de l'option au select
                echo '<option value="' . $idBatiment . '">' . $nomBatiment . '</option>';
            }

        ?>
        </select>
        <input type="submit" name="submit_ajouter_capteur" value="Ajouter un Capteur">
    </form>
    </fieldset>
    <fieldset>
        <legend>Supprimer un capteur</legend>
            <p>ATTENTION SUPPRIMER UN CAPTEUR SUPPRIMERA TOUTES LES valeurs associées</p>
    
    <!-- Afficher un tableau qui contiens tout les capteurs -->
    <form method="POST">
  <table>
    <tr>
      <th>Nom du Capteur</th>
      <th>Type de Capteur</th>
      <th>Bâtiment affecté</th>
      <th>Supprimer</th>
    </tr>
    <?php
    require('connexion_bdd.php');
    $sql = "SELECT capteur.id_capteur, capteur.nom_capteur, capteur.type_capteur, batt.nom_bat
            FROM capteur
            INNER JOIN batiment batt ON capteur.id_batiment = batt.id_batiment";
    $ToutLesCapteurs = mysqli_query($connexion, $sql);
    mysqli_close($connexion);
    while ($ligne = mysqli_fetch_assoc($ToutLesCapteurs)) {
        $idCapteur = $ligne['id_capteur'];
        $nomCapteur = $ligne['nom_capteur'];
        $typeCapteur = $ligne['type_capteur'];
        $nomBatiment = $ligne['nom_bat'];
        echo "<tr>";
        echo "<td>" . $nomCapteur . "</td>";
        echo "<td>" . $typeCapteur . "</td>";
        echo "<td>" . $nomBatiment . "</td>";
        echo "<td><input type='checkbox' name='capteurs[]' value='" . $idCapteur . "'></td>";
        echo "</tr>";
    }
?>

  </table>
  <input type="submit" name="submit_supprimer_capteur" value="Supprimer les capteurs sélectionnés">
</form>
</fieldset>
    <!-- Ajouter ou supprimer un batt -->
    <fieldset>
        <legend>Ajouter un battiment</legend>
    <form method="POST">
        <label for="nom_bat">Saisir le nom du batiment</label>
        <input type="texte" name="nom_bat" placeholder="Par ici le texte">
        
        <label for="login_gest">Saisir le nom du gestionaire</label>
        <input type="texte" name="login_gest" placeholder="Par ici le texte"> 

        <label for="mdp_gest">Saisir le Mdp du gestionaire</label>
        <input type="texte" name="mdp_gest" placeholder="Par ici le texte">

        <input type="submit" name="submit_ajouter_battiment" value="Ajouter un Battiment">
    </form>
    </fieldset>
    <!-- Afficher tout les batt -->
    <fieldset>
        <legend>Supprimer un battiment</legend>
            <p>ATTENTION SUPPRIMER UN CAPTEUR SUPPRIMERA TOUTES LES CAPTEURS ainsi que leurs valeurs associées</p>
    
    <!-- Afficher un tableau qui contiens tout les capteurs -->
    <form method="POST">
  <table>
    <tr>
      <th>Nom du Battiment</th>
      <th>Nombre Capteurs associées</th>
      <th>Supprimer</th>
    </tr>
<?php
    require('connexion_bdd.php');
    $sql = "SELECT batt.nom_bat AS nom_batiment, COUNT(capteur.id_capteur) AS nombre_capteurs, batt.id_batiment
            FROM batiment batt 
            LEFT JOIN capteur capteur ON batt.id_batiment = capteur.id_batiment 
            GROUP BY batt.id_batiment";
    $ToutLesBattiments = mysqli_query($connexion, $sql);
    mysqli_close($connexion);
    while ($ligne = mysqli_fetch_assoc($ToutLesBattiments)) {
        $id_batiment = $ligne['id_batiment'];
        $nomBatiment = $ligne['nom_batiment'];
        $nombreCapteurs = $ligne['nombre_capteurs'];
        echo "<tr>";
        echo "<td>" . $nomBatiment . "</td>";
        echo "<td>" . $nombreCapteurs . "</td>";
        echo "<td><input type='checkbox' name='batiment[]' value='" . $id_batiment . "'></td>";
        echo "</tr>";
    }
?>
    </table>
   <input type="submit" name="submit_supprimer_batt" value="Supprimer les battiments sélectionnés">
</form>



    <?php
if(isset($_POST['submit_ajouter_capteur'])){
    require('connexion_bdd.php');
    $nomCapteur = $_POST['nom_capteur'];
    $typeCapteur = $_POST['type_capteur'];
    $idBatiment = $_POST['nom_bat'];
    $sql = "INSERT INTO capteur (nom_capteur, type_capteur, id_batiment) VALUES ('$nomCapteur', '$typeCapteur', $idBatiment)";
    mysqli_query($connexion, $sql);  
    mysqli_close($connexion);
    header("Location: admin.php");
    exit();
    
}

if(isset($_POST['submit_ajouter_battiment'])){
    require('connexion_bdd.php');
    $nom_bat = $_POST['nom_bat'];
    $login_gest = $_POST['login_gest'];
    $mdp_gest = $_POST['mdp_gest'];
    $sql = "INSERT INTO batiment (nom_bat, login_gest, mdp_gest) VALUES ('$nom_bat', '$login_gest', '$mdp_gest')";
    mysqli_close($connexion); 
    header("Location: admin.php");
    exit();
}
if (isset($_POST['submit_supprimer_capteur']) && isset($_POST['capteurs'])) {
    require('connexion_bdd.php');
    foreach ($_POST['capteurs'] as $index => $idCapteur) {

        // Supprimer les valeurs associées à ce capteur dans la table `mesure`
        $sqlMesureSuppr = "DELETE FROM mesure WHERE id_capteur = " . intval($idCapteur);

        mysqli_query($connexion, $sqlMesureSuppr);
        // Effectuer la suppression du capteur dans la base de données
        $sqlCapteurSuppr = "DELETE FROM capteur WHERE id_capteur = " . intval($idCapteur);
        mysqli_query($connexion, $sqlCapteurSuppr);
    }
    mysqli_close($connexion);
    header("Location: admin.php");
    exit();
}



if (isset($_POST['submit_supprimer_batt']) && isset($_POST['batiment'])) {
    require('connexion_bdd.php');
    foreach ($_POST['batiment'] as $id_batiment) {
        // Récupérer les capteurs associés au bâtiment
        $sqlCapteurs = "SELECT id_capteur FROM capteur WHERE id_batiment = " . intval($id_batiment);
        $resultCapteurs = mysqli_query($connexion, $sqlCapteurs);

        if ($resultCapteurs) {
            while ($ligne = mysqli_fetch_assoc($resultCapteurs)) {
                $idCapteur = $ligne['id_capteur'];

                $sqlMesureSuppr = "DELETE FROM mesure WHERE id_capteur = " . intval($idCapteur); // Supprimer les valeurs associées à ce capteur dans la table `mesure`
                $sqlCapteurSuppr = "DELETE FROM capteur WHERE id_capteur = " . intval($idCapteur); // Supprimer le capteur dans la table `capteur`

                mysqli_query($connexion, $sqlMesureSuppr);
                mysqli_query($connexion, $sqlCapteurSuppr);
            }
        }
    }

    mysqli_close($connexion);
}



?>
</body>
</html>


