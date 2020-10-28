<?php
session_start();

include("Fonctions.inc.php");

$ok = true;
$return["msg"] = "";

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


// * LOGIN
//todo séparer le check du login et du mdp

if((!isset($_POST["loginbdd"])) || empty($login)){ //si login est vide ou non renseigné
		$return["loginVal"] = "Il faut entrer un Login.";
		$ok = false;
} else{ //login non vide
	if(!is_char_ok($login)){
		//si le login ne contient pas uniquement des lettres min ou maj, chiffres - et _
		$return["loginVal"] = "Caractères illégaux détécté(s)";
		$login = NULL;
		$ok = false;
	}
	if(strlen($login) < 3 || strlen($login) > 50){
		$return["loginVal"] = "Login trop court";
		$login = NULL;
		$ok = false;
	}
}


// * MDP

if(!isset($_POST["passwordbdd"])|| empty($pass)){
		$return["pass"] = "Il faut entrer un mot de passe.";
		$ok = false;
} else { //mdp non vide
	if(!is_char_ok($pass)){
		//si le mdp ne contient pas uniquement des lettres min ou maj, chiffres - et _
		$return["passVal"] = "Caractères illégaux détécté(s)";
		$pass = NULL;
		$ok = false;
	}
	if(strlen($pass) < 5 || strlen($pass) > 100){
		$return["passVal"] = "Mot de passe trop court";
		$pass = NULL;
		$ok = false;
	}
}



// * EMAIL

if(!isset($_POST["emailbdd"]) || empty($_POST['emailbdd']) || !filter_var($_POST["emailbdd"], FILTER_VALIDATE_EMAIL) || strlen($email) < 5 || strlen($email) > 100){
	$email = NULL;
	$return["emailVal"] = "L'email invalide";
	$ok = false;
}

// * NOM

if(!isset($_POST["nombdd"]) || empty($_POST["nombdd"]) || !is_char_ok($nom) || strlen($nom) < 3 || strlen($nom) > 50){ //si le nom est renseigné
	$return["Nom"] = "Nom invalide";
	$nom = NULL;
}

// * PRENOM

if(!isset($_POST["prenombdd"]) || empty($_POST['prenombdd']) || !is_char_ok($prenom) || strlen($prenom) < 3 || strlen($prenom) > 50){
	$prenom = NULL;
	$return["Prenom"] = "Prénom invalide";
	$ok = false;
}

// * ADRESSE

if(!isset($_POST["adressebdd"]) || empty($_POST["adressebdd"]) || !is_char_ok($adresse) || strlen($adresse) < 5 || strlen($adresse) > 300) {
	$adresse = NULL;
	$return["Adresse"] = "Adresse invalide";
	$ok = false;
}

// * VILLE

if(!isset($_POST["villebdd"]) || empty(($_POST['villebdd'])) || !is_char_ok($ville) || strlen($ville) < 2 || strlen($ville) > 50){
	$return["ville"] = "La ville n'est pas valide";
	$ok = false;
}

// * CODE POSTAL

if(!isset($_POST["codepostalbdd"]) || empty($_POST["codepostalbdd"]) || strlen($codepostal) != 5){
	$return["codepostal"] = "Le code postal n'est pas valide";
	$ok = false;
}


// * DATE

if(!isset($_POST["datebdd"]) || empty($_POST['datebdd']) || strlen($date) > 10){ //todo verifier la date
	$return["date"] = "la date n'est pas valide";
	$ok = false;
}

// * TELEPHONE

if(!isset($_POST["telephonebdd"]) || empty(($_POST['telephonebdd']))
	|| !preg_match("/^[0-9]{9,15}$/", $_POST["telephonebdd"]) || strlen($telephone) != 10) {
	$return["telephoneVal"] = "le telephone n'est pas valide";
	$telephone = NULL;
	$ok = false;
}

// * SEXE (oui)

if(isset($_POST["optradio"])){
	$sexe = $_POST["optradio"];
}else{
	$sexe = NULL;
}


if(isset($login) && !empty($login) && is_char_ok($login)){ //si on a renseigné le login et qu'il est bon
	$mysqli = connect(); //CONNEXION BDD
	//ici on fait une requete à la BDD pour savoir si le login est déjà récupéré ou non
	$str = "SELECT EMAIL FROM USERS WHERE login = '".$login."'";
	$result = queryDB($mysqli,$str) or die("L'email est déjà utilisé<br>");
	if(mysqli_num_rows($result)>0){
		$ok = false;
		$return["dejaEmail"] = "l'email saisi est déjà enregistré";
	}


	$str = "SELECT LOGIN FROM USERS WHERE LOGIN = '".$login."'";
	$result = queryDB($mysqli,$str) or die("Le Login est déjà utilisé<br>");
	if(mysqli_num_rows($result)>0){
		$ok = false;
		$return["dejaLogin"] = "le login saisi est déjà enregistré";
	}
	disconnect($mysqli);
}else{
	$ok = false;
}

//todo je fais une connexion de la BDD pour check si mail et login sont pas déjà utilisé puis j'en refais une après : utile ?

if($ok === true){ // tout est bon , on se connecte a la BDD puis on insert les valeurs
	$return["FLAG"] = true;
	$return["msg"] = "Compte crée, vous pouvez maintenant vous connecter.";
	$mysqli = connect();
	//todo oskour l'injection SQL, faire des "sql prepare" machin
	$str = "INSERT INTO USERS VALUES ('".$login."','".$email."','".password_hash($pass, PASSWORD_DEFAULT)."','".$nom."','".$prenom."','".$date."','".$sexe."','".$adresse."','".$codepostal."','".$ville."','".$telephone."');";
	queryDB($mysqli,$str) or die("Impossible de creer une compte dans ce moment<br>");
	setcookie('user',$login,time() + 3600);
	//unset($return);
	disconnect($mysqli); //DECONNEXION BDD
	//header('location: index.php');
} else {
	$return["FLAG"]= false;
	$return["msg"] = "Une ou plusieurs erreurs detectée : ";
}

//on renvoie la donnée pour ajax
echo json_encode($return);
exit();

?>
