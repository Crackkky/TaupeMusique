<?php

include("Fonctions.inc.php");

$mysqli = connect();

$pass = mysqli_real_escape_string($mysqli,$_POST["passwordbdd"]);
$email = mysqli_real_escape_string($mysqli,$_POST["emailbdd"]);
$nom = mysqli_real_escape_string($mysqli,$_POST["nombdd"]);//
$prenom = mysqli_real_escape_string($mysqli,$_POST["prenombdd"]);
$adresse = mysqli_real_escape_string($mysqli,$_POST["ADRESSEebdd"]);
$ville = mysqli_real_escape_string($mysqli,$_POST["villebdd"]);
$codepostal = mysqli_real_escape_string($mysqli,$_POST["postalbdd"]);
$date = mysqli_real_escape_string($mysqli,$_POST["datebdd"]);
$telephone = mysqli_real_escape_string($mysqli,$_POST["telephonebdd"]);
$sexe = $_POST["optradio"];

$login = $_COOKIE["user"]; //TODO VULENRABILITE SQL ATTENTION OSEKOUR AAAAH



// * EMAIL

if(isset($_POST["emailbdd"]) && !empty($_POST['emailbdd']) && filter_var($_POST["emailbdd"], FILTER_VALIDATE_EMAIL)){
    $str = "UPDATE USERS SET EMAIL = '".$email."' WHERE login='".$login."';";
    $email = NULL;
    queryDB($mysqli,$str) or die("erreur<br>");
}


// * NOM

if(isset($_POST["nombdd"]) && !empty($_POST["nombdd"]) && is_char_ok($nom)){ //si le nom est renseigné
    $str = "UPDATE USERS SET NOM = '".$nom."' WHERE login='".$login."';";
    $nom = NULL;
    queryDB($mysqli,$str) or die("erreur<br>");
}


// * PRENOM

if(isset($_POST["prenombdd"]) && !empty($_POST['prenombdd']) && is_char_ok($prenom)){
    $str = "UPDATE USERS SET PRENOM = '".$prenom."' WHERE login='".$login."';";
    $prenom = NULL;
    queryDB($mysqli,$str) or die("erreur<br>");
}


// * ADRESSE

if(isset($_POST["adressebdd"]) && !empty($_POST["adressebdd"]) && is_char_ok($adresse)) {
    $str = "UPDATE USERS SET ADRESSE = '".$adresse."' WHERE login='".$login."';";
    $adresse = NULL;
    queryDB($mysqli,$str) or die("erreur<br>");
}


// * VILLE

if(isset($_POST["villebdd"]) && !empty(($_POST['villebdd'])) && is_char_ok($ville)){
    $str = "UPDATE USERS SET VILLE = '".$ville."' WHERE login='".$login."';";
    $ville = NULL;
    queryDB($mysqli,$str) or die("erreur<br>");
}


// * CODE POSTAL

if(isset($_POST["postalbdd"]) && !empty($_POST["postalbdd"]) && strlen($codepostal)==5){
    $str = "UPDATE USERS SET CODEP = '".$codepostal."' WHERE login='".$login."';";
    $codepostal = NULL;
    queryDB($mysqli,$str) or die("erreur<br>");
}


// * DATE

if(isset($_POST["datebdd"]) && !empty($_POST['datebdd']) && strlen($date)<50){ //todo verifier la date
    $str = "UPDATE USERS SET DATE = '".$date."' WHERE login='".$login."';";
    $date = NULL;
    queryDB($mysqli,$str) or die("erreur<br>");
}


// * TELEPHONE

if(isset($_POST["telephonebdd"]) && !empty(($_POST['telephonebdd']))
    && preg_match("/^[0-9]{9,15}$/", $_POST["telephonebdd"])) {
    $str = "UPDATE USERS SET TELEPHONE = '".$telephone."' WHERE login='".$login."';";
    $telephone = NULL;
    queryDB($mysqli,$str) or die("erreur<br>");
}


// * SEXE (oui)

if(isset($_POST["optradio"])){
    $str = "UPDATE USERS SET SEXE = '".$sexe."' WHERE login='".$login."';";
    queryDB($mysqli,$str) or die("erreur<br>");
}


// * MDP

if(isset($_POST["passwordbdd"])|| !empty($pass)){
    if(!is_char_ok($pass)){
        //si le mdp ne contient pas uniquement des lettres min ou maj, chiffres - et _
        $return["passVal"] = "Caractères illégaux détécté(s)";
        $pass = NULL;
    }
    else if(!is_size_pass_ok($pass)){
        $return["passVal"] = "Mot de passe trop court";
        $pass = NULL;
    }
    else{
        $str = "UPDATE USERS SET PASS = '".password_hash($pass, PASSWORD_DEFAULT)."' WHERE login='".$login."';";
        queryDB($mysqli,$str) or die("erreur<br>");
    }


}



?>