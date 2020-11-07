<?php
	session_start();

	if(isset($_POST["item"]) && isset($_POST["pos"])){
		$arr1 = array();
		$trouve = false;
		if(isset($_SESSION["panier"])){
		$arr = json_decode($_SESSION["panier"], true);
		$x = 0;	
			foreach($arr as $item){
				
				if(($_POST["item"] == $item) && ($x == $_POST["pos"]) && $trouve == false){
					$trouve = true;
				}else{
					$arr1[] = $item;
					$x++;
				}				
				
			}
		
		}
		
		if($arr1){
			$_SESSION['panier'] = json_encode($arr1);
		}else{
			unset($_SESSION['panier']);
		}
			
	}
?>