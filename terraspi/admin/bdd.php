<?php

    // on récupère les infos dans config.json
$json = file_get_contents("/home/pi/terra/config.json");
$config = json_decode($json);

// on passe en variable php les champs qui nous intéressent
$login = $config->{'loginbdd'};
$mdp = $config->{'mdpbdd'};

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
$ef = $nb - 100;              // ne garde que 100 entrées si on purge , a modifier selon vos besoin

echo "il y a $nb entrées dans la base de donnée";

if($nb > 1000) //Si le nombre d'entrée est > a 1000
     {
          echo '<br>';
          echo 'Veux tu purger la base de donnée ? ';
          echo '<br>';
          echo '
<form method="post" action="raspi.php">
<input type="radio" name="reponse" value="oui">
Oui
<input type="radio" name="reponse" value="non">
Non
<input type="submit" value="Valider">
</form> </br>';

     }

    $reponse=$_POST['reponse'];

if($reponse=="oui") {
    // lancement de la requête pour effacer 
$sql ="DELETE from temperaturedata ORDER BY dateandtime ASC LIMIT $ef";

// on exécute la requête (mysql_query) et on affiche un message au cas où la requête ne se passait pas bien (or die)
mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());
echo "ok effacé ";


}
elseif($reponse=="non") {
echo "OK , on efface rien ";
echo '</br>';
echo '</br>';
} 
else {
    echo"";
}

// Fermer la connexion à MySQL
mysql_close($link);
?>


 






