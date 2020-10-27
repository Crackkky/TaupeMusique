<?php
include("API.php");
include("Fonctions.inc.php");
?>

<?php

if(!isset($_GET["id"])) {
    header("location: ./");
}

$albumId = $_GET["id"];


$mysqli = connect();

//PRODUIT : ID_PROD|LIBELLE|PRIX|CHANSONS|DESCRIPTIF|GENRE
$resultAll = queryDB($mysqli, "SELECT * FROM PRODUITS") or die("echec recuperation de tous les albums");

//on parse les resultats de tous les albums
$Albums = array();
while($all = mysqli_fetch_assoc($resultAll)) {
    $Albums[] = $all;
} //on a fini de construire l'album des favoris

//print_r($Albums);
disconnect($mysqli);


if (filter_var($albumId, FILTER_VALIDATE_INT) === false) {
    header("location: 404.php");
} 

$album = getAlbumById($albumId, $Albums);

if(empty($album)){
    header("location: 404.php");
}
else{
    $nom = $album["LIBELLE"];
    $shortName = substr($nom, 0, 25);
    $shortName .= ((strlen($nom) != strlen($shortName)) ? ("...") : (""));
    $prep = $album["DESCRIPTIF"];
    $prix = $album["PRIX"];
    $ingr = explode("|", $album["CHANSONS"]);
    $imgURL = (file_exists("img_cover/$nom.jpg") != false) ? ("img_cover/$nom.jpg") : ("images/tech.jpg");



?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php include("imports.html"); ?>

    <title>Taupe Musique</title>

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!--
    [if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]
    -->

</head>

<body>


<!-- Navigation -->
<?php include("./navbar.php");?>

<!-- Page Content -->
<div class="container">

    <div class="col-xs-5">

        <img style="width: 100%;" src="<?=$imgURL?>"></img>

    </div>

    <div class="col-xs-7">

        <h1><?=$nom?></h1>

        <h3>Chansons</h3>

        <ul>
            <?php

            foreach ($ingr as $chanson) {
                echo "<li>".$chanson."</li>";
            }

            ?>
        </ul>

        <h3>Critique</h3>

        <p><?=$prep?></p>
        <hr>
        <h3><?=$prix?> €  </h3><button class="btn btn-default">Ajouter au panier</button>
    </div>

<?php } ?>

</div>

</div>
<!-- /.container -->

<div class="container">

    <hr>

    <!-- Footer -->
    <?php include("./footer.php");?>
</body>

</html>
