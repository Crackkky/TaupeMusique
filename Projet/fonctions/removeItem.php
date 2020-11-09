<?php
session_start();
include "../Fonctions.inc.php";

//Permet de n'autoriser que l'administrateur à accéder à cette page
if(isset($_SESSION["user"])){
    if($_SESSION["admin"] == true) {
        if(isset($_POST["item"])){
           $mysqli = connect();
           $str = "DELETE FROM PRODUITS WHERE ID_PROD = ".intval($_POST["item"]).";";
           queryDB($mysqli, $str);
           disconnect($mysqli);
        }
    }
}

?>