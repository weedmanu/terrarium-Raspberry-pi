
<?php

	// on récupère les infos dans config.json
$json = file_get_contents("/home/pi/terra/config.json");
$config = json_decode($json);

// on passe en variable php les champs qui nous intéressent
$warning = $config->{'raspberry'}->{'warning'};


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
 if ($temppi < $warning)
  echo $ok ;
 else
  echo $wrong ;


?>

