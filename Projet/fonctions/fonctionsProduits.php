<?php

	function afficherProduits(){

		
		echo "<a href='ajouterProd.php'>Ajouter un produit</a><br/>";
		//echo "<a href='ajouterProd.php'>Ajouter une rubrique</a><br/>";
		echo "<hr>";
		echo "<h2>Produits</h2><br/>";
        $mysqli = connect();
        $Albums = getAllAlbums($mysqli);
        disconnect($mysqli);
		if(count($Albums)<=0){
			echo "Aucun enregistrement dans la base de données";
		}
		else{
			echo "<table>";
					echo "<tr><td width='50px'>ID</td><td width='80px'>Titre</td><td width='80px'>Prix</td></tr>"; 
					echo "<tr><td colspan='3'><hr></td></tr>";
					foreach($Albums as $index => $item){
						echo "<tr>";
						echo "<td id='item'><a href='detail.php?id=".$index."'>".$item["ID_PROD"]."</a></td><td> ".$item["LIBELLE"]."</td><td> </td>";
						echo "<td><button id='effacer' onclick='removeItem(".$item["ID_PROD"].")'>effacer</button></td>";
						echo "</tr>";
						echo "<tr><td colspan='3'><hr></td></tr>";
					}
			echo "</table>";
		}
	}
	
?>