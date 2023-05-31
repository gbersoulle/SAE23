<?php
echo "Accès au fichier de modification <br/>";

if(isset($_POST['submit_ajouter_capteur'])){
    echo "En cours d'ajout de capteur <br/>";
    if (empty($_POST['nom_capteur']) || empty($_POST['id_capteur']) || empty($_POST['type_capteur']) || empty($_POST['nom_bat']) || empty($_POST['salle_capteur'])) { //Teste si les champs sont vides pour éviter les capteurs vides
        echo "Il manque un élément dans les champs renseignés";
        exit;
    }
    require('connexion_bdd.php'); 
    // Récup des valeurs et échappes
    $id_capteur = mysqli_real_escape_string($connexion,htmlspecialchars($_POST['id_capteur'], ENT_QUOTES, 'UTF-8'));
    $nomCapteur = mysqli_real_escape_string($connexion,htmlspecialchars($_POST['nom_capteur'], ENT_QUOTES, 'UTF-8'));
    $typeCapteur = mysqli_real_escape_string($connexion,htmlspecialchars($_POST['type_capteur'], ENT_QUOTES, 'UTF-8'));
    $Salle = mysqli_real_escape_string($connexion,htmlspecialchars($_POST['salle_capteur'], ENT_QUOTES, 'UTF-8'));
    $idBatiment = intval($_POST['nom_bat']);
    $sql = "INSERT INTO capteur (id_capteur, nom_capteur, type_capteur, Salle, id_batiment) VALUES (?, ?, ?, ?, ?)"; 
    $stmt = mysqli_prepare($connexion, $sql); // permet de préparer la requete dans $stmt 

    // Vérification de la préparation de la requête
    if ($stmt === false) {
        echo "Erreur dans la prep de la requete: " . mysqli_error($connexion);
        exit;
    }
    mysqli_stmt_bind_param($stmt, "ssssi", $id_capteur, $nomCapteur, $typeCapteur, $Salle, $idBatiment); // s = string (chaine de caractères) i = integrer
    
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
        echo "Il y a un soucis au niveau des champs renseignés";
        exit();
    }
    require('connexion_bdd.php');

    $sqlMesureSuppr = "DELETE FROM mesure WHERE id_capteur = ?"; // Requetes préparées
    $sqlCapteurSuppr = "DELETE FROM capteur WHERE id_capteur = ?";

    $stmtMesureSuppr = mysqli_prepare($connexion, $sqlMesureSuppr); // Les statements qui vont avec la connxion
    $stmtCapteurSuppr = mysqli_prepare($connexion, $sqlCapteurSuppr);

    if ($stmtMesureSuppr === false || $stmtCapteurSuppr === false) {
        echo "Erreur dans la préparation des requêtes : " . mysqli_error($connexion); //Test si erreur de prep
        exit();
    }

    mysqli_stmt_bind_param($stmtMesureSuppr, "i", $idCapteur); //bind de parametres
    mysqli_stmt_bind_param($stmtCapteurSuppr, "i", $idCapteur);

    foreach ($_POST['capteurs'] as $idCapteur) { //execute pour chaque capteurs
        if (!mysqli_stmt_execute($stmtMesureSuppr)) {
            echo "Erreur: " . mysqli_stmt_error($stmtMesureSuppr); // execute et  renvoie les erreurs si il y en a 
        }
        if (!mysqli_stmt_execute($stmtCapteurSuppr)) {
            echo "Erreur: " . mysqli_stmt_error($stmtCapteurSuppr); // execute et  renvoie les erreurs si il y en a 
        }
        
        // mysqli_stmt_execute($stmtMesureSuppr);
        // mysqli_stmt_execute($stmtCapteurSuppr);
        
    }

    // Fermeture des statements et de la connexion à la base de données
    mysqli_stmt_close($stmtMesureSuppr);
    mysqli_stmt_close($stmtCapteurSuppr);
    mysqli_close($connexion);
}




if (isset($_POST['submit_supprimer_batt']) && isset($_POST['batiment'])) {
    if (empty($_POST['batiment'])) {
        echo "Il y a un soucis au niveau des champs renseignés";
        exit();
    }
    require('connexion_bdd.php');

    $sqlMesureSuppr = "DELETE FROM mesure WHERE id_capteur IN (SELECT id_capteur FROM capteur WHERE id_batiment = ?)";
    $sqlCapteurSuppr = "DELETE FROM capteur WHERE id_batiment = ?";
    $sqlBattimentSuppr = "DELETE FROM batiment WHERE id_batiment = ?"; //requetes préparés

    $stmtMesureSuppr = mysqli_prepare($connexion, $sqlMesureSuppr);
    $stmtCapteurSuppr = mysqli_prepare($connexion, $sqlCapteurSuppr);
    $stmtBattimentSuppr = mysqli_prepare($connexion, $sqlBattimentSuppr); //prparation des statements

    if ($stmtMesureSuppr === false || $stmtCapteurSuppr === false || $stmtBattimentSuppr === false) {
        echo "Erreur dans la préparation des requêtes : " . mysqli_error($connexion); //test d'erreur
        exit();
    }

    mysqli_stmt_bind_param($stmtMesureSuppr, "i", $id_batiment);
    mysqli_stmt_bind_param($stmtCapteurSuppr, "i", $id_batiment);
    mysqli_stmt_bind_param($stmtBattimentSuppr, "i", $id_batiment); // Liaison des paramètres des statements

    foreach ($_POST['batiment'] as $id_batiment) { //execution pour chaque batiments

        if (!mysqli_stmt_execute($stmtMesureSuppr)) {
            echo "Erreur: " . mysqli_stmt_error($stmtMesureSuppr); // execute et  renvoie les erreurs si il y en a  pour les meusures
        }
        if (!mysqli_stmt_execute($stmtCapteurSuppr)) {
            echo "Erreur: " . mysqli_stmt_error($stmtCapteurSuppr); // execute et  renvoie les erreurs si il y en a pour les capteurs
        }
        if (!mysqli_stmt_execute($stmtBattimentSuppr)) {
            echo "Erreur: " . mysqli_stmt_error($stmtBattimentSuppr); // execute et  renvoie les erreurs si il y en a pour les battimetns
        }

        // mysqli_stmt_execute($stmtMesureSuppr);
        // mysqli_stmt_execute($stmtCapteurSuppr);
        // mysqli_stmt_execute($stmtBattimentSuppr);
    }

    mysqli_stmt_close($stmtMesureSuppr);
    mysqli_stmt_close($stmtCapteurSuppr);
    mysqli_stmt_close($stmtBattimentSuppr);
    mysqli_close($connexion); //fermeture des statement et de la connexion mysql
}




header("Location: admin.php");
exit();
?>