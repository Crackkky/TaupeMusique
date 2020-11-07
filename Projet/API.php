<?php


function getRubriques() {
    $rubriques = array();

    $mysqli = connect();
    $str = "SELECT ID_RUB, LIBELLE_RUB FROM RUBRIQUES;";
    $result = queryDB($mysqli, $str) or die ("Impossible de se connection à la base de données pour afficher les rubriques<br>");

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            //echo $row["LIBELLE_RUB"]."<br />";
            $rubriques[$row["ID_RUB"]] = $row["LIBELLE_RUB"];
        }
    } else {
        echo "0 results rubriques";
    }

    //print_r($rubriques);
    return $rubriques;
}

function getProduits() {
    //$rubriques = getRubriques();
    $produits = array();

    $mysqli = connect();
    $str = "SELECT ID_PROD, LIBELLE, GENRE FROM PRODUITS;";
    $result = queryDB($mysqli, $str) or die ("Impossible de se connection à la base de données pour afficher les rubriques<br>");

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            //echo $row["GENRE"]."<br />";
            $produits[$row["ID_PROD"]] = array($row["LIBELLE"], $row["GENRE"]);
        }
    } else {
        echo "0 results products";
    }

    //print_r($temp);
    /*foreach ($rubriques as $keyGenre => $genre) {
        foreach ($temp as $prod => $genreProd) {
            //echo $genre;
            if($genreProd == $keyGenre){
                $produits[$prod] = $genre;
            }
        }
    }*/

    //print_r($produits);
    return $produits;
}

/*function getRoots() {
    global $Hierarchie;
    $roots = array();
    foreach ($Hierarchie as $categorie => $ssCategorie) {
        if (array_key_exists("super-categorie", $Hierarchie[$categorie])) {
            $roots[] = $categorie;
        }
    }
    return $roots;
}*/

function getNexts($current) {
    global $Hierarchie;
    $nexts = array();
    if (!array_key_exists("sous-categorie", $Hierarchie[$current])) {
        foreach ($Hierarchie[$current]["sous-categorie"] as $ssCategorie) {
            $nexts[] = $ssCategorie;
        }
    }
    if (empty($nexts)) {
        return NULL;
    }
    return $nexts;
}

function getParent($current) {
    global $Hierarchie;
    return $Hierarchie[$current]["super-categorie"];
}

/**
 * Renvoie la liste des cocktails
 * @param  Array<String> $chansons Liste de tous les ingrédients
 * @return Array<Int>              IDs des cocktails contenant tous les ingrédients de la liste
 */
function getAlbumsWith($chansons) {
    $mysqli = connect();
    $Albums = getAllAlbums($mysqli);
    disconnect($mysqli);
    $albums = array();
    foreach ($Albums as $id => $album) {
        $albumIngr = $album["index"]; // Liste des ingrédients de la recette
        $matchingIngr = array_intersect($chansons, $albumIngr); // Liste des ingrédients communs aux 2 listes
        if (count($matchingIngr) == count($chansons)) {
            $albums[] = $id;
        }
    }
    return $albums;
}

function getAlbumById($id, $Album) {
    if(array_key_exists($id, $Album)){
        return $Album[$id];
    }
    else {
    return array();
    }
    
}
?>