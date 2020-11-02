<?php
include("../Fonctions.inc.php");
if(isset($_POST["item"])) {
    $item = intval($_POST["item"]);
    $mysqli = connect();
    $str = "DELETE FROM PRODUITS WHERE ID_PROD = ".$item.";"; //todo sql injection
    queryDB($mysqli, $str);
    disconnect($mysqli);
}

?>