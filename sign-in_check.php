<?php
// Start the session
session_start();

// Include the connexion script
require_once 'connexion_bdd.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the username and password from the form
  $user = $_POST['user'];
  $password = hash('sha256',$_POST['password']);
  $pat=hash('sha256','Patoche');
  echo "$pat";

  // Query the database for the user with the given username and password
  $sql = "(SELECT 'administration' AS source, user, password FROM administration WHERE user = '$user' AND password = '$password')
          UNION
          (SELECT 'batiment' AS source, login_gest AS user, mdp_gest AS password FROM batiment WHERE login_gest = '$user' AND mdp_gest = '$password')";
  $result = mysqli_query($connexion, $sql);

  // Check if a user was found
  if (mysqli_num_rows($result) == 1) {
    // Fetch the user information from the result
    $row = mysqli_fetch_assoc($result);
    $source = $row['source']; //correspond à la table source (l'utilisateur est dans la table administration ou dans la table batiment (gesitonnaire donc))
    $user = $row['user'];

    // Set the session variable to indicate that the user is logged in
    $_SESSION['loggedin'] = true;
    $_SESSION['user'] = $user;
    $_SESSION['source'] = $source;

    // Redirect the user to the home page
    header('Location: index.php');
    exit;
  } else {
    // Display an error message
    echo "<a href='sign-in.php'>Retour</a>";
    echo 'Invalid username or password';
  }
}
?>
