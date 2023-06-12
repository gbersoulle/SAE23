<?php
    // Check if a session is started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the user is logged in
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        // Check the user's source
        if (isset($_SESSION['source']) && $_SESSION['source'] != 'administration') {
            $error = "ERROR: You do not have the necessary credentials to access this page";
            echo '<a href="index.php">Home</a><br>' ;
            die($error);
        }
    } 
    else {
        $message = "You are not logged in";
        echo '<a href="index.php">Home</a><br>' ;
        die($message);
    }
?>
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
    <?php require('header.php');?><!-- Add or remove a sensor -->

    <!-- Add or remove a building -->
    <fieldset class="add_b">
        <legend>Add a building</legend>
    <form method="POST" action="script_admin.php">
        <label for="nom_bat">Enter the name of the building</label>
        <input type="text" id="nom_bat" name="nom_bat" placeholder="Ex: A, B, C..." required><br><br>
        
        <label for="login_gest">Enter the name of the manager</label>
        <input type="text" id="login_gest" name="login_gest" placeholder="Ex: Xx_DarKikou_xX" required><br><br>

        <label for="mdp_gest">Enter the manager's password</label>
        <input type="password" id="mdp_gest" name="mdp_gest" placeholder="Ex: LaBr3tagne" required><br><br>

        <input class="bu" type="submit" name="submit_ajouter_battiment" value="Add a Building">
    </form>
    </fieldset>

<!-- Display all buildings -->
<fieldset class="del_b">
    <legend>Delete a building</legend>
    <p>WARNING: DELETING A BUILDING WILL DELETE ALL ASSOCIATED SENSORS AND MEASUREMENTS</p>

    <form method="POST" action="script_admin.php">
        <table>
            <tr>
                <th>Building Name</th>
                <th>Number of Associated Sensors</th>
                <th>Manager</th>
                <th>Delete</th>
            </tr>
            <?php
            require('connexion_bdd.php');
            $sql = "SELECT batt.nom_bat AS nom_batiment, batt.login_gest, COUNT(capteur.id_capteur) AS nombre_capteurs, batt.id_batiment
                    FROM batiment batt 
                    LEFT JOIN capteur capteur ON batt.id_batiment = capteur.id_batiment 
                    GROUP BY batt.id_batiment"; // Left join --> Retrieves buildings even those that have no match in the capteur table
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
        </table><br>
        <input class="bu" type="submit" name="submit_supprimer_batt" value="Delete selected buildings">
    </form>
</fieldset>

<fieldset class="add_c">
    <legend>Add a sensor</legend>
    <form method="POST" action="script_admin.php">
        <label for="type_capteur">Choose the type of sensor</label>
        <select id="type_capteur" name="type_capteur" required>
        <option value="" disabled selected hidden>Select an option</option>
            <option value="temperature">Temperature</option>
            <option value="humidity">Humidity</option>
            <option value="activity">Activity</option>
            <option value="co2">CO2</option>
            <option value="tvoc">TVOC</option>
            <option value="illumination">Illumination</option>
            <option value="infrared">Infrared</option>
            <option value="infrared_and_visible">Infrared and Visible</option>
            <option value="pressure">Pressure</option>
        </select><br><br>


        <label for="bat_attribue">Choose the building assigned to the sensor</label>
        <select id="bat_attribue" name="bat_attribue" required>
        <option value="" disabled selected hidden>Select an option</option>
        <?php
            require('connexion_bdd.php');
            $requeteBattiment = mysqli_query($connexion, "SELECT nom_bat, id_batiment FROM batiment");
            if (!$requeteBattiment) {
                die("Query issue" . mysqli_error($connexion));
            }
            while ($ligne = mysqli_fetch_assoc($requeteBattiment)) {
                $nomBatiment = $ligne['nom_bat'];
                $idBatiment = $ligne['id_batiment'];
                
                // Add the option to the select
                echo '<option value="' . $idBatiment . '">' . $nomBatiment . '</option>';
            }
            mysqli_close($connexion);

        ?>
        </select><br><br>
        <label for="salle_capteur">Enter the room of the sensor</label>
        <input type="text" id="salle_capteur" name="salle_capteur" placeholder="Ex: B206" required><br><br>
        <input type="submit" name="submit_ajouter_capteur" value="Validate">
    </form>
