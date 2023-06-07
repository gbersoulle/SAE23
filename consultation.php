<!DOCTYPE html>
<html>
<head>
	<title>Mon site avec menu en bandeau</title>
    <link rel="stylesheet" href="styles/table.css">
</head>
<body>
    <?php require_once 'header.php'?>
	
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
            require_once 'functions.php';
            $buildings = ['A', 'B', 'C', 'D', 'E'];
            $history = display_all_buildings($buildings);
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
<script src='./scripts/unroll.js'></script>
<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
<script src='./scripts/unroll.js'></script>
<script src='./scripts/Make_Chart.js'></script>

<script>
  // Function to create a new chart (graph)

var historyData = <?php echo json_encode($history); ?>;

for (var sensor in historyData) {
  if (historyData[sensor] != null && historyData[sensor].length > 0) {
    createChart(sensor, historyData, 'red');
  }
}
</script>

</html>