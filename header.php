<!-- Menu en bandeau -->
<nav>
	<ul>
		<li><a href="index.php">Accueil</a></li>
		<li><a href="affiche_base.php">Affichage de la BDD</a></li> <!-- ///////////////à enlever à la fin//////////////// -->
		<li><a href="consultation.php">Consultation</a></li>
		<li><a href="gestion.php">Gestion (temporaire)</a></li>
		<?php
		session_start();
		// Check if the user is logged in
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
			// Other menu items
			echo '<li class="allign_right"><a href="admin.php">Administration</a></li>';
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
		<!-- differentier quelqu'un qui s'es log en tant qu'admin ou en tant que gestionnaire et si gestionnaire donner acces à admin.php si admin, donner acce a gestion.php -->
	</ul>
</nav>
<script src="./scripts/rolldown.js"></script>
