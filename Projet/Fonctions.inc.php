<?php
include("parametres.php");

/*---------------------------------
 * fonctions pour la base de donnée
 * -------------------------------*/

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
    $mysqli = mysqli_connect($host,$user,$pass) or die("Problème de création de la base :".mysqli_error($mysqli));
    mysqli_select_db($mysqli,$base) or die("Impossible de sélectionner la base : $base");

    return $mysqli;
}

/** déconnecte de la BDD
 * @param $mysqli : le lien vers la BDD
 */
function disconnect($mysqli){
    mysqli_close($mysqli);

}
function query($link,$query)
{
    $resultat=mysqli_query($link,$query) or die("$query : ".mysqli_error($link));
    return($resultat);
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
    return strlen($string) > 5 && strlen($string) < 65;
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
    //check la taille entre 6 et 64
    if(!(is_size_ok($string))){
        $res = false;
    }
    if(!(is_char_ok($string))){
        $res = false;
    }

    return $res;
}

?>