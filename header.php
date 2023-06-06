<!-- Menu en bandeau -->
<nav>
	<ul>
		<li><a href="index.php">Accueil</a></li>
		<li><a href="affiche_base.php">Affichage de la BDD</a></li> <!-- ///////////////à enlever à la fin//////////////// -->
		<li><a href="consultation.php">Consultation</a></li>
		<?php
		session_start();
		// Check if the user is logged in
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
			// Check the user source
			if (isset($_SESSION['source']) && $_SESSION['source'] == 'administration') {
				// User is from administration table, show link to admin.php
				echo '<li class="allign_right"><a href="admin.php">Administration</a></li>';
			} elseif (isset($_SESSION['source']) && $_SESSION['source'] == 'batiment') {
				// User is from batiment table, show link to gestion.php
				echo '<li class="allign_right"><a href="gestion.php">Gestion</a></li>';
			}

			// Show user dropdown menu
			echo '
			<li class="dropdown" >
			  <a href="#" class="dropbtn">' . $_SESSION['user'] . '</a>
			  <ul class="dropdown-content">
				<li><a href="logout.php">Déconnexion</a></li>
			  </ul>
			</li>';
		} else {
			echo '<li class="allign_right"><a href="sign-in.php">Se connecter</a></li>';
		}
		?>
	</ul>
</nav>
<script src="./scripts/rolldown.js"></script>

