<?php
session_start();

if(isset($_SESSION["user"])){

    include("Fonctions.inc.php");
    include("Donnees.inc.php");

   $mysqli = connect();


    if(isset($_SESSION["user"])){
        $user = $_SESSION["user"];
        $produit = $_POST["id_produit"];
        $str0 = "SELECT * FROM FAVS where id_prod = '".$produit."' and LOGIN = '".$user."'";
        $str = "INSERT INTO FAVS VALUES('".$user."','".$produit."')";
        $result = queryDB($mysqli,$str0) or die("Impossible de ajouter produit<br>");
        if(mysqli_num_rows($result)>0){
            queryDB($mysqli,'delete from FAVS where id_prod = '.$produit.' and LOGIN = \''.$_SESSION["user"].'\'');
            echo 'delete set';
        }else{
            queryDB($mysqli,$str);
        }

        if(!isset($_SESSION["favoris"])){
            $arr[] = $_POST["id_produit"];
            if(isset($_POST["id_produit"])){
                $_SESSION["favoris"] = json_encode($arr);
            }
        }
        else{
            $arr = array();
            $arr = json_decode($_SESSION["favoris"], true);
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
            $_SESSION["favoris"] = json_encode($arr);
        }
    }

    mysqli_close($mysqli);
}

//Si l'utilisateur n'est pas connecté alors on ne fait rien

?>