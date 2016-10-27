<?php

//  Connexion à MySQL.
$link = mysql_connect( 'localhost', manu, terra );  
if ( !$link ) {
  die( 'Could not connect: ' . mysql_error() );
}

// Sélection de la base de données.
$db = mysql_select_db( 'Terrarium', $link );
if ( !$db ) {
  die ( 'Error selecting database Terrarium : ' . mysql_error() );
}


// Récupération des lignes.
$sth = mysql_query("SELECT dateandtime FROM capteurdata "); 
$rows = array();
$rows['name'] = 'dateandtime';
while($r = mysql_fetch_array($sth)) {
    $rows['data'][] = $r['dateandtime'];
}

$sth = mysql_query("SELECT tempC FROM capteurdata ");
$rows1 = array();
$rows1['name'] = 'tempC';
while($rr = mysql_fetch_array($sth)) {
    $rows1['data'][] = $rr['tempC'];
}

$sth = mysql_query("SELECT humC FROM capteurdata ");
$rows2 = array();
$rows2['name'] = 'humC';
while($rrr = mysql_fetch_assoc($sth)) {
    $rows2['data'][] = $rrr['humC'];
}

$sth = mysql_query("SELECT tempF FROM capteurdata ");
$rows3 = array();
$rows3['name'] = 'tempF';
while($rrrr = mysql_fetch_array($sth)) {
    $rows3['data'][] = $rrrr['tempF'];
}

$sth = mysql_query("SELECT humF FROM capteurdata ");
$rows4 = array();
$rows4['name'] = 'humF';
while($rrrrr = mysql_fetch_assoc($sth)) {
    $rows4['data'][] = $rrrrr['humF'];
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


