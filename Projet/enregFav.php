<?php
include("Fonctions.inc.php");
include("Donnees.inc.php");

$mysqli = connect();



if(isset($_COOKIE["user"])){
    $user = $_COOKIE["user"];
    $produit = $_POST["id_produit"];
    $str0 = "SELECT * FROM FAVS where id_prod = '".$produit."' AND login = '".$user."'";
    $str = "INSERT INTO FAVS (login, id_prod) VALUES('".$user."','".$produit."')";
    $result = queryDB($mysqli,$str0) or die("Impossible de ajouter produit<br>");
    if(mysqli_num_rows($result)>0){
        queryDB($mysqli,'delete from FAVS where id_prod = '.$produit.' and LOGIN = \''.$user.'\'');
        echo 'delete set';
    }else{
        queryDB($mysqli,$str);
    }
}
//Pas besoin de cookies puisqu'on ne va jamais les utiliser. Lorsqu'on voudra afficher la liste des albums mis en favoris pour l'utilisateur connecté alors on va directement aller les chercher dans la bdd
/*else{
    if(!isset($_COOKIE["favoris"])){
        $arr[] = $_POST["id_produit"];
        if(isset($_POST["id_produit"])){
            setcookie("favoris",json_encode($arr),time() + (86400 * 15),'/');
        }
    }
    else{
        $arr = array();
        $arr = json_decode($_COOKIE["favoris"],true);
        if(isset($_POST["id_produit"])){

            if(!in_array($_POST["id_produit"],$arr)){
                $arr[] = $_POST["id_produit"];

            }else{
                $temp = array();
                foreach($arr as $item){
                    if($item != $_POST["id_produit"]){
                        $temp[] = $item;
                    }
                }
                $arr = $temp;
            }
        }
        setcookie("favoris",json_encode($arr), time() + (86400 * 15),'/');
    }
}*/
mysqli_close($mysqli);

?>