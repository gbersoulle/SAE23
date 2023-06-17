<?php
echo 'Back to previous page <a href="admin.php">Go back</a><br>';
echo "Access to modification file <br/>";

// Add sensor
if (isset($_POST['submit_ajouter_capteur'])) {
    echo "Adding sensor in progress <br/>";
    if (empty($_POST['type_capteur']) || empty($_POST['bat_attribue']) || empty($_POST['salle_capteur'])) {
        echo "Missing element in the entered fields";
        exit;
    }
    require('connexion_bdd.php');
    
    // Get and escape values
    $typeCapteur = mysqli_real_escape_string($connexion, htmlspecialchars($_POST['type_capteur'], ENT_QUOTES, 'UTF-8'));
    $Salle = mysqli_real_escape_string($connexion, htmlspecialchars($_POST['salle_capteur'], ENT_QUOTES, 'UTF-8'));
    $idBatiment = intval($_POST['bat_attribue']);
    $nomCapteur = $Salle . $typeCapteur;
    
    // SQL query to insert a new sensor
    $sql = "INSERT INTO capteur (nom_capteur, type_capteur, Salle, id_batiment) VALUES (?, ?, ?, ?)";
    
    // Prepare the insert statement
    $stmt = mysqli_prepare($connexion, $sql);

    // Check if the query preparation was successful
    if ($stmt === false) {
        echo "Error in query preparation: " . mysqli_error($connexion);
        exit;
    }
    
    // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "sssi", $nomCapteur, $typeCapteur, $Salle, $idBatiment);
    
    // Execute the insert statement
    if (!mysqli_stmt_execute($stmt)) {
        echo "Error: " . mysqli_stmt_error($stmt);
    }
    
    // Close the prepared statement and the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($connexion);
}



// Add building
if (isset($_POST['submit_ajouter_battiment'])) {
    if (empty($_POST['login_gest']) || empty($_POST['mdp_gest']) || empty($_POST['nom_bat'])) {
        echo "There is an issue with the entered fields";
        exit;
    }
    require('connexion_bdd.php');
    
    // Get and escape values to avoid JS and SQL injection
    $nom_bat = mysqli_real_escape_string($connexion, htmlspecialchars($_POST['nom_bat'], ENT_QUOTES, 'UTF-8'));
    $login_gest = mysqli_real_escape_string($connexion, htmlspecialchars($_POST['login_gest'], ENT_QUOTES, 'UTF-8'));
    $mdp_gest = hash('sha256', $_POST['mdp_gest']);
    
    // SQL query to insert a new building
    $sql = "INSERT INTO batiment (nom_bat, login_gest, mdp_gest) VALUES (?, ?, ?)";
    
    // Prepare the insert statement
    $stmt = mysqli_prepare($connexion, $sql);
    
    // Check if the query preparation was successful
    if ($stmt === false) {
        echo "Error in query preparation: " . mysqli_error($connexion);
        exit;
    }
    
    // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "sss", $nom_bat, $login_gest, $mdp_gest);
    
    // Execute the insert statement
    if (!mysqli_stmt_execute($stmt)) {
        echo "Error: " . mysqli_stmt_error($stmt);
    }
    
    // Close the prepared statement and the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($connexion);
}

// Remove sensor
if (isset($_POST['submit_supprimer_capteur']) && isset($_POST['capteurs'])) {
    if (empty($_POST['capteurs'])) {
        echo "There is an issue with the entered fields (sensors)";
        exit();
    }
    require('connexion_bdd.php');

    // SQL query to delete measurements associated with the sensor
    $sqlMesureSuppr = "DELETE FROM mesure WHERE nom_capteur IN (SELECT nom_capteur FROM capteur WHERE id_capteur = ?)";

    // SQL query to delete the sensor
    $sqlCapteurSuppr = "DELETE FROM capteur WHERE id_capteur = ?";

    // Prepare the delete statements
    $stmtMesureSuppr = mysqli_prepare($connexion, $sqlMesureSuppr);
    $stmtCapteurSuppr = mysqli_prepare($connexion, $sqlCapteurSuppr);

    // Check if the query preparation was successful
    if ($stmtMesureSuppr === false || $stmtCapteurSuppr === false) {
        echo "Error in query preparation: " . mysqli_error($connexion);
        exit();
    }

    // Bind the parameter for the sensor ID to the prepared statements
    mysqli_stmt_bind_param($stmtMesureSuppr, "i", $idCapteur);
    mysqli_stmt_bind_param($stmtCapteurSuppr, "i", $idCapteur);

    // Iterate over the selected sensors and execute the delete statements
    foreach ($_POST['capteurs'] as $idCapteur) {
        if (!mysqli_stmt_execute($stmtMesureSuppr)) {
            echo "Error: " . mysqli_stmt_error($stmtMesureSuppr);
        }
        if (!mysqli_stmt_execute($stmtCapteurSuppr)) {
            echo "Error: " . mysqli_stmt_error($stmtCapteurSuppr);
        }
    }

    // Close the prepared statements
    mysqli_stmt_close($stmtMesureSuppr);
    mysqli_stmt_close($stmtCapteurSuppr);
    mysqli_close($connexion);
}


