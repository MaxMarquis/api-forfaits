<?php 
  include_once '../include/config.php';
  include_once '../include/fonction.php';

  header('Content-Type: application/json'); 
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST, DELETE, PUT, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type'); 

  $mysqli = new mysqli($host, $username, $password, $database);
  if ($mysqli -> connect_errno) {	
    echo 'Échec de connexion à la base de données MySQL: ' . $mysqli -> connect_error; 
    exit(); 
  } 
  switch($_SERVER['REQUEST_METHOD']) 
  { 
    case 'GET': // GESTION DES DEMANDES DE TYPE GET 
      if(isset($_GET['id'])) { 
        // CODE PERMETTANT DE RÉCUPÉRER L'ENREGISTREMENT CORRESPONDANT À L'IDENTIFIANT PASSÉ EN PARAMÈTRE
        if ($requete = $mysqli->prepare("SELECT * FROM forfaits WHERE id = ?")) {
        $requete->bind_param("i", $_GET['id']);
        $requete->execute();

        $resultat_requete = $requete->get_result(); 
        $forfaitsSQL = $resultat_requete->fetch_assoc();

        // Convesion de l'objet au format JSON désiré
        $forfaitsOBJ = ConversionForfaitSQLEnObjet($forfaitsSQL);

        echo json_encode($forfaitsOBJ, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $requete->close();
        } 
      } else { 
        // CODE PERMETTANT DE RÉCUPÉRER TOUT LES ENREGISTREMENTS 
        $requete = $mysqli->query('SELECT * FROM forfaits'); 
        $listeForfaitsObj = [];

        while ($forfaitsSQL = $requete->fetch_assoc()) {
          $forfaitsOBJ = ConversionForfaitSQLEnObjet($forfaitsSQL);
          array_push($listeForfaitsObj, $forfaitsOBJ);
        }

        echo json_encode($listeForfaitsObj, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $requete->close();
      } 
      break; 
    case 'POST':  // GESTION DES DEMANDES DE TYPE POST
      $reponse = new stdClass();
      $reponse->message = "Ajout d'un forfait voyage: ";
      
      $corpsJSON = file_get_contents('php://input');
      $data = json_decode($corpsJSON, TRUE); 
    
      $destination = $data['destination'];
      $villeDepart = $data['villeDepart'];

      $nom = $data['hotel']['nom'];
      $coordonnees = $data['hotel']['coordonnees'];
      $nombreEtoiles = $data['hotel']['nombreEtoiles'];
      $nombreChambres = $data['hotel']['nombreChambres'];
      $caracteristiques_str = $data['hotel']['caracteristiques'];

      $dateDepart = $data['dateDepart'];
      $dateRetour = $data['dateRetour'];
      $prix = $data['prix'];
      $rabais = $data['rabais'];
      $vedette = $data['vedette'];
    
      if(isset($destination) && isset($villeDepart) && isset($nom) && isset($coordonnees) && isset($nombreEtoiles) && isset($nombreChambres) && isset($caracteristiques_str) && isset($dateDepart) && isset($dateRetour) && isset($prix) && isset($rabais) && isset($vedette)) {
        $caracteristiques = implode(';', $caracteristiques_str);
        
        if ($requete = $mysqli->prepare("INSERT INTO forfaits (destination, villeDepart, nom, coordonnees, nombreEtoiles, nombreChambres, caracteristiques, dateDepart, dateRetour, prix, rabais, vedette) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);")) {      
          $requete->bind_param("ssssiisssiii", $destination, $villeDepart, $nom, $coordonnees, $nombreEtoiles, $nombreChambres, $caracteristiques, $dateDepart, $dateRetour, $prix, $rabais, $vedette);
    
            if($requete->execute()) { 
              $reponse->message .= "Ajout terminé avec succès";  
            } else {
              $reponse->message .=  "Erreur dans l'exécution de la requête";  
            }
    
            $requete->close(); 
          } else  {
            $reponse->message .=  "Erreur dans la préparation de la requête";  
          } 
        } else {
        $reponse->message .=  "Erreur dans le corps de l'objet fourni";  
      }
      echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      
      break;
    case 'PUT': // GESTION DES DEMANDES DE TYPE PUT 
      // CODE PERMETTANT DE METTRE À JOUR L'ENREGISTREMENT CORRESPONDANT À L'IDENTIFIANT PASSÉ EN PARAMÈTRE 
      $reponse = new stdClass();
      $reponse->message = "Édition d'un forfait voyage: ";
      
      $corpsJSON = file_get_contents('php://input');
      $data = json_decode($corpsJSON, TRUE); 
    
      $destination = $data['destination'];
      $villeDepart = $data['villeDepart'];

      $nom = $data['hotel']['nom'];
      $coordonnees = $data['hotel']['coordonnees'];
      $nombreEtoiles = $data['hotel']['nombreEtoiles'];
      $nombreChambres = $data['hotel']['nombreChambres'];
      $caracteristiques_str = $data['hotel']['caracteristiques'];

      $dateDepart = $data['dateDepart'];
      $dateRetour = $data['dateRetour'];
      $prix = $data['prix'];
      $rabais = $data['rabais'];
      $vedette = $data['vedette'];
    
      if(isset($_GET['id'])) { 
        if(isset($destination) && isset($villeDepart) && isset($nom) && isset($coordonnees) && isset($nombreEtoiles) && isset($nombreChambres) && isset($caracteristiques_str) && isset($dateDepart) && isset($dateRetour) && isset($prix) && isset($rabais) && isset($vedette)) {
        $caracteristiques = implode(';', $caracteristiques_str);
        
        if ($requete = $mysqli->prepare("UPDATE forfaits SET destination=?, villeDepart=?, nom=?, coordonnees=?, nombreEtoiles=?, nombreChambres=?, caracteristiques=?, dateDepart=?, dateRetour=?, prix=?, rabais=?, vedette=? WHERE id=?")) {      
          $requete->bind_param("ssssiisssiiii", $destination, $villeDepart, $nom, $coordonnees, $nombreEtoiles, $nombreChambres, $caracteristiques, $dateDepart, $dateRetour, $prix, $rabais, $vedette, $_GET['id']);
            if($requete->execute()) { 
              $reponse->message .= "Édition terminé avec succès"; 
            } else { 
              $reponse->message .= "Erreur dans l'exécution de la requête"; 
            } 
            $requete->close();
          } else { 
            $reponse->message .= "Erreur dans la préparation de la requête"; 
          } 
        } else { 
          $reponse->message .= "Erreur dans le corps de l'objet fourni"; 
        } 
      } else { 
        $reponse->message .= "Erreur dans les paramètres (aucun identifiant fourni)"; 
      } 
      echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      break; 
    case 'DELETE': // GESTION DES DEMANDES DE TYPE DELETE 
      $reponse = new stdClass(); 
      $reponse->message = "Suppression du forfait: ";

      if(isset($_GET['id'])) { 
        // CODE PERMETTANT DE SUPPRIMER L'ENREGISTREMENT CORRESPONDANT À L'IDENTIFIANT PASSÉ EN PARAMÈTRE 
        if ($requete = $mysqli->prepare("DELETE FROM forfaits WHERE id=?")) { 
          $requete->bind_param("i", $_GET['id']); 
          if($requete->execute()) { 
            $reponse->message .= "Suppression terminé avec succès"; 
          } else { 
            $reponse->message .= "Erreur dans l'exécution de la requête"; 
          } 
          $requete->close(); 
        } else { 
          $reponse->message .= "Erreur dans la préparation de la requête"; 
        } 
      } else { 
        $reponse->message .= "Erreur dans les paramètres (aucun identifiant fourni)"; 
      } 
      echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      break;
    default: 
      $reponse = new stdClass();
      $reponse->message = "Opération non supportée";	
      echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} 
$mysqli->close();
?>