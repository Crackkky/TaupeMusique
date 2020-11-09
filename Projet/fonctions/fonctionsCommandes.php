<?php
	function afficherCommandes(){
		include("Fonctions.inc.php");
		include("Donnees.inc.php");

		$mysqli = connect();
		
		echo "<h2>Commandes</h2><br/>";
		$result = queryDB($mysqli,'select id_com,id_client,(select prenom from USERS where USERS.login = COMMANDE.id_client limit 1) as prenom,(select nom from USERS where USERS.login = COMMANDE.id_client limit 1) as nom,id_prod,date,ADRESSE,cp,ville from COMMANDE');
		if(mysqli_num_rows($result)<=0){
			echo "Aucun enregistrement dans la base de données";
		}
		else{
			echo "<table>";
					echo "<tr><td width='50px'>ID</td><td width='80px'>Date</td><td width='80px'>Produit</td><td width='80px'>Client</td></tr>"; 
					echo "<tr><td colspan='5'><hr></td></tr>";
					while ($row = mysqli_fetch_assoc($result)){
						echo "<tr>";
						echo "<td id='item'>".$row["id_com"]."</td><td> ".$row["date"]."</td><td><a href='detail.php?id=".$row["id_prod"]."'> ".$row["id_prod"]."<a></td><td><a href='details.php?login=".$row["id_client"]."'>".$row["nom"]." ".$row["prenom"]."</a></td>";
						echo "</tr>";
						echo "<tr><td colspan='5'><hr></td></tr>";
					}
			echo "</table>";
		}
		mysqli_close($mysqli);
	}
?>