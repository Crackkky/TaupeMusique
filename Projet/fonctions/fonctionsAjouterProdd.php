<?php
include '../Fonctions.inc.php';
$file_result = '';
$file_extension = '';
if($_FILES['file']['error']>0){
    header('location: ../produits.php?Erreur=img');
    exit();

}else{
    $file = $_FILES['file']['name'];
    if((preg_match("/[.](jpg)$/i",$file))){
        $file_extension = '.jpg';
    }else if(preg_match("/[.](jpeg)$/i",$file)){
        $file_extension = '.jpeg';
    }else if(preg_match("/[a-zA-Z0-9.]*[.](gif)$/i",$file)){
        //$file_extension = pathinfo($file, PATHINFO_EXTENSION);
        //ça sépare le string en deux et limite la séparation a deux élements
        //donc test.php.gif donnera :[0] : test [1] : php.gif
        //donc l'upload d'un shell est possible
        $tmp = ".".explode(".", $file, 2)[1];  //todo ici est la faille pour upload le shell en .php.gif
        $file_extension = ".".explode(".", $tmp)[1];
        echo "hmm ce nom de fichier m'a l'air tout à fait correct";
        echo "!!<br>";
        echo $file_extension;
        echo "<br>!!!";
    }else if(preg_match("/[.](png)$/i",$file)){
        $file_extension = '.png';
    }else if(preg_match("/[.](bmp)$/i",$file)){
        $file_extension = '.bmp';
    }else{
        header('location: ../produits.php?Erreur=img2');
        exit();
    }

    if(isset($_POST["titre"]) && isset($_POST["auteur"]) && isset($_POST["prix"]) && isset($_POST["descriptif"])){


        $ok = true;
        if(!preg_match('/^([A-Z\ a-z]{0,80}$)/', $_POST["auteur"])){
            $ok = false;
        }

        $ok = true;
        if(!preg_match('/^([A-Z\ a-z]{0,80}$)/', $_POST["titre"])){
            $ok = false;
        }

        if(!preg_match('/^([0-9]+$)/', $_POST["prix"])){
            $ok = false;
        }

        $tracks = array();
        if(isset($_POST["nombre"])){
            for($i = 0; $i <= $_POST["nombre"];$i++){
                if(isset($_POST["track".$i])){
                    $tracks[] = ($i+1).' '.$_POST["track".$i];
                }
            }

        }


        if($ok){ //on peut insérer dans la BDD

            //insertion image cover dans les fichiers
            $file_result = 'img_cover/'.($_POST["auteur"]." - ".$_POST["titre"]).$file_extension;
            move_uploaded_file($_FILES['file']['tmp_name'],'../'.$file_result);
            //echo "image cover updated</br></br>";


            //insertions dans la BDD
            $titre = $_POST['titre'];
            $auteur = $_POST['auteur'];
            $prix = $_POST['prix'];
            $desc = $_POST['descriptif'];
            $genre = $_POST['rubrique'];
            $nb_chansons = intval($_POST['nombre']);
            $all_songs = "";
            for($i=0; $i<$nb_chansons-1;$i++){
                $all_songs .= ($i+1) . " " . $_POST['track'.$i]." | ";
            } $all_songs .= $_POST['track'.$i];


            $str = "INSERT INTO PRODUITS (ID_PROD, LIBELLE,PRIX,CHANSONS,DESCRIPTIF) VALUES('0',\"$auteur $titre\",$prix,\"$all_songs\",\"$desc\");";

            //connexion à la BD
            $mysqli=connect();
            queryDB($mysqli, $str);
            disconnect($mysqli);

            header('location: ../produits.php');
        }
        else
        {
            /*
            echo $_POST["titre"];
            echo"</br>";echo $_POST["auteur"];
            echo"</br>";
            echo $_POST["prix"];
            echo"</br>";
            echo $_POST["descriptif"];
            echo"</br>";
            */
            echo "Erreur données non trustable";
        }



    }else{
        echo "Erreur les champs ne sont pas tous renseignés";
    }

}
?>
