<?php
	require_once("structure.php");
	debutHTML();
	$p = connexion();
?>
	<div id="head">
		<h1 id="title">
			MAGASIN DRIVE
		</h1>
		<p>
			Bienvenue sur "Magasin Drive", le magasin en ligne qui vous vend des produits diverses par Drive !
		</p>
	</div>

	<div id="user">
		<div id="connection">
			<p>
				<input type="text" value="Identifiant"></input>
				<input type="password"></input>
				<input type="button" value="Connection"></input></br>
				<a>Pas encore inscrit ?</a>
			</p>
		</div>
		<div id="basket">
			<img src="images/panier.png"></img>
			<p>Contenu de votre panier :</p>
		</div>
	</div>

	<div id="items">
		<?php
			$reponse = $p -> query("SELECT nom, prix from produit;");
			$donnees = $reponse->fetchAll();
			foreach($donnees as $row){
				echo '<div class="item"><p>'.$row["nom"].'</br>'.$row["prix"].'&#8364</p><img src="images/'.$row["nom"].'.jpg"/></div>';			
			}	
		?>
	</div>

	
<?php	
	finHTML();
?>	