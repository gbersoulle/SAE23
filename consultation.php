<!DOCTYPE html>
<html>
<head>
	<title>Mon site avec menu en bandeau</title>
    <link rel="stylesheet" href="styles/table.css">
    <script>
      function togglePanel(panel) {
        panel.style.maxHeight = panel.style.maxHeight ? null : panel.scrollHeight + "px";
      }
    </script>
</head>
<body>
    <?php require_once 'header.php'; require_once 'Display_one_sensor.php'; 
		?>
	
	<main>
		<!-- <h1>Afficher la derniere valeur de chaque batiment ou capteur avec la moyenne d'aujourd'hui ou jsp quoi</h1><p>(le CSS en sueur)</p> -->
		<section class="Last_Data">
			<div>
				<h1>Last Data</h1>
				<p>Affichage historique des 5 dernières données</p>
			</div>
		</section>
		<section class="Dashboard">
			<div>
				<h1>Dashboard</h1>
				<p>Ou il y aura toutes les informations des capteurs</p>
                <?php
                  $buildings = ['A', 'B', 'C', 'D', 'E'];
                  foreach ($buildings as $building) {
                    $rooms = Existing_Rooms($building);
                    // echo "<button class=\"accordion\" onclick=\"togglePanel(this.nextElementSibling)\">Batiment $building</button>";
                    // echo "<div class=\"panel\">";
                    foreach ($rooms as $room) {
                      echo "<h1>Salle $room</h1>";
					  $data_type = Search_Type($room);
					  print_r($data_type);
					  foreach ($data_type as $type) {
                      	$history[$room] = Display_Data($room, $type); //("AM107-29", "CO2");
					  }
                    }
                    echo "</div>";
                  }
                ?>
			</div>
		</section>
		<section class="autres">
			<div>
				<h1>Informations sur l'utilisateur actuellement connecté</h1>
                <p>ET si il n'y a personne de co, jsp</p>
			</div>
			<div>
				<h1>Affichage des capteurs actuellement affichés</h1>
			</div>
			<div>
				<h1>Un truc marrant</h1>
			</div>
		</section>
	</main>
</body>
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

</script> -->
</html>