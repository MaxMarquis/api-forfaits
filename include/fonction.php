<?php
// Cette fonction prend l'object au format tablulaire SQL 
// et retourne un objet dont la structure correspond au format
// devant être retourné par l'API. 
function ConversionForfaitSQLEnObjet($forfaitsSQL) {
    $forfaitsOBJ = new stdClass();
    $forfaitsOBJ->destination = $forfaitsSQL["destination"];
    $forfaitsOBJ->id = intval($forfaitsSQL["id"]);
    $forfaitsOBJ->villeDepart = $forfaitsSQL["villeDepart"];

    $forfaitsOBJ->hotel = new stdClass();
    $forfaitsOBJ->hotel->nom = $forfaitsSQL["nom"];
    $forfaitsOBJ->hotel->coordonnees = $forfaitsSQL["coordonnees"];
    $forfaitsOBJ->hotel->nombreEtoiles = intval($forfaitsSQL["nombreEtoiles"]);
    $forfaitsOBJ->hotel->nombreChambres = intval($forfaitsSQL["nombreChambres"]);
    $forfaitsOBJ->hotel->caracteristiques = explode(";", $forfaitsSQL["caracteristiques"]);

    $forfaitsOBJ->dateDepart = $forfaitsSQL["dateDepart"];
    $forfaitsOBJ->dateRetour = $forfaitsSQL["dateRetour"];
    $forfaitsOBJ->prix = intval($forfaitsSQL["prix"]);
    $forfaitsOBJ->rabais = intval($forfaitsSQL["rabais"]);
    $forfaitsOBJ->vedette = boolval($forfaitsSQL["vedette"]);
    return $forfaitsOBJ;
}   
?>