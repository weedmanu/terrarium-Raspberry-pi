<?php
//  Connexion à MySQL.
$link = mysql_connect( 'localhost', 'root', 'bob' );  
if ( !$link ) {
  die( 'Could not connect: ' . mysql_error() );
}
// Sélection de la base de données.
$db = mysql_select_db( 'Terrarium', $link );
if ( !$db ) {
  die ( 'Error selecting database Terrarium : ' . mysql_error() );
}
// Récupération des datas
$sql = "SELECT warmpi FROM config";
    $retour = mysql_query($sql);
    if ($retour === FALSE) {
        echo "La requête SELECT a échoué.";
    } else {
        while ($enreg = mysql_fetch_array($retour)) {	            
            $warmpi = $enreg["warmpi"];                   
        }
    }
// Fermer la connexion à MySQL
mysql_close($link);

 //On exécute la commande de récupérage (si si) de température
 $temp = exec('cat /sys/class/thermal/thermal_zone0/temp');
 //On divise par 1000 pour convertir
 $tempconv  =  $temp / 1000;
 //Un chiffre après la virgule ça suffit
 $temppi = round($tempconv,1);
 //On définit les variables d'affichage dans la condition suivante en y affichant la température
 $ok = '<link href="indexadminOK.css" media="all" rel="stylesheet" type="text/css" />'. $temppi .'°C ';
 $wrong = '<link href="indexadminKO.css" media="all" rel="stylesheet" type="text/css" />'. $temppi .'°C ';
 //Si la température < 65°C alors on affiche en vert, sinon en rouge
 echo 'Temp CPU</br>';
 if ($temppi < $warmpi)
  echo $ok ;
 else
  echo $wrong ;


?>
