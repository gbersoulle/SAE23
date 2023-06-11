<!DOCTYPE html>
<html>
<head>
    <title>Consultation</title>
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
					// Call a function to display data for "all" buildings, display "1" measurment
                    display_all_buildings("all", 1, '', '', '', '', '', '');

                    //display metrics (avg, min, max)
                    echo "<h1>Métriques par Salles</h1>";
                    echo "
                    <table class = 'metriques'>
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
                    <table class = 'metriques'>
                        <tr>
                            <th>Type de Donnée</th>
                            <th>Moyenne</th>
                            <th>Minimum</th>
                            <th>Maximum</th>
                        </tr>";
                      $mptd[] = Metrique_type($moyenne_h, "Humidité");
                      $mptd[] = Metrique_type($moyenne_c, "CO2");
                    echo "</table>";
                    ?>
            </div>
        </section>
    </main>
</body>
<script src='./scripts/unroll.js'></script>

<!-- import required scripts for gauges -->
<script src="https://cdn.jsdelivr.net/gh/toorshia/justgage/raphael-2.1.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/toorshia/justgage/justgage.js"></script>
<!-- make a gauge for each div having for class gauge -->
<script>
    var gaugeElements = document.getElementsByClassName("gauge");
    var ValueMax = {
        co2: 800,
        temperature: 50,
        humidity: 100,
        activity: 1000,
        tvoc: 500,
        illumination: 1000,
        infrared: 100,
        infrared_and_visible: 100,
        pressure: 2000
    };

    for (var i = 0; i < gaugeElements.length; i++) {
        var gaugeElement = gaugeElements[i];
        var value = gaugeElement.getAttribute("data-value");
        var dataType = gaugeElement.getAttribute("datatype");
        var decimal = 0;
        
        // If the value has a decimal part, set decimal to 1 so it displays the decimal part
        if (value % 1 !== 0) {
            decimal = 1;
        }

        var g = new JustGage({
        id: gaugeElement.id,
        value: value,
        min: 0,
        max: ValueMax[dataType],
        title: "Dernière donnée",
        decimals: decimal
    });
    }

</script>


</html>
