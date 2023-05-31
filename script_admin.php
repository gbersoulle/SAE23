<?php
echo "Accès au fichier de modification <br/>";

if(isset($_POST['submit_ajouter_capteur'])){
    echo "En cours d'ajout de capteur <br/>";
    if (empty($_POST['nom_capteur']) || empty($_POST['id_capteur']) || empty($_POST['type_capteur']) || empty($_POST['nom_bat']) || empty($_POST['salle_capteur'])) { //Teste si les champs sont vides pour éviter les capteurs vides
        echo "Il manque un élément dans les champs renseignés";
        exit;
    }
    require('connexion_bdd.php'); 
    // Récup des valeurs et les met dans la BDD
    $id_capteur = $_POST['id_capteur'];
    $nomCapteur = $_POST['nom_capteur'];
    $typeCapteur = $_POST['type_capteur'];
    $Salle = $_POST['Salle'];
    $idBatiment = $_POST['nom_bat'];
    $sql = "INSERT INTO capteur (id_capteur,nom_capteur, type_capteur, Salle, id_batiment) VALUES ('$id_capteur','$nomCapteur', '$typeCapteur', '$Salle', $idBatiment)"; 
    echo "$sql <br/>";
    if (mysqli_query($connexion, $sql)) {
        echo "Le texte a été ajouté avec succès.";
    } else {
        echo "Erreur: " . mysqli_error($connexion);
    }
    mysqli_close($connexion);
    
}

if(isset($_POST['submit_ajouter_battiment'])){
    if (empty($_POST['login_gest']) || empty($_POST['mdp_gest']) || empty($_POST['nom_bat'])) { //Teste si les champs sont vides pour éviter les capteurs vides
        echo "Il y a un soucis au niveau des champs renseignés";
        exit; 
    }
    require('connexion_bdd.php');
    // Récup des valeurs et les met dans la BDD
    $nom_bat = $_POST['nom_bat'];
    $login_gest = $_POST['login_gest'];
    $mdp_gest = hash('sha256', $_POST['mdp_gest']);
    $sql = "INSERT INTO batiment (nom_bat, login_gest, mdp_gest) VALUES ('$nom_bat', '$login_gest', '$mdp_gest')";
    mysqli_query($connexion, $sql);  
    mysqli_close($connexion); 
}


if (isset($_POST['submit_supprimer_capteur']) && isset($_POST['capteurs'])) {
    if (empty($_POST['capteurs'])) { //Teste si les champs sont vides pour éviter les capteurs vides
        echo "Il y a un soucis au niveau des champs renseignés";
        exit();
    }
    require('connexion_bdd.php');
    foreach ($_POST['capteurs'] as $idCapteur) {
        //Pour supprimer capteurs faut avoir suppr toutes les données associées

        $sqlMesureSuppr = "DELETE FROM mesure WHERE id_capteur = " . intval($idCapteur);
        $sqlCapteurSuppr = "DELETE FROM capteur WHERE id_capteur = " . intval($idCapteur);

        mysqli_query($connexion, $sqlCapteurSuppr);
        mysqli_query($connexion, $sqlMesureSuppr);
    }
    mysqli_close($connexion);

}



if (isset($_POST['submit_supprimer_batt']) && isset($_POST['batiment'])) {
    if (empty($_POST['batiment'])) { //Teste si les champs sont vides pour éviter les capteurs vides
        echo "Il y a un soucis au niveau des champs renseignés";
        exit();
    }
    require('connexion_bdd.php');
    foreach ($_POST['batiment'] as $id_batiment) {
            //Pour supprimer un batt faut avoir supprimé tout les capteurs et toutes les données associées

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