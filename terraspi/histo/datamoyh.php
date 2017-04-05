<?php

session_start();

$limit2 = $_SESSION['form']['limit']; 

if(empty($limit2))
		{
		  $limit2 = 1440;		    
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

	if($nb < $limit2)
	{
		$limit2 = $nb;
	}

	$limit = ($limit2 / 60);
	
	$reponse = $PDO->query("SELECT DATE_FORMAT(dateandtime,'%d-%m-%Y %H') as moyheure FROM capteurdata WHERE dateandtime < NOW() AND dateandtime > DATE_SUB(NOW(), INTERVAL $limit HOUR) GROUP BY MONTH(dateandtime), DAY(dateandtime), HOUR(dateandtime)");	
	$rows = array();
	$rows['name'] = 'moyheure';
	while ($donnees = $reponse->fetch())
	{	
		$rows['data'][] = $donnees['moyheure'];		
	}	
	
	$reponse = $PDO->query('SELECT ROUND(AVG(tempF),2) as tempF FROM capteurdata WHERE dateandtime < NOW() AND dateandtime > DATE_SUB(NOW(), INTERVAL '.$limit.' HOUR) GROUP BY MONTH(dateandtime), DAY(dateandtime), HOUR(dateandtime)');	
	$rows1 = array();
	$rows1['name'] = 'tempF';
	while ($donnees = $reponse->fetch())
	{	
		$rows1['data'][] = $donnees['tempF'];		
	}
	
	$reponse = $PDO->query('SELECT ROUND(AVG(humF),2) as humF FROM capteurdata WHERE dateandtime < NOW() AND dateandtime > DATE_SUB(NOW(), INTERVAL '.$limit.' HOUR) GROUP BY MONTH(dateandtime), DAY(dateandtime), HOUR(dateandtime)');	
	$rows2 = array();
	$rows2['name'] = 'humF';
	while ($donnees = $reponse->fetch())
	{	
		$rows2['data'][] = $donnees['humF'];		
	}
	
	$reponse = $PDO->query('SELECT ROUND(AVG(tempC),2) as tempC FROM capteurdata WHERE dateandtime < NOW() AND dateandtime > DATE_SUB(NOW(), INTERVAL '.$limit.' HOUR) GROUP BY MONTH(dateandtime), DAY(dateandtime), HOUR(dateandtime)');	
	$rows3 = array();
	$rows3['name'] = 'tempC';
	while ($donnees = $reponse->fetch())
	{	
		$rows3['data'][] = $donnees['tempC'];		
	}
	
	$reponse = $PDO->query('SELECT ROUND(AVG(tempF),2) as tempF FROM capteurdata WHERE dateandtime < NOW() AND dateandtime > DATE_SUB(NOW(), INTERVAL '.$limit.' HOUR) GROUP BY MONTH(dateandtime), DAY(dateandtime), HOUR(dateandtime)');	
	$rows4 = array();
	$rows4['name'] = 'tempF';
	while ($donnees = $reponse->fetch())
	{	
		$rows4['data'][] = $donnees['tempF'];		
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

?>



