<?php
include("parametres.php");

/*---------------------------------
 * fonctions pour la base de donnée
 * -------------------------------*/

function first_connect(){
    $host = getHost();
    $user = getUser();
    $pass = getPass();
    $mysqli = mysqli_init(); //pour le msqli_error
    $mysqli = mysqli_connect($host,$user,$pass) or die("Problème de création de la base :".mysqli_error($mysqli));

    return $mysqli;
}

function select_database($mysqli){
    $base = getBase();
    $mysqli = mysqli_select_db($mysqli,$base) or die("Impossible de sélectionner la base : $base");

}

/**
 * Connexion à la BDD et selectionne la bonne table.
 * @return false|mysqli : représente la connexion à la BDD ou false si cela échoue.
 */
function connect(){ //todo lire les creds dans un fichier avec les bons droits
    $host = getHost();
    $user = getUser();
    $pass = getPass();
    $base = getBase();
    $mysqli = mysqli_init(); //pour le msqli_error
    $mysqli = mysqli_connect($host, $user, $pass) or die("Problème de connexion à la base :".mysqli_error($mysqli));
    mysqli_select_db($mysqli, $base) or die("Impossible de sélectionner la base : $base");

    return $mysqli;
}

/** déconnecte de la BDD
 * @param $mysqli : le lien vers la BDD
 */
function disconnect($mysqli){
    mysqli_close($mysqli);

}

function queryDB($link,$query)
{
    $resultat=mysqli_query($link,$query) or die("$query : ".mysqli_error($link));
    return($resultat);
}

/**
 *  Fonction qui récupère la liste de tous les albums
 * @param $mysql : la connexion de la BDD
 * @return array : le tableau de tous les albums
 */
function getAllAlbums($mysqli){
    $resultAll = queryDB($mysqli, "SELECT * FROM PRODUITS") or die("echec recuperation de tous les albums");
    //on parse les resultats de tous les albums
    $Albums = array();
    while($all = mysqli_fetch_assoc($resultAll)) {
        $Albums[] = $all;
    } //on a fini de construire l'album des favoris
    return $Albums;
}

/*---------------------------------
 * fonctions qui tests les strings
 --------------------------------*/

//todo penser à d'autre tests ?

/**
 * @param $string : chaine à tester
 * @return bool : true si la taille de string est entre 6 et 64
 */
function is_size_ok($string){
    return strlen($string) > 1 && strlen($string) < 65;
}


/**
 * @param $pass : mot de passe a tester
 * @return bool : true si le mot de passe fait entre 6 et 64 caractères
 */
function is_size_pass_ok($pass){
    return strlen($pass) > 5 && strlen($pass) < 65;
}

/**
 * @param $string : chaine à tester
 * @return false|int : return false ou int selon si la chaine contient que les bons characteres
 */
function is_char_ok($string){
    return preg_match("/^[a-zA-Z'\-\_0-9 ]+$/", $string);
}

//fait une batterie de test sur une string pour valider le format
function is_ok($string){
    $res = true;
    //check la taille entre 2 et 64
    if(!(is_size_ok($string))){
        $res = false;
    }
    if(!(is_char_ok($string))){
        $res = false;
    }

    return $res;
}

/**
 * Fonction temporaire pour récupérer les userdata via la BD, il faudrait faire ça en local //todo
 * @param $mysqli: la connexion à la bdd
 */
function getUserData($mysqli){
    $login = $_COOKIE['user'];
    $str = "SELECT * FROM USERS WHERE login = '".$login."'";
    $res = queryDB($mysqli, $str);
    while($all = mysqli_fetch_assoc($res)) {
        $user = $all;
    }
    return $user;
}

?>