<?php

// Parametres de configuration de la connexion
// -> permet de porter l'application en ne modifiant qu'une seule fois
//	les paramètres de connexions à un serveur MySQL

function getHost(){
    $host="localhost";
    return $host;
}
function getUser(){
    $user="root";
    return $user;
}

function getPass(){
    $pass="";
    return $pass;
}

function getBase(){
    $base="CDs";
    return $base;
}

function getID(){
    $id_user = "0000";
    return $id_user;
}

?>