<?php
session_start();

if(!isset($_SESSION["user"])){

    if(isset($_POST["login"]) && isset($_POST["password"]) && !empty($_POST["login"]) && !empty($_POST["password"])){

        include("Fonctions.inc.php");
        include("Donnees.inc.php");

        $mysqli = connect();
        $return["FLAG"] = false;
        $return["msg"] = "L'utilisateur n'a été pas trouvé";


        $login = trim(mysqli_real_escape_string($mysqli,$_POST["login"]));
        $pass = trim(mysqli_real_escape_string($mysqli,$_POST["password"]));


        $str = "SELECT LOGIN,PASS,EMAIL,ADMIN FROM USERS WHERE LOGIN = '".$login."'";

        //On récupère les favoris de l'utilisateur qui se connecte
        $str1 = "SELECT ID_PROD FROM FAVS WHERE LOGIN = '".$login."'";

        $result = queryDB($mysqli,$str) or die ("Impossible de se connection à la base de données<br>");
        if(mysqli_num_rows($result)>0){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($pass, $row["PASS"])){
                //Ici, lorsque le login fonctionne alors il faut récupérer toutes les infos utiles de l'utilisateur pour éviter de refaire à chaque fois des appels à la bdd
                $_SESSION["user"] = $row["LOGIN"];
                $_SESSION["admin"] = $row["ADMIN"];
                //On vient charger les favoris de l'utilisateur lors de la connexion
                $resultFav = queryDB($mysqli, $str1) or die("récupération des Albums favoris impossible");

                //on parse les resultats des albums favoris
                $favAlbums = array();
                while($fav = mysqli_fetch_assoc($resultFav)) {
                    $favAlbums[] = $fav["ID_PROD"];
                }

                $_SESSION["favoris"] = json_encode($favAlbums);

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

        mysqli_close($mysqli);

    }
    else{
        $return["FLAG"] = true;
        $return["msg"] = "Veuillez vérifier vos champs login et mot de passe.";
        echo "You should access this page from the form";
    }


}
else{
    echo "You're already connected";
}
?>