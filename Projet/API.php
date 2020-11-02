<?php

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