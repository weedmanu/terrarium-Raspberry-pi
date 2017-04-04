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


// Récupération des lignes.
$sth = mysql_query("SELECT * FROM capteurdata "); 

$rows = array();
$rows1 = array();
$rows2 = array();
$rows3 = array();
$rows4 = array();

$rows['name'] = 'dateandtime';
$rows1['name'] = 'tempF';
$rows2['name'] = 'humF';
$rows3['name'] = 'tempC';
$rows4['name'] = 'humC';

while($r = mysql_fetch_array($sth)) {
    $rows['data'][] = $r['dateandtime'];
    $rows1['data'][] = $r['tempF'];
    $rows2['data'][] = $r['humF'];
    $rows3['data'][] = $r['tempC'];
    $rows4['data'][] = $r['humC'];    
}

$result = array();

array_push($result,$rows);
array_push($result,$rows1);
array_push($result,$rows2);
array_push($result,$rows3);
array_push($result,$rows4);

//  Afficher les résultats
print json_encode($result, JSON_NUMERIC_CHECK);

// Fermer la connexion à MySQL
mysql_close($link);
?>
