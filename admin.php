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
            <p>ATTENTION SUPPRIMER UN BATIMENT SUPPRIMERA TOUT LES valeurs associées</p>
    </fieldset>
    <!-- Afficher un tableau qui contiens tout les capteurs -->
    
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
    <fieldset>
        <legend>Supprimer un battiment</legend>
            <p>ATTENTION SUPPRIMER UN BATIMENT SUPPRIMERA TOUT LES CAPTEURS</p>
    </fieldset>
    <!-- Afficher tout les capteurs -->




    <?php
if(isset($_POST['submit_ajouter_capteur'])){ajouter_capteur();} //teste si le formulaire submit_ajouter_capteur as été POSTé, et si oui rajout les valeurs dans la BDD
function ajouter_capteur(){
    require('connexion_bdd.php');
    $nomCapteur = $_POST['nom_capteur'];
    $typeCapteur = $_POST['type_capteur'];
    $idBatiment = $_POST['nom_bat'];
    $sql = "INSERT INTO capteur (nom_capteur, type_capteur, id_batiment) VALUES ('$nomCapteur', '$typeCapteur', $idBatiment)";

    //supprimer les valeurs pour éviter les doublons quand on rafraichit la page
    unset($_POST['nom_capteur']);
    unset($_POST['type_capteur']);
    unset($_POST['nom_bat']);
    
    mysqli_close($connexion);
    header("Location: ".$_SERVER['PHP_SELF']); //On redirige vers la même page pour réinitialiser le formulaire

    
}
if(isset($_POST['submit_ajouter_battiment'])){ajouter_battiment();} //teste si le formulaire submit_ajouter_battiment as été POSTé, et si oui rajout les valeurs dans la BDD
function ajouter_battiment(){
    require('connexion_bdd.php');
    $nom_bat = $_POST['nom_bat'];
    $login_gest = $_POST['login_gest'];
    $mdp_gest = $_POST['mdp_gest'];
    $sql = "INSERT INTO batiment (nom_bat, login_gest, mdp_gest) VALUES ('$nom_bat', '$login_gest', '$mdp_gest')";
   

    //supprimer les valeurs pour éviter les doublons quand on rafraichit la page
    unset($_POST['nom_bat']);
    unset($_POST['login_gest']);
    unset($_POST['mdp_gest']);
    
    mysqli_close($connexion);
    header("Location: ".$_SERVER['PHP_SELF']); //On redirige vers la même page pour réinitialiser le formulaire

}

?>
</body>
</html>


