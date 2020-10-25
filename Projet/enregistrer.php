<?php
session_start();

include("Fonctions.inc.php");



$ok = true;
$result["msg"] = "valide";

$mysqli = connect();
//on pérénise les informations
$pass = mysqli_real_escape_string($mysqli,$_POST["passwordbdd"]);
$login = mysqli_real_escape_string($mysqli,$_POST["loginbdd"]);
$email = mysqli_real_escape_string($mysqli,$_POST["emailbdd"]);
$nom = mysqli_real_escape_string($mysqli,$_POST["nombdd"]);//
$prenom = mysqli_real_escape_string($mysqli,$_POST["prenombdd"]);
$adresse = mysqli_real_escape_string($mysqli,$_POST["adressebdd"]);
$ville = mysqli_real_escape_string($mysqli,$_POST["villebdd"]);
$codepostal = mysqli_real_escape_string($mysqli,$_POST["codepostalbdd"]);
$date = mysqli_real_escape_string($mysqli,$_POST["datebdd"]);
$telephone = mysqli_real_escape_string($mysqli,$_POST["telephonebdd"]);
disconnect($mysqli);


//todo séparer le check du login et du mdp
if((isset($_POST["loginbdd"])) && (isset($_POST["passwordbdd"]))){ //si login et password sont renseignés
	if(empty($login) || empty($pass)){ //si l'un des deux est vide
		$return["pass"] = "Il faut entrer un mot de passe.";
		$return["loginVal"] = "Il faut entrer un Login.";
		$ok = false;
	} else{ //login et mot de passe non vide
		$matches[] = NULL;
		if(!is_char_ok($login)){
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


if(!isset($_POST["emailbdd"]) || empty($_POST['emailbdd']) || filter_var($_POST["emailbdd"], FILTER_VALIDATE_EMAIL)){
	$email = NULL;
	$return["emailVal"] = "L'email n'est pas valide";
	$ok = false;
}

if(!isset($_POST["nombdd"]) || empty($_POST["nombdd"]) || !is_ok($nom)){ //si le nom est renseigné
		$return["Nom"] = "le Nom ne peut pas être vide";
		$nom = NULL;
}

if(!isset($_POST["prenombdd"]) || empty($_POST['prenombdd']) || !is_ok($prenom)){
	$prenom = NULL;
	$return["Prenom"] = "Prénom invalide";
	$ok = false;
}

if(!isset($_POST["adressebdd"]) || empty($_POST["adressebdd"]) || !is_ok($adresse)) {
	$adresse = NULL;
	$return["Adresse"] = "Adresse invalide";
	$ok = false;
}


if(!isset($_POST["villebdd"]) || empty(($_POST['villebdd'])) || !is_ok($ville)){
		$return["ville"] = "La ville n'est pas valide";
		$ok = false;
}

if(!isset($_POST["codepostalbdd"]) || empty($_POST["codepostalbdd"]) || strlen($codepostal)!=5){
		$return["codepostal"] = "Le code postal n'est pas valide";
		$ok = false;
}


if(!isset($_POST["datebdd"]) || empty($_POST['datebdd']) || strlen($date)>50){ //todo verifier la date
		$return["date"] = "la date n'est pas valide";
		$ok = false;
}

if(!isset($_POST["telephonebdd"]) || empty(($_POST['telephonebdd']))
	|| !preg_match("/^[0-9]{9,15}$/", $_POST["telephonebdd"])) {
		$return["telephoneVal"] = "le telephone n'est pas valide";
		$telephone = NULL;
		$ok = false;
}



if(isset($_POST["optradio"])){
	$sexe = $_POST["optradio"];
}else{
	$sexe = NULL;
}

if(isset($login) && !empty($login) && is_char_ok($login)){ //si on a renseigné le login et qu'il est bon
	$mysqli = connect(); //CONNEXION BDD
	//ici on fait une requete à la BDD pour savoir si le login est déjà récupéré ou non
	$str = "SELECT EMAIL FROM USERS WHERE login = '".$login."'";
	$result = query($mysqli,$str) or die("L'email est déjà utilisé<br>");
	if(mysqli_num_rows($result)>0){
		$ok = false;
		$return["dejaEmail"] = "l'email saisi est déjà enregistré";
	}


	$str = "SELECT LOGIN FROM USERS WHERE LOGIN = '".$login."'";
	$result = query($mysqli,$str) or die("Le Login est déjà utilisé<br>");
	if(mysqli_num_rows($result)>0){
		$ok = false;
		$return["dejaLogin"] = "le login saisi est déjà enregistré";
	}
	disconnect($mysqli);
}else{
	$ok = false;
}

//todo je fais une connexion de la BDD pour check si mail et login sont pas déjà utilisé puis j'en refais une après : utile ?

if($ok === true){ // tout est bon , on pérenise les entrées puis on insert
	$mysqli = connect();
		$return['msg'] = "OK";
		//todo oskour l'injection SQL
		$str = "INSERT INTO USERS VALUES ('".$login."','".$email."','".password_hash($pass, PASSWORD_DEFAULT)."','".$nom."','".$prenom."','".$date."','".$sexe."','".$adresse."','".$codepostal."','".$ville."','".$telephone."');";
		query($mysqli,$str) or die("Impossible de creer une compte dans ce moment<br>");
		setcookie('user',$login,time() + 3600);
		unset($return);
	disconnect($mysqli); //DECONNEXION BDD
	header('location: index.php');
	exit();
}
else{//il y a eu une erreur, elle est dans $return
	echo "something went wrong...<br>";
	$_SESSION["inscription"] = $return;
	print_r($return);
	exit();
}
?>
