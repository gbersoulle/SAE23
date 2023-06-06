<?php
echo 'Retour en arrière <a href="admin.php">retour</a><br>';
echo "Accès au fichier de modification <br/>";


if(isset($_POST['submit_ajouter_capteur'])){
    echo "En cours d'ajout de capteur <br/>";
    if (empty($_POST['nom_capteur']) || empty($_POST['type_capteur']) || empty($_POST['nom_bat']) || empty($_POST['salle_capteur'])) { //Teste si les champs sont vides pour éviter les capteurs vides
        echo "Il manque un élément dans les champs renseignés";
        exit;
    }
    require('connexion_bdd.php'); 
    // Récup des valeurs et échappes
    $nomCapteur = mysqli_real_escape_string($connexion,htmlspecialchars($_POST['nom_capteur'], ENT_QUOTES, 'UTF-8'));
    $typeCapteur = mysqli_real_escape_string($connexion,htmlspecialchars($_POST['type_capteur'], ENT_QUOTES, 'UTF-8'));
    $Salle = mysqli_real_escape_string($connexion,htmlspecialchars($_POST['salle_capteur'], ENT_QUOTES, 'UTF-8'));
    $idBatiment = intval($_POST['nom_bat']);
    $sql = "INSERT INTO capteur (nom_capteur, type_capteur, Salle, id_batiment) VALUES (?, ?, ?, ?)"; 
    $stmt = mysqli_prepare($connexion, $sql); // permet de préparer la requete dans $stmt 

    // Vérification de la préparation de la requête
    if ($stmt === false) {
        echo "Erreur dans la prep de la requete: " . mysqli_error($connexion);
        exit;
    }
    mysqli_stmt_bind_param($stmt, "sssi", $nomCapteur, $typeCapteur, $Salle, $idBatiment); // s = string (chaine de caractères) i = integrer
    
    if (!mysqli_stmt_execute($stmt)) {
        echo "Erreur: " . mysqli_stmt_error($stmt);
    }
    
    // Fermeture du statement et de la connexion à la base de données
    mysqli_stmt_close($stmt);
    mysqli_close($connexion);
    
}



