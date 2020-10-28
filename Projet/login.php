<?php
include("Fonctions.inc.php");
include("Donnees.inc.php");

$mysqli = connect();
$return["FLAG"] = false;
$return["msg"] = "L'utilisateur n'a été pas trouvé";

if(isset($_POST["login"]) && isset($_POST["password"]) &&
    !empty($_POST["login"]) && !empty($_POST["password"])){
    $login = trim(mysqli_real_escape_string($mysqli,$_POST["login"]));
    $pass = $_POST["password"];
    //todo alerte sql injection oskour
    $str = "SELECT LOGIN,PASS,EMAIL FROM USERS WHERE LOGIN = '".$login."'";
    $result = queryDB($mysqli,$str) or die ("Impossible de se connection à la base de données<br>");
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pass, $row["PASS"])){
            setcookie("user",$row["LOGIN"]); //todo on se connecte via un cookie, oskour
            unset($return);
            $return["msg"] = "L'utilisateur est maintenant connecté";
            $return["FLAG"] = false;
            mysqli_close($mysqli);
            echo json_encode($return);
            exit();
        } else {
            $return["FLAG"] = true;
            $return["msg"] = "Mauvais login ou mot de passe.";
        }

    }
}else{
    $return["FLAG"] = true;
    $return["msg"] = "Veuillez vérifier vos champs login et mot de passe.";
}
mysqli_close($mysqli);
echo json_encode($return);
?>