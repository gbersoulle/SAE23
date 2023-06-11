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
					// Call a function to display data for "all" buildings, display "1" measurment
                    display_all_buildings("all", 1, '', '', '', '', '', '');
					require_once 'affiche_metriques.php'; //diplay avg, min, max
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
        activity: 5,
        tvoc: 500,
        illumination: 1000,
        infrared: 100,
        infrared_and_visible: 100,
        pressure: 2000
    };
    
    for (var i = 0; i < gaugeElements.length; i++) {
        var gaugeElement = gaugeElements[i];
        var value = parseInt(gaugeElement.getAttribute("data-value"));
        var dataType = gaugeElement.getAttribute("datatype");

        var g = new JustGage({
          id: gaugeElement.id,
          value: value,
          min: 0,
          max: ValueMax[dataType],
          title: "Dernière donnée"
        });
  }
</script>

</script>



</html>
