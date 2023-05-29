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
    echo '<canvas id="Chart_E102"></canvas>';

    echo "<h1>Salle B001</h1>";
    $history_B001[] = Display_one("24e124128c012259", "CO2");
    echo '<canvas id="Chart_B001"></canvas>';

    echo "<h1>Salle E006</h1>";
    $history_E006[] = Display_one("24e124128c016509", "CO2");
    echo '<canvas id="Chart_E006"></canvas>';

    // Close the database connection
    mysqli_close($connexion);
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Retrieve the PHP array data
var history_B203 = <?php echo json_encode($history_B203); ?>;
var history_E102 = <?php echo json_encode($history_E102); ?>;
var history_B001 = <?php echo json_encode($history_B001); ?>;
var history_E006 = <?php echo json_encode($history_E006); ?>;

// Function to create a new chart (graph)
function createChart(elementId, label, data, color) {
  // Get the canvas element by ID
  var canvas = document.getElementById(elementId);
  
  // reverse the array to have data classified in the right order
  var data = data[0].reverse();
  
  // specify each caracteristic of our chart for chart.js to make
  var chart = new Chart(canvas, {
    type: 'line',
    data: {
      // Labels are the name of each point of the graph
      labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
      datasets: [
        {
          label: label,
          // Specify which data to use for the graph for example "history_B203"
          data: data,
          borderColor: color,
          borderWidth: 2
        }
      ]
    }
  });
}

// Call the function to create charts for each room
createChart('Chart_B203', 'Humidité B203', history_B203, 'red');
createChart('Chart_E102', 'Humidité E102', history_E102, 'blue');
createChart('Chart_B001', 'CO2 B001', history_B001, 'green');
createChart('Chart_E006', 'CO2 E006', history_E006, 'purple');

</script>

</body>
</html>