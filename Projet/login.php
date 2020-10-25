<?php
include("Fonctions.inc.php");
include("Donnees.inc.php");

$mysqli = connect();
$return["error"] = true;
$return["msg"] = "L'utilisateur n'a été pas trouvé";

if(isset($_POST["login"]) && isset($_POST["password"])){
    $login = trim(mysqli_real_escape_string($mysqli,$_POST["login"]));
    $pass = $_POST["password"];
    $str = "SELECT LOGIN,PASS,EMAIL FROM USERS WHERE LOGIN = '".$login."'";
    $result = queryDB($mysqli,$str) or die ("Impossible de se connection à la base de données<br>");
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);

        if(password_verify($pass, $row["PASS"])){
            setcookie("user",$row["LOGIN"]);
            unset($return);
            $return["msg"] = "L'utilisateur est connecté";
            $return["error"] = false;
            mysqli_close($mysqli);
            echo json_encode($return);
            exit();
        }

    }
}
mysqli_close($mysqli);
echo json_encode($return);
?>