// Remove building
if (isset($_POST['submit_supprimer_batt'])) {
    // Check if the 'batiment' field is empty
    if (empty($_POST['batiment'])) {
        echo "There is an issue with the entered fields";
        exit();
    }
    require('connexion_bdd.php');

    // SQL statements to delete related records delete 'meusure' before the sensors and the buildings
    $sqlMesureSuppr = "DELETE FROM mesure WHERE nom_capteur IN (SELECT nom_capteur FROM capteur WHERE id_batiment = ?);";
    $sqlCapteurSuppr = "DELETE FROM capteur WHERE id_batiment = ?";
    $sqlBatimentSuppr = "DELETE FROM batiment WHERE id_batiment = ?";

    // Prepare the SQL statements
    $stmtMesureSuppr = mysqli_prepare($connexion, $sqlMesureSuppr);
    $stmtCapteurSuppr = mysqli_prepare($connexion, $sqlCapteurSuppr);
    $stmtBatimentSuppr = mysqli_prepare($connexion, $sqlBatimentSuppr);

    // Loop through each selected building to delete
    foreach ($_POST['batiment'] as $id_batiment) {
        // Bind the building ID parameter to the statements
        mysqli_stmt_bind_param($stmtMesureSuppr, "i", $id_batiment);
        mysqli_stmt_bind_param($stmtCapteurSuppr, "i", $id_batiment);
        mysqli_stmt_bind_param($stmtBatimentSuppr, "i", $id_batiment);

        // Execute the deletion queries for each statement
        if (!mysqli_stmt_execute($stmtMesureSuppr)) {
            echo "Erreur : " . mysqli_stmt_error($stmtMesureSuppr);
        }
        if (!mysqli_stmt_execute($stmtCapteurSuppr)) {
            echo "Erreur : " . mysqli_stmt_error($stmtCapteurSuppr);
        }
        if (!mysqli_stmt_execute($stmtBatimentSuppr)) {
            echo "Erreur : " . mysqli_stmt_error($stmtBatimentSuppr);
        }
    }

    // Close the statements and database connexion
    mysqli_stmt_close($stmtMesureSuppr);
    mysqli_stmt_close($stmtCapteurSuppr);
    mysqli_stmt_close($stmtBatimentSuppr);
    mysqli_close($connexion);
}


// Change manager
if (isset($_POST['submit_change_gestionnaire'])) {
    $id_batiment = $_POST['id_bat'];
    echo $id_batiment;
    require 'connexion_bdd.php';

    // Retrieve the previous username and password of the building manager
    $sql_Login_Gest = "SELECT login_gest, mdp_gest FROM batiment WHERE id_batiment = $id_batiment";
    $LoginMdpGestionnaire = mysqli_query($connexion, $sql_Login_Gest);

    if (!$LoginMdpGestionnaire) {
        die("Error in retrieving previous username and password: " . mysqli_error($connexion));
    }

    $ligne = mysqli_fetch_assoc($LoginMdpGestionnaire);
    $ancienUser = $ligne['login_gest'];
    $ancienMdp = $ligne['mdp_gest'];
    $nvUser = $ancienUser;
    $nvMdp = $ancienMdp; // Set the default values to previous username and password

    // Check if new values were provided in the form; if not, keep the previous values
    if (!empty($_POST['change_login_gest'])) {
        $nvUser = mysqli_real_escape_string($connexion, htmlspecialchars($_POST['change_login_gest'], ENT_QUOTES, 'UTF-8'));
    }
    if (!empty($_POST['change_mdp_gest'])) {
        $nvMdp = hash('sha256', mysqli_real_escape_string($connexion, htmlspecialchars($_POST['change_mdp_gest'], ENT_QUOTES, 'UTF-8')));
    }
  
    // Update the manager's username and password in the database
    $sql_update_gest = "UPDATE batiment SET login_gest = ?, mdp_gest = ? WHERE id_batiment = ?";
    $stmt_update_gest = mysqli_prepare($connexion, $sql_update_gest);
    if ($stmt_update_gest === false) {
        echo "Error in query preparation: " . mysqli_error($connexion);
        exit();
    }
    mysqli_stmt_bind_param($stmt_update_gest, "ssi", $nvUser, $nvMdp, $id_batiment);
    if (!mysqli_stmt_execute($stmt_update_gest)) {
        echo "Error: " . mysqli_stmt_error($stmt_update_gest);
    } else {
        echo "Modified";
    }
}


    mysqli_close($connexion);
    // echo "ancien password". $ancienMdp;
    // echo "ancien username". $ancienUser;
    // echo "nv password". $nvMdp;
    // echo "nv username". $nvUser;

header("Location: admin.php");
exit();
?>
