<?php
	function afficherUtilisateurs(){
		include("Fonctions.inc.php");
		include("Donnees.inc.php");

		$mysqli = connect();
		
		echo "<hr>";
		$result = queryDB($mysqli,'SELECT login,prenom,nom,email,adresse,ville,telephone FROM USERS WHERE login = \'admin\'');
		$result2 = queryDB($mysqli,'SELECT login,prenom,nom,email,adresse,ville,telephone FROM USERS WHERE login != \'admin\'');
		if((mysqli_num_rows($result)>0) || (mysqli_num_rows($result2)>0)){
			
			echo "<table>";
			if($result){
					echo "<tr><td><h2>Administrateur</h2></td></tr>";
					while ($row = mysqli_fetch_assoc($result)){
						echo "<tr>";
						echo "<td>".$row["prenom"]." ".$row["nom"]."</td>";
						echo "</tr>";
					}
			}
			
			echo "</table><br/><br/>";
			echo '<hr>';
			echo "<table>";
			if($result2){
				echo "<tr><td><h2>Clients</h2></td></tr>";
				while ($row = mysqli_fetch_assoc($result2)){
						echo "<tr>";
						echo "<td>".$row["login"]." ".$row["prenom"]." ".$row["nom"]."</td>";
						echo "<td><a href='details.php?login=".$row["login"]."'> détails </a></td>";
						echo "</tr>";
					}
			}
			
					
			echo "</table>";
		}
		else{
			echo "Aucun enregistrement dans la base de données";
		}
		mysqli_close($mysqli);
	}
	
?>