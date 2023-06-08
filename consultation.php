<!DOCTYPE html>
<html>
<head>
    <title>Mon site avec menu en bandeau</title>
    <link rel="stylesheet" href="styles/table.css">
</head>
<body>
    <?php require_once 'header.php'?>
    
    <main>
        <section class="Dashboard">
            <div>
                <h1>Dashboard</h1>
                <p>Cliquez sur un bâtiment pour voir ses valeurs</p>
                <?php
					// Include the 'functions.php' which contains necessary functions for the code below
					require_once 'functions.php';
					// Create an array of buildings with identifiers 'A', 'B', 'C', 'D', and 'E'
					$buildings = ['A', 'B', 'C', 'D', 'E'];
					// Call a function to display data for all buildings, store the last 10 measurments of each room in history (graph)
					$history = display_all_buildings($buildings);
					require_once 'affiche_metriques.php'; //diplay avg, min, max

                ?>
            </div>
        </section>
    </main>
</body>
<script src='./scripts/unroll.js'></script>
<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
<script src='./scripts/unroll.js'></script>
<script src='./scripts/Make_Chart.js'></script>

<script>
    // Get the historical data from PHP and store it in the historyData variable
    var historyData = <?php echo json_encode($history); ?>;

    // Iterate over each sensor in the historyData object
    for (var sensor in historyData) {
        // Check if the sensor has data
        if (historyData[sensor] != null && historyData[sensor].length > 0) {
            // Call the createChart function to create a chart for the sensor using the historical data
            createChart(sensor, historyData, 'red');
        }
    }
</script>

</html>
