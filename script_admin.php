<?php
if(isset($_POST['submit_ajouter_capteur'])){
    require('connexion_bdd.php');
    $nomCapteur = $_POST['nom_capteur'];
    $typeCapteur = $_POST['type_capteur'];
    $idBatiment = $_POST['nom_bat'];
    $sql = "INSERT INTO capteur (nom_capteur, type_capteur, id_batiment) VALUES ('$nomCapteur', '$typeCapteur', $idBatiment)";
    mysqli_query($connexion, $sql);  
    mysqli_close($connexion);
    
    
}

if(isset($_POST['submit_ajouter_battiment'])){
    require('connexion_bdd.php');
    $nom_bat = $_POST['nom_bat'];
    $login_gest = $_POST['login_gest'];
    $mdp_gest = $_POST['mdp_gest'];
    $sql = "INSERT INTO batiment (nom_bat, login_gest, mdp_gest) VALUES ('$nom_bat', '$login_gest', '$mdp_gest')";
    mysqli_query($connexion, $sql);  
    mysqli_close($connexion); 
}


if (isset($_POST['submit_supprimer_capteur']) && isset($_POST['capteurs'])) {
    require('connexion_bdd.php');
    foreach ($_POST['capteurs'] as $index => $idCapteur) {

        $sqlMesureSuppr = "DELETE FROM mesure WHERE id_capteur = " . intval($idCapteur);
        $sqlCapteurSuppr = "DELETE FROM capteur WHERE id_capteur = " . intval($idCapteur);

        mysqli_query($connexion, $sqlCapteurSuppr);
        mysqli_query($connexion, $sqlMesureSuppr);
    }
    mysqli_close($connexion);

}



if (isset($_POST['submit_supprimer_batt']) && isset($_POST['batiment'])) {
    require('connexion_bdd.php');
    foreach ($_POST['batiment'] as $id_batiment) {

            $sqlMesureSuppr = "DELETE FROM mesure WHERE id_capteur IN (SELECT id_capteur FROM capteur WHERE id_batiment = $id_batiment)";
            $sqlCapteurSuppr = "DELETE FROM capteur WHERE id_batiment = $id_batiment";
            $sqlBattimentSuppr = "DELETE FROM batiment WHERE id_batiment = $id_batiment";

            mysqli_query($connexion, $sqlMesureSuppr);
            mysqli_query($connexion, $sqlCapteurSuppr);
            mysqli_query($connexion, $sqlBattimentSuppr);
    }
    mysqli_close($connexion);
}



header("Location: admin.php");
exit();
?>