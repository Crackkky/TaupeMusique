<?php
include("Fonctions.inc.php");
include("./API.php");
$favAlbums = array();
if (isset($_COOKIE["user"])) { //todo changer la méthode de connexion par un simple cookie

    /**
     * on se connecte à la BDD
     * on recupere les alubms favoris
     * on recupere tous les albums
     * on se déconnecte
     */
    $mysqli = connect();
    //FAVS :
    $resultFav = queryDB($mysqli, "SELECT ID_PROD FROM FAVS WHERE LOGIN = '".$_COOKIE["user"]."'") or die("récupération des Albums favoris impossible");
    //PRODUIT : ID_PROD|LIBELLE|PRIX|CHANSONS|DESCRIPTIF|GENRE
    $resultAll = queryDB($mysqli, "SELECT * FROM PRODUITS") or die("echec recuperation de tous les albums");

    //on parse les resultats des albums favoris
    $favAlbums = array();
    while($fav = mysqli_fetch_assoc($resultFav)) {
        $favAlbums[] = $fav["ID_PROD"];
    } //on a fini de construire l'album des favoris

    //on parse les resultats de tous les albums
    $Albums = array();
    while($all = mysqli_fetch_assoc($resultAll)) {
        $Albums[] = $all;
    } //on a fini de construire l'album des favoris

    //print_r($Albums);
    disconnect($mysqli);



} else if (isset($_COOKIE['favoris'])){ //si on a des favoris
    $favAlbums = json_decode($_COOKIE['favoris'],true);
} else {
    $favAlbums = array();
}

if (!isset($_POST["ingr"])) { //si requete un ingr
    echo '<table><tr>';
    $step = 0;
    if ($_POST["favOnly"] == "true") { //si on demande seulement les favoris on itère dessus
        foreach ($favAlbums as $id) {
            echo displayBox($id, "heart fullHeart", $Albums);
            $step++;
            if($step == 3){
                $step = 0;
                echo '</tr><tr>';
            }
        }
    } else { //sinon on affiche tous les albums

        foreach ($Albums as $id => $album) {
            echo displayBox($id, "heart".(in_array($id, $favAlbums) ? (" fullHeart") : ("")), $Albums);
            $step++;
            if($step == 3){
                $step = 0;
                echo '</tr><tr>';
            }
        }
    }
    echo '</tr></table>';
    die();
}

$albums = getalbumsWith($_POST["ingr"]);

if ($_POST["favOnly"] == "true") {
    $albums = array_intersect($albums, $favAlbums);
}


if (empty($albums)) {
    echo '<h2>Désolé, il n\'existe pas d\'albums contenant ces paramètres</h2>';
}

echo '<table><tr>';
$step = 0;
foreach ($albums as $albumId) {
    echo displayBox($albumId, "heart".(in_array($albumId, $favAlbums) ? (" fullHeart") : ("")), $Albums);
    $step++;
    if($step == 3){
        $step = 0;
        echo '</tr><tr>';
    }
}
echo '</tr></table>';

function displayBox($albumId, $heartClass, $Albums) {

    $album = getAlbumById($albumId, $Albums);

    $nom = $album["LIBELLE"];
    $shortName = substr($nom, 0, 25);
    $shortName .= ((strlen($nom) != strlen($shortName)) ? ("...") : (""));
    $desc = $album["DESCRIPTIF"];
    if(file_exists("img_cover/$nom.jpg")){
        $imgURL = "img_cover/$nom.jpg";
    }else if(file_exists("img_cover/$nom.jpeg")){
        $imgURL = "img_cover/$nom.jpeg";
    }else if(file_exists("img_cover/$nom.gif")){
        $imgURL = "img_cover/$nom.gif";
    }else if(file_exists("img_cover/$nom.png")){
        $imgURL = "img_cover/$nom.png";
    }else if(file_exists("img_cover/$nom.bmp")){
        $imgURL = "img_cover/$nom.bmp";
    }else{
        $imgURL = "images/abstract-q-g-640-480-2.jpg";
    }
    if(isset($_POST['mot']) && !empty($_POST['mot']) && (stripos($nom,$_POST['mot']) !== false)){
        return '<td style="heigh:30%;width:30%"> <div class="col-sm-4 col-lg-4 col-md-4 recipeBox" style="width:100%">
				<div class="thumbnail">
				<img src="'.$imgURL.'" alt="" style="height:20%">
				<div class="caption" data-toggle="tooltip" title="'.$nom.'">
					<h4><a href="./detail.php?id='.$albumId.'">'.$shortName.'</a>
					</h4>
					<p>'.$desc.'</p>
				</div>
				<div class="ratings">
					<p class="pull-right"><a href="#" id="addPan" onclick="addPanier('.$albumId.')">Ajouter au panier</a></p>
				</div>
				<div id="toolt" class="'.$heartClass.'" data-album="'.$albumId.'" data-toggle="tooltip" title="Favoris" onclick="addFav('.$albumId.')"></div>
			</div>
			</div></td>';
    }else if(isset($_POST['mot']) && !empty($_POST['mot']) && (stripos($nom,$_POST['mot']) === false)){
        return '';
    }
    else{
        return '<td style="heigh:30%;width:30%"> <div class="col-sm-4 col-lg-4 col-md-4 recipeBox" style="width:100%">
				<div class="thumbnail">
				<img src="'.$imgURL.'" alt="" style="height:20%">
				<div class="caption" data-toggle="tooltip" title="'.$nom.'">
					<h4><a href="./detail.php?id='.$albumId.'">'.$shortName.'</a>
					</h4>
					<p>'.$desc.'</p>
				</div>
				<div class="ratings">
					<p class="pull-right"><a href="#" id="addPan" onclick="addPanier('.$albumId.')">Ajouter au panier</a></p>
				</div>
				<div id="toolt" class="'.$heartClass.'" data-album="'.$albumId.'" data-toggle="tooltip" title="Favoris" onclick="addFav('.$albumId.')"></div>
			</div>
			</div></td>';
    }

}
?>