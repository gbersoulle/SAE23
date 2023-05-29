<?php 
    require_once 'header.php';
    require_once 'Display_one_sensor.php'; 
    // Require the script used to connect to the DB
    require_once('connexion_bdd.php');
    
    // display the last 10 measurements for the room B203
    echo "<h1>Salle B203</h1>";
    // Call the function to display data for a specific sensor, and store the history of values he returns
    $history_B203[] = Display_one("24e124128c011778", "Humidité");
    echo '<canvas id="Chart_B203"></canvas>';
    
    echo "<h1>Salle E102</h1>";
    $history_E102[] = Display_one("24e124128c016122", "Humidité");
    
    echo "<h1>Salle B001</h1>";
    $history_B001[] = Display_one("24e124128c012259", "CO2");

    echo "<h1>Salle E006</h1>";
    $history_E006[] = Display_one("24e124128c016509", "CO2");
    
    // Close the database connection
    mysqli_close($connexion);
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Retrieve the PHP array data
  var history_B203 = <?php echo json_encode($history_B203); ?>;

  // Create a new chart instance
  var B203 = document.getElementById('Chart_B203');
  var chart = new Chart(B203, {
    type: 'line',
    data: {

    //labels are the name of each point of the graph
      labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], 
      datasets: [{

        label: 'Humidité',
        // specify which data it has to make the graph with
        data: history_B203[0],
        borderColor: 'rgba(0, 123, 1 , 1)', 
        borderWidth: 2
      }]
    }
  });
</script>

</body>
</html>