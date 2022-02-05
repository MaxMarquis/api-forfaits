<?php 
  include_once '../include/config.php';

  header('Content-Type: application/json'); 
  header('Access-Control-Allow-Origin: *'); 

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
        if ($requete = $mysqli->prepare("SELECT * FROM reservations WHERE id = ?")) {
        $requete->bind_param("i", $_GET['id']);
        $requete->execute();

        $resultat_requete = $requete->get_result(); 
        $reservationsSQL = $resultat_requete->fetch_assoc();

        echo json_encode($reservationsSQL, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $requete->close();
        } 
      } else { 
        // CODE PERMETTANT DE RÉCUPÉRER TOUT LES ENREGISTREMENTS 
        $requete = $mysqli->query('SELECT * FROM reservations'); 
        $listeReservationsObj = [];

        while ($reservationsSQL = $requete->fetch_assoc()) {
          array_push($listeReservationsObj, $reservationsSQL);
        }

        echo json_encode($listeReservationsObj, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $requete->close();
      } 
      break; 
      default: 
      $reponse = new stdClass();
      $reponse->message = "Opération non supportée";  
      echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} 
$mysqli->close();
?>