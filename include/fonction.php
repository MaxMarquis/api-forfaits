<?php
// Cette fonction prend l'object au format tablulaire SQL 
// et retourne un objet dont la structure correspond au format
// devant être retourné par l'API. 
function ConversionForfaitSQLEnObjet($forfaitsSQL) {
    $forfaitsOBJ = new stdClass();
    $forfaitsOBJ->destination = $forfaitsSQL["destination"];
    $forfaitsOBJ->villeDepart = $forfaitsSQL["villeDepart"];

    $forfaitsOBJ->hotel = new stdClass();
    $forfaitsOBJ->hotel->nom = $forfaitsSQL["nom"];
    $forfaitsOBJ->hotel->coordonnees = $forfaitsSQL["coordonnees"];
    $forfaitsOBJ->hotel->nombreEtoiles = $forfaitsSQL["nombreEtoiles"];
    $forfaitsOBJ->hotel->nombreChambres = $forfaitsSQL["nombreChambres"];
    $forfaitsOBJ->hotel->caracteristiques = explode(";", $forfaitsSQL["caracteristiques"]);

    $forfaitsOBJ->dateDepart = $forfaitsSQL["dateDepart"];
    $forfaitsOBJ->dateRetour = $forfaitsSQL["dateRetour"];
    $forfaitsOBJ->prix = $forfaitsSQL["prix"];
    $forfaitsOBJ->rabais = $forfaitsSQL["rabais"];
    $forfaitsOBJ->vedette = $forfaitsSQL["vedette"];
    return $forfaitsOBJ;
}   
?>