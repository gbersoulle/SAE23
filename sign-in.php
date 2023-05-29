<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="./Ange/style/style.css" rel="Stylesheet" type="text/css" /> 
    <script src="./scripts/script.js"></script>
    <link rel="stylesheet" href="styles/Sign-in.css">
    <title>Se Connecter</title>
</head>
    </nav>
    <?php require_once 'header.php' ?>
    <div class="form-title">
        <h2>Vous êtes de retour !!!</h2>
        <p>Veuillez vous connecter</p>
    </div>
    <form class="register" action="sign-in_check.php" method="post">
        <label for="user">Utilisateur :</label>
        <input type="user" id="user" name="user" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <input class="Round_button" type="submit" value="Se connecter">
    </form>
</html>