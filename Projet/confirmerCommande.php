<?php
session_start();



if(isset($_COOKIE["panier"]) && isset($_COOKIE["user"])){
    $panier = json_decode($_COOKIE["panier"]);
    include("Fonctions.inc.php");
    include("Donnees.inc.php");


    $mysqli=connect();
    foreach($panier as $item){
        queryDB($mysqli,"replace into commande (ID_PROD,ID_CLIENT,DATE,CIVILITE,NOM,PRENOM,ADRESSE,CP,VILLE,TELEPHONE) values ('".$item."','".$_COOKIE["user"]."','".date('d/m/Y')."','".$_SESSION["CIVILITE"]."','".$_SESSION["NOM"]."','".$_SESSION["PRENOM"]."','".$_SESSION["ADRESSE"]."','".$_SESSION["CP"]."','".$_SESSION["VILLE"]."','".$_SESSION["TELEPHONE"]."')");
    }
    setcookie("panier", "", time()-3600,"/");
    disconnect($mysqli);
    $_SESSION["paiement"] = "opération réussie";
    $_SESSION["color"] = "green";

}else{
    $_SESSION["paiement"] = "Donnees incorrectes <br/> Veuillez essayer de nouveau";
    $_SESSION["color"] = "red";
}

header('location: panier.php');




?>