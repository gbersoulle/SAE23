<?php 
    require_once 'header.php';
    require_once 'Display_one_sensor.php'; 
    // Require the script used to connect to the DB
    require_once('connexion_bdd.php');

    // display the last 10 measurements for the room B203
    echo "<h1>Salle B203</h1>";
    // Call the function to display data for a specific sensor, and store the history of values he returns
    $history_B203[] = Display_one("AM107-6", "Humidité");
    echo '<canvas id="Chart_B203"></canvas>';

    echo "<h1>Salle E102</h1>";
    $history_E102[] = Display_one("AM107-32", "Humidité");
    echo '<canvas id="Chart_E102"></canvas>';

    echo "<h1>Salle B001</h1>";
    $history_B001[] = Display_one("AM107-7", "CO2");
    echo '<canvas id="Chart_B001"></canvas>';

    echo "<h1>Salle E006</h1>";
    $history_E006[] = Display_one("AM107-29", "CO2");
    echo '<canvas id="Chart_E006"></canvas>';

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
          pointRadius: 10,
          pointHoverRadius: 15,
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