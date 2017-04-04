<?php

session_start();

$limit = $_SESSION['form']['limit']; 

if(empty($_SESSION['form']['limit']))
	{
	  $limit = 1440;	//(60min * 24 hr)
	}

    // on récupère les infos dans config.json
$json = file_get_contents("/var/www/html/terraspi/csv/bdd.json");
$config = json_decode($json);

// on passe en variable php les champs qui nous intéressent
$login = $config->{'mysql'}->{'loginmysql'};
$mdp = $config->{'mysql'}->{'mdpmysql'};

define('DB_HOST' , 'localhost');
define('DB_NAME' , 'Terrarium');
define('DB_USER' , "$login"); // votre login de la base de donnée
define('DB_PASS' , "$mdp"); // votre mdp
    
try {    
    $PDO = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);  
    
    $sql = 'SELECT COUNT(*) AS nb FROM capteurdata';
    $result = $PDO->query($sql);
    $columns = $result->fetch();
    $nb = $columns['nb'];
    
    $ligne = $nb - $limit;

	$ligne =(int)$ligne;
    $nb =(int)$nb;
    
	$reponse = $PDO->prepare('SELECT * FROM capteurdata LIMIT :ligne, :nb');
	$reponse->bindValue('ligne', $ligne, PDO::PARAM_INT);
	$reponse->bindValue('nb', $nb, PDO::PARAM_INT);
	$reponse->execute();
	
	$rows = array();
	$rows['name'] = 'dateandtime';
	$rows1 = array();
	$rows1['name'] = 'tempF';
	$rows2 = array();
	$rows2['name'] = 'humF';
	$rows3 = array();
	$rows3['name'] = 'tempC';
	$rows4 = array();
	$rows4['name'] = 'humC';
	
	while ($valeur = $reponse->fetch())
	{	
		$rows['data'][] = $valeur['dateandtime'];	
		$rows1['data'][] = $valeur['tempF'];
		$rows2['data'][] = $valeur['humF'];	
		$rows3['data'][] = $valeur['tempC'];		
		$rows4['data'][] = $valeur['humC'];					
	}
 
} catch(Exception $e) {
    echo "Impossible de se connecter à la base de données '".DB_NAME."' sur ".DB_HOST." avec le compte utilisateur '".DB_USER."'";
    echo "<br/>Erreur PDO : <i>".$e->getMessage()."</i>";
    die();
}

$result = array();
array_push($result,$rows);
array_push($result,$rows1);
array_push($result,$rows2);
array_push($result,$rows3);
array_push($result,$rows4);

// 6 - Afficher les résultats
print json_encode($result, JSON_NUMERIC_CHECK);

$reponse->closeCursor();
