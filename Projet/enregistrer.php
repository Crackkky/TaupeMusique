<?php
session_start();

include("Fonctions.inc.php");



$ok = true;
$result["msg"] = "valide";



if((isset($_POST["loginbdd"])) && (isset($_POST["passwordbdd"]))){ //si login et password sont renseignés
	if(empty($_POST["loginbdd"]) || empty($_POST["passwordbdd"])){ //si l'un des deux est vide
		$return["pass"] = "Il faut entrer un mot de passe.";
		$return["loginVal"] = "Il faut entrer un Login.";
		$ok = false;
	} else{ //login et mot de passe non vide
		$matches[] = NULL;
		if(!is_char_ok($_POST["loginbdd"])){
			//si le login ne contient pas uniquement des lettres min ou maj, chiffres - et _
			$return["loginVal"] = "Caractères illégaux détécté(s)";
			$login = NULL;
			$ok = false;
		}
		if(!is_size_ok($login)){ //si le login est trop grand
			$return["loginLong"] = "Le login est trop long (max 100)";
			$ok = false;
		}

		if(!is_size_ok($pass)){ //si le mot de passe à la bonne taille
			$return["passLong"] = "le mot de pass est trop long";
			$ok = false;
		}
	}

}
else{ //le login et le mot de passe ne sont pas renseignés
	$return["loginVal"] = "Le login n'est pas valide";;
	$return["passVal"] = "Le mot de passe n'est valide";
	$ok = false;
} //fin du test du login et mot de passe


if(isset($_POST["emailbdd"])){ //si on a renseignée le mail
	if(!filter_var($_POST["emailbdd"], FILTER_VALIDATE_EMAIL)){ //si mail non valide
		$return["emailVal"] = "L'email n'est pas valide";
		$email = NULL;
	} else{ //le mail est valide et renseigné
		$email = $_POST["emailbdd"];
	}
}else{ //le mail n'est pas renseigné
	$email = NULL;
}

if(isset($_POST["nombdd"])){ //si le nom est renseigné
	if(empty($_POST["nombdd"])){ //s'il n'est pas vide
		$return["Nom"] = "le Nom ne peut pas être vide";
		$nom = NULL;
	} else{
		if(!preg_match("/^[a-zA-Z'\- ]+$/",$_POST["nombdd"])){
			$return["Nom"] = "le Nom n'est pas valid";
			$nom = NULL;
		}else if(sizeof($nom)>50){
			$return["Nom"] = "le Nom est trop long";
			$ok = false;
		}
	}
}else{
	$nom = NULL;
}

if(isset($_POST["prenombdd"])){
	if(empty($_POST["prenombdd"])){
		$prenom = NULL;
	}
	else{
		$prenom = mysqli_real_escape_string($mysqli,$_POST["prenombdd"]);
		if(!preg_match("/^[a-zA-Z'\- ]+$/",$_POST["prenombdd"])){
			$return["Prenom"] = "le Prénom n'est pas valid";
			$prenom = NULL;
		}else if(sizeof($prenom)>50){
			$return["Prenom"] = "le Prénom est trop long";
			$ok = false;
		}
	}
}
else{
	$prenom = NULL;
}

if(isset($_POST["adressebdd"])){
	if(empty($_POST["adressebdd"])){
		$adresse = NULL;
	}else{
		$adresse = mysqli_real_escape_string($mysqli,$_POST["adressebdd"]);
		if(sizeof($adresse)>500){
			$return["Adresse"] = "L'adresse n'est pas valide";
			$ok = false;
		}
	}
}else{
	$adresse = NULL;
}


if(isset($_POST["villebdd"])){
	if(empty($_POST["villebdd"])){
		$ville = NULL;
	}else{
		$ville = mysqli_real_escape_string($mysqli,$_POST["villebdd"]);
		if(sizeof($ville)>50){
			$return["ville"] = "La ville n'est pas valide";
			$ok = false;
		}
	}
}
else{
	$ville = NULL;
}

if(isset($_POST["codepostalbdd"])){
	if(empty($_POST["codepostalbdd"])){
		$codepostal = NULL;
	}else{
		$codepostal = mysqli_real_escape_string($mysqli,$_POST["codepostalbdd"]);
		if(sizeof($codepostal)>50){
			$return["codepostal"] = "le code postal n'est pas valid";
			$ok = false;
		}
	}
}else{
	$codepostal = NULL;
}

if(isset($_POST["datebdd"])){
	if(empty($_POST["datebdd"])){
		$date = NULL;
	}else{
		$date = mysqli_real_escape_string($mysqli,$_POST["datebdd"]);
		if(sizeof($date)>50){
			$return["date"] = "la date n'est pas valid";
			$ok = false;
		}
	}
}
else{
	$date = NULL;
}

if(isset($_POST["telephonebdd"])){
	if(!preg_match("/^[0-9]{9,15}$/",$_POST["telephonebdd"])){
		$return["telephoneVal"] = "le telephone n'est pas valid";
		$telephone = NULL;
	}
	else{
		$telephone = mysqli_real_escape_string($mysqli,$_POST["telephonebdd"]);
	}
}else{
	$telephone = NULL;
}



if(isset($_POST["optradio"])){
	$sexe = $_POST["optradio"];
}else{
	$sexe = NULL;
}

if(isset($login)){
	$str = "SELECT EMAIL FROM USERS WHERE login = '".$login."'";
	$result = query($mysqli,$str) or die("Impossible de creer un compte pour le moment<br>");
	if(mysqli_num_rows($result)>0){
		$ok = false;
		$return["dejaEmail"] = "l'email saisi est déjà enregistré";
	}


	$str = "SELECT LOGIN FROM USERS WHERE LOGIN = '".$login."'";
	$result = query($mysqli,$str) or die("Impossible de creer une compte dans ce moment<br>");
	if(mysqli_num_rows($result)>0){
		$ok = false;
		$return["dejaLogin"] = "le login saisi est déjà enregistré";
	}
}else{
	$ok = false;
}



if($ok === true){ // tout est bon , on pérenise les entrées puis on insert
	$mysqli = connect(); //CONNEXION BDD
		$pass = mysqli_real_escape_string($mysqli,$_POST["passwordbdd"]);
		$login = mysqli_real_escape_string($mysqli,$_POST["loginbdd"]);
		$email = mysqli_real_escape_string($mysqli,$_POST["emailbdd"]);
		$nom = mysqli_real_escape_string($mysqli,$_POST["nombdd"]);//

		$return['msg'] = "OK";
		$str = "INSERT INTO USERS VALUES ('".$login."','".$email."','".password_hash($pass, PASSWORD_DEFAULT)."','".$nom."','".$prenom."','".$date."','".$sexe."','".$adresse."','".$codepostal."','".$ville."','".$telephone."');";
		query($mysqli,$str) or die("Impossible de creer une compte dans ce moment<br>");
		setcookie('user',$login,time() + 3600);
		unset($return);
	disconnect($mysqli); //DECONNEXION BDD
	header('location: index.php');
	exit();
}

else{
	$_SESSION["inscription"] = $return;
	exit();
}



?>
