<!-- Menu en bandeau -->
<nav>
	<ul>
		<li><a href="index.php">Accueil</a></li>
		<li><a href="affiche_base.php">Affichage de la BDD</a></li>
		<li><a href="#">Piere C'est un BG</a></li>
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
	</ul>
</nav>
<script src="./scripts/rolldown.js"></script>
