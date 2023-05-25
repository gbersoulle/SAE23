<?php

// Start the session
session_start();

// Include the connexion script
require_once 'connexion_bdd.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the username and password from the form
  $user = $_POST['user'];
  $password = $_POST['password'];

  // Query the database for the user with the given username and password
  $sql = "SELECT * FROM administration WHERE user = '$user' AND password = '$password'";
  $result = mysqli_query($connexion, $sql);

  // Check if a user was found
  if (mysqli_num_rows($result) == 1) {
    // Set the session variable to indicate that the user is logged in
    $_SESSION['loggedin'] = true;
    $_SESSION['user'] = $user;


    // Redirect the user to the home page
    header('Location: index.php');
    exit;
  } else {
    // Display an error message
    echo 'Invalid username or password';
  }
}
?>