</fieldset>

<fieldset class="del_c">
    <legend>Delete a sensor</legend>
        <p>WARNING: DELETING A SENSOR WILL DELETE ALL ASSOCIATED VALUES</p>

<!-- Display a table containing all sensors -->
<form method="POST" action="script_admin.php">
  <table>
    <tr>
      <th>Sensor Name</th>
      <th>Sensor Type</th>
      <th>Assigned Building</th>
      <th>Assigned Room</th>
      <th>Measurement Count</th>
      <th>Delete</th>
    </tr>
    <?php
    require('connexion_bdd.php');
    $sql = "SELECT capteur.*, batt.nom_bat, COUNT(mesure.id_mesure) AS measurement_count
            FROM capteur
            INNER JOIN batiment batt ON capteur.id_batiment = batt.id_batiment -- This join allows obtaining information about the building assigned to each sensor.
            LEFT JOIN mesure ON capteur.nom_capteur = mesure.nom_capteur -- This join allows counting the number of measurements associated with each sensor, even if this count is zero.
            GROUP BY capteur.id_capteur";
    $ToutLesCapteurs = mysqli_query($connexion, $sql);
    mysqli_close($connexion);
    while ($ligne = mysqli_fetch_assoc($ToutLesCapteurs)) {
        $idCapteur = $ligne['id_capteur'];
        $nomCapteur = $ligne['nom_capteur'];
        $typeCapteur = $ligne['type_capteur'];
        $nomBatiment = $ligne['nom_bat'];
        $Salle = $ligne['Salle'];
        $measurementCount = $ligne['measurement_count'];

        echo "<tr>";
        echo "<td>" . $nomCapteur . "</td>";
        echo "<td>" . $typeCapteur . "</td>";
        echo "<td>" . $nomBatiment . "</td>";
        echo "<td>" . $Salle . "</td>";
        echo "<td>" . $measurementCount . "</td>";
        echo "<td><input type='checkbox' name='capteurs[]' value='" . $idCapteur . "'></td>";
        echo "</tr>";
    }
    ?>
  </table><br>
  <input type="submit" name="submit_supprimer_capteur" value="Delete selected sensors">
</form>
</fieldset>


<fieldset class="updt_g">
    <legend>Modify a manager</legend>
    <form method="POST" action="script_admin.php">
    <label for="id_bat">Name of the manager to modify</label>
        <select id="id_bat" name="id_bat" required>
        <option value="" disabled selected hidden>Select an option</option>

        <?php
        require('connexion_bdd.php');
        $sqlgestionnaire = mysqli_query($connexion, "SELECT login_gest, id_batiment FROM batiment");
        if (!$sqlgestionnaire) {
            die("Query issue" . mysqli_error($connexion));
        }
        while ($ligne = mysqli_fetch_assoc($sqlgestionnaire)) {
            $login_gest = $ligne['login_gest'];
            $idBatiment = $ligne['id_batiment'];
            
            // Adding the option to the select
            echo '<option value="' . $idBatiment . '">' . $login_gest . '</option>';
        }
        mysqli_close($connexion);

    ?>
    </select>
    <label for="change_login_gest">Fill in to change the manager's name</label>
    <input type="text" id="change_login_gest" name="change_login_gest" placeholder="If empty, no change"> 
    <label for="change_mdp_gest">Fill in to change the manager's password</label>
    <input type="password" id="change_mdp_gest" name="change_mdp_gest" placeholder="If empty, no change"> 
    <input type="submit" name="submit_change_gestionnaire" value="Modify">
</form>
</fieldset>


    
</body>
</html>


