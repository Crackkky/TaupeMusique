<?php
session_start();

/**
 * La commande est gérée via le Cookie Panier
 * qui contient un tableau des ID des produits à commander
 */

if(isset($_COOKIE["panier"]) && isset($_COOKIE["user"])){
    $panier = json_decode($_COOKIE["panier"]);
    include("Fonctions.inc.php");
    include("Donnees.inc.php");


    $mysqli=connect();
    $userData = getUserData($mysqli);
    print_r($userData);
    foreach($panier as $item){
        /*
         * COMMANDE : ID_COM | ID_PROD | ETAT | ID_CLIENT | DATE | CIVILITE | NOM | PRENOM | ADRESSE | CP | VILLE | TELEPHONE
         */
        if($userData["SEXE"]=="Homme"){
            $CIVILITE = "M";
        }else{
            $CIVILITE = "Mme";
        }
        queryDB($mysqli,"INSERT INTO COMMANDE (ID_PROD,ID_CLIENT,DATE,CIVILITE,NOM,PRENOM,ADRESSE,CP,VILLE,TELEPHONE) values ('".$item."','".$_COOKIE["user"]."','".date('d/m/Y')."','".$CIVILITE."','".$userData["NOM"]."','".$userData["PRENOM"]."','".$userData["ADRESSE"]."','".$userData["CODEP"]."','".$userData["VILLE"]."','".$userData["TELEPHONE"]."')");
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