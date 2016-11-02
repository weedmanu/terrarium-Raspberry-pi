<?php

$dateetheure = date("Y-m-d-H:i");

Print("Nous sommes le $dateetheure <br/>");  

$lon = htmlspecialchars($_POST['lon']);
$lat = htmlspecialchars($_POST['lat']);
$alt = htmlspecialchars($_POST['alt']);
$jour = htmlspecialchars($_POST['jour']);
$nuit = htmlspecialchars($_POST['nuit']);
$limitebasse = htmlspecialchars($_POST['limitebasse']);
$limitehaute = htmlspecialchars($_POST['limitehaute']);
$warmpi = htmlspecialchars($_POST['warmpi']);
$envoyeur = htmlspecialchars($_POST['envoyeur']);
$mdpenvoyeur = htmlspecialchars($_POST['mdpenvoyeur']);
$receveur = htmlspecialchars($_POST['receveur']);
$loginadmin = htmlspecialchars($_POST['loginadmin']);
$mdpadmin = htmlspecialchars($_POST['mdpadmin']);
$ipdupi = htmlspecialchars($_POST['ipdupi']);
$HeureEH = htmlspecialchars($_POST['HeureEteHiver']);


// Connexion à MySQL
$link = mysql_connect( 'localhost', 'root', 'bob' ); // changer par votre password 
if ( !$link ) {
  die( 'Could not connect: ' . mysql_error() );
}

// Sélection de la base de données
$db = mysql_select_db( 'Terrarium', $link );
if ( !$db ) {
  die ( 'Error selecting database temperatures : ' . mysql_error() );
}

mysql_query("insert into config ( dateetheure, loginadmin, mdpadmin, longitude, latitude, altitude, limitebasse, limitehaute, jour, nuit, warmpi, envoyeur, mdpenvoyeur, receveur, ip, Heure_ete_hiver)
 values 
 ( '$dateetheure' , '$loginadmin' , '$mdpadmin' , '$lon' , '$lat' , '$alt' , '$limitebasse' , '$limitehaute' , '$jour' , '$nuit' , '$warmpi' , '$envoyeur' , '$mdpenvoyeur' , '$receveur', '$ipdupi', '$HeureEH');");

echo "Vos parametre on bien été prise encompte :<br/>";	
		
  
echo "<p>
	$lon <br/>
	$lat <br/>
	$alt <br/>
	$jour <br/>
	$nuit <br/>
	$limitebasse <br/>
	$limitehaute <br/>
	$warmpi <br/>
	$envoyeur <br/>
	$mdpenvoyeur <br/>
	$receveur <br/>
	$loginadmin <br/>
	$mdpadmin <br/>	
	$ipdupi <br/>
	$HeureEH
	</p>
	";

$rqut_nb ="SELECT COUNT( dateetheure ) as recuperation FROM config ;";
$rslt_nb = mysql_query( $rqut_nb) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());  
$data_nb = mysql_fetch_array($rslt_nb);
$nb = ''.$data_nb['recuperation'].'';
$ef = $nb - 1; 

$sql ="DELETE from config ORDER BY dateetheure ASC LIMIT $ef";

// on exécute la requête (mysql_query) et on affiche un message au cas où la requête ne se passait pas bien (or die)
mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());

// Fermer la connexion à MySQL
mysql_close($link);      

   
$delai=1; // le nombre de secondes
$url='index.php'; // ton url
header("Refresh: $delai;url=$url");
    
    
 ?>
       

