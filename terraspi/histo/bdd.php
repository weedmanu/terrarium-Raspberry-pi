<?php

    // on récupère les infos dans config.json
$json = file_get_contents("/var/www/html/terraspi/csv/bdd.json");
$config = json_decode($json);

// on passe en variable php les champs qui nous intéressent
$login = $config->{'mysql'}->{'loginmysql'};
$mdp = $config->{'mysql'}->{'mdpmysql'};

//  Connexion à MySQL
$link = mysql_connect( 'localhost', $login, $mdp ); // changer par votre password 
if ( !$link ) {
  die( 'Could not connect: ' . mysql_error() );
}

// Sélection de la base de données
$db = mysql_select_db( 'Terrarium', $link );
if ( !$db ) {
  die ( 'Error selecting database Terrarium : ' . mysql_error() );
}

//  Récupération du nombre de lignes contenu dans la table
$rqut_nb ="SELECT COUNT( dateandtime ) as recuperation FROM capteurdata ;";
$rslt_nb = mysql_query( $rqut_nb) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());  
$data_nb = mysql_fetch_array($rslt_nb);
$nb = ''.$data_nb['recuperation'].'';
    
// Fermer la connexion à MySQL
mysql_close($link);

if($nb < 1440) //Si le nombre d'entrée est >24h
	{
		$histo = "../histo/histo.php";
	}	else {
			$histo = "../histoselect/histo.php";
			}
			
?>