if (isset($_POST['submit_ajouter_battiment'])) {
    if (empty($_POST['login_gest']) || empty($_POST['mdp_gest']) || empty($_POST['nom_bat'])) {
        echo "Il y a un soucis au niveau des champs renseignés";
        exit;
    }
    require('connexion_bdd.php');
    
    // Récup les valeurs et évite les caractères spéciaux (eviter les injections)
    $nom_bat = mysqli_real_escape_string($connexion, htmlspecialchars($_POST['nom_bat'], ENT_QUOTES, 'UTF-8'));
    $login_gest = mysqli_real_escape_string($connexion, htmlspecialchars($_POST['login_gest'], ENT_QUOTES, 'UTF-8'));
    $mdp_gest = hash('sha256', $_POST['mdp_gest']);
    $sql = "INSERT INTO batiment (nom_bat, login_gest, mdp_gest) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connexion, $sql);
    
    if ($stmt === false) {
        echo "Erreur dans la préparation de la requête: " . mysqli_error($connexion);
        exit;
    }
    
    mysqli_stmt_bind_param($stmt, "sss", $nom_bat, $login_gest, $mdp_gest); // lie la requete avec les variables
    
    if (!mysqli_stmt_execute($stmt)) {
        echo "Erreur: " . mysqli_stmt_error($stmt); // execute et  renvoie les erreurs si il y en a 
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($connexion);
}




if (isset($_POST['submit_supprimer_capteur']) && isset($_POST['capteurs'])) {
    if (empty($_POST['capteurs'])) {
        echo "Il y a un souci au niveau des champs renseignés (capteurs)";
        exit();
    }
    require('connexion_bdd.php');
    $sqlMesureSuppr = "DELETE FROM mesure WHERE nom_capteur IN (SELECT nom_capteur FROM capteur WHERE id_capteur = ?)";
    $sqlCapteurSuppr = "DELETE FROM capteur WHERE id_capteur = ?";

    $stmtMesureSuppr = mysqli_prepare($connexion, $sqlMesureSuppr);
    $stmtCapteurSuppr = mysqli_prepare($connexion, $sqlCapteurSuppr);

    if ($stmtMesureSuppr === false || $stmtCapteurSuppr === false) {
        echo "Erreur dans la préparation des requêtes : " . mysqli_error($connexion);
        exit();
    }

    mysqli_stmt_bind_param($stmtMesureSuppr, "i", $idCapteur);
    mysqli_stmt_bind_param($stmtCapteurSuppr, "i", $idCapteur);

    foreach ($_POST['capteurs'] as $idCapteur) {
        if (!mysqli_stmt_execute($stmtMesureSuppr)) {
            echo "Erreur: " . mysqli_stmt_error($stmtMesureSuppr);
        }
        if (!mysqli_stmt_execute($stmtCapteurSuppr)) {
            echo "Erreur: " . mysqli_stmt_error($stmtCapteurSuppr);
        }
    }

    mysqli_stmt_close($stmtMesureSuppr);
    mysqli_stmt_close($stmtCapteurSuppr);
    mysqli_close($connexion);
}





if (isset($_POST['submit_supprimer_batt'])) {
    if (empty($_POST['batiment'])) {
        echo "Il y a un souci au niveau des champs renseignés";
        exit();
    }
    require('connexion_bdd.php');

    $sqlMesureSuppr = "DELETE FROM mesure WHERE nom_capteur IN (SELECT nom_capteur FROM capteur WHERE id_batiment = ?);";
    $sqlCapteurSuppr = "DELETE FROM capteur WHERE id_batiment = ?";
    $sqlBatimentSuppr = "DELETE FROM batiment WHERE id_batiment = ?";

    $stmtMesureSuppr = mysqli_prepare($connexion, $sqlMesureSuppr);
    $stmtCapteurSuppr = mysqli_prepare($connexion, $sqlCapteurSuppr);
    $stmtBatimentSuppr = mysqli_prepare($connexion, $sqlBatimentSuppr);

    foreach ($_POST['batiment'] as $id_batiment) {
        mysqli_stmt_bind_param($stmtMesureSuppr, "i", $id_batiment);
        mysqli_stmt_bind_param($stmtCapteurSuppr, "i", $id_batiment);
        mysqli_stmt_bind_param($stmtBatimentSuppr, "i", $id_batiment);

        if (!mysqli_stmt_execute($stmtMesureSuppr)) {
            echo "Erreur: " . mysqli_stmt_error($stmtMesureSuppr);
        }
        if (!mysqli_stmt_execute($stmtCapteurSuppr)) {
            echo "Erreur: " . mysqli_stmt_error($stmtCapteurSuppr);
        }
        if (!mysqli_stmt_execute($stmtBatimentSuppr)) {
            echo "Erreur: " . mysqli_stmt_error($stmtBatimentSuppr);
        }
    }

    mysqli_stmt_close($stmtMesureSuppr);
    mysqli_stmt_close($stmtCapteurSuppr);
    mysqli_stmt_close($stmtBatimentSuppr);
    mysqli_close($connexion);
}

if (isset($_POST['submit_change_gestionnaire'])) {
    $id_batiment = $_POST['id_bat'];
    echo $id_batiment;
    require 'connexion_bdd.php';
    $sql_Login_Gest = "SELECT login_gest, mdp_gest FROM batiment WHERE id_batiment = $id_batiment";
    $LoginMdpGestionnaire = mysqli_query($connexion, $sql_Login_Gest);
    if (!$LoginMdpGestionnaire) {
        die("Soucis de requête" . mysqli_error($connexion));
    }
    $ligne = mysqli_fetch_assoc($LoginMdpGestionnaire);
    $ancienUser = mysqli_real_escape_string($connexion, htmlspecialchars($ligne['login_gest'], ENT_QUOTES, 'UTF-8'));
    $ancienMdp = mysqli_real_escape_string($connexion, htmlspecialchars($ligne['mdp_gest'], ENT_QUOTES, 'UTF-8'));
    $nvUser = $ancienUser; 
    $nvMdp = $ancienMdp; // si mdp ou user pas changé, ça remet le meme par défaut

    // Vérifier si les nouvelles valeurs ont été fournies dans le formulaire
    if (!empty($_POST['change_login_gest'])) {
        $nvUser = mysqli_real_escape_string($connexion, htmlspecialchars($_POST['change_login_gest'], ENT_QUOTES, 'UTF-8'));
    }
    if (!empty($_POST['change_mdp_gest'])) {
        $nvMdp = mysqli_real_escape_string($connexion, htmlspecialchars($_POST['change_mdp_gest'], ENT_QUOTES, 'UTF-8'));
    }
  
    $sql_update_gest = "UPDATE batiment SET login_gest = ?, mdp_gest = ? WHERE id_batiment = ?";
    $stmt_update_gest = mysqli_prepare($connexion, $sql_update_gest);
    if ($stmt_update_gest === false) {
        echo "Erreur dans la préparation de la requête : " . mysqli_error($connexion);
        exit();
    }
    mysqli_stmt_bind_param($stmt_update_gest, "ssi", $nvUser, $nvMdp, $id_batiment);
    if (!mysqli_stmt_execute($stmt_update_gest)) {
        echo "Erreur: " . mysqli_stmt_error($stmt_update_gest);
    } else {
        echo "Modifié";
    }
}


    // echo "ancien mdp". $ancienMdp;
    // echo "ancien user". $ancienUser;
    // echo "nv mdp". $nvMdp;
    // echo "nv user". $nvUser;





header("Location: admin.php");
exit();
?>