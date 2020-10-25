<?php

// Parametres de configuration de la connexion
// -> permet de porter l'application en ne modifiant qu'une seule fois
//	les param�tres de connexions � un serveur MySQL

function getHost(){
    $host="127.0.0.1";
    return $host;
}
function getUser(){
    $user="root";
    return $user;
}

function getPass(){
    $pass="je suis un mot de passe fort";
    return $pass;
}

function getBase(){
    $base="CDs";
    return $base;
}

function getID(){
    $id_user="0000";
    return $id_user;
}

?>