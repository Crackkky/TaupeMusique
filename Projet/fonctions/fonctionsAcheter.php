<?php
include("Fonctions.inc.php");

function afficherPanier(){
    $mysql = connect();
    $Albums = getAllAlbums($mysql);
    disconnect($mysql);
    if(isset($_SESSION["paiement"])){
        echo '<p style="color:'.$_SESSION["color"].';">'.$_SESSION["paiement"].'</p>';
        unset($_SESSION["color"]);
        unset($_SESSION["paiement"]);
    }
    else{
        /*le cookie panier :
        $_COOKIE["panier"] = Array([0] => ID, ..., [N] => ID}
        */
        if(isset($_SESSION["panier"])){
            $arr = json_decode($_SESSION["panier"],true);
            echo '<table>';
            echo "<tr><td width='50px'>ID</td><td width='80px'>Titre</td><td width='80px'>Prix</td></tr>";
            echo "<tr><td colspan='3'><hr></td></tr>";
            $pos = 0;
            foreach($arr as $item){
                $id = intval($item);

                echo "<tr>";
                echo "<td id='item'>".$Albums[$id]["ID_PROD"]."</td><td> ".$Albums[$id]["LIBELLE"]."</td><td> ".$Albums[$item]["PRIX"]."</td>";
                echo '<td><button onclick="removePanier('.$item.','.$pos.')">effacer</button></td>';
                echo "</tr>";
                echo "<tr><td colspan='3'><hr></td></tr>";
                $pos++;
            }



            echo '</table>';
        }
        else{
            echo '<p>Pas de produits dans votre panier</p>';
        }
    }
}

?>