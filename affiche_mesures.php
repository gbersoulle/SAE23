<?php
    require_once 'header.php';
    require_once 'functions.php';

    // Require the script used to connect to the DB
    require_once('connexion_bdd.php');
    echo "<h1>Métriques par Salles</h1>";
    echo "
    <table>
        <tr>
            <th>Salle</th>
            <th>Type de Donnée</th>
            <th>Moyenne</th>
            <th>Minimum</th>
            <th>Maximum</th>
        </tr>";
      $moyenne_h[] = Display_moyenne("B203","AM107-6","Humidité");
      $moyenne_h[] = Display_moyenne("E102","AM107-32","Humidité");
      $moyenne_c[] = Display_moyenne("B001","AM107-7","CO2");
      $moyenne_c[] = Display_moyenne("E006","AM107-29","CO2");
    echo "</table>";

    echo "<h1>Métriques par Type de données</h1>";
    echo "
    <table>
        <tr>
            <th>Type de Donnée</th>
            <th>Moyenne</th>
            <th>Minimum</th>
            <th>Maximum</th>
        </tr>";
      $mptd[] = Metrique_type($moyenne_h, "Humidité");
      $mptd[] = Metrique_type($moyenne_c, "CO2");
    echo "</table>";


    // Close the database connection
    mysqli_close($connexion);
?>


</body>
</html>