<?php
session_start();

	if(isset($_POST["item"])){
		if(isset($_SESSION["panier"])){
			$arr = array();
			$arr = json_decode($_SESSION["panier"], true);
			$arr[] = $_POST["item"];
			$_SESSION['panier'] = json_encode($arr);
			echo "Produit ajouté au panier";

		}
		else{
			$arr = array();
			$arr[] = $_POST["item"];
			$_SESSION['panier'] = json_encode($arr);
			echo "Produit ajouté au panier";
		}
	}
	else{
		echo "Erreur";
	}
?>