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
					echo '<li><a href="admin.php">Administration</a></li>';
					echo '<li><a href="#">Vous Etes connectés</a></li>';
					echo "<li><a href='#'>{$_SESSION['user']}</a></li>";
				}
				else {
					echo '<li class="left"><a href="sign-in.php">Se connecter</a></li>';
				} 
			?>
		</ul>
</nav>