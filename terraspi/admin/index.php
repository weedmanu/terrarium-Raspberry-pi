<?php
// On prolonge la session
session_start();
// On teste si la variable de session existe et contient une valeur
if(empty($_SESSION['login'])) 
{
  // Si inexistante ou nulle, on redirige vers le formulaire de login
  header('Location: auth.php');
  exit();
}

    // on récupère les infos dans config.json
$json = file_get_contents("/var/www/html/terraspi/csv/bdd.json");
$config = json_decode($json);

// on passe en variable php les champs qui nous intéressent
$login = $config->{'mysql'}->{'loginmysql'};
$mdp = $config->{'mysql'}->{'mdpmysql'};

// Connexion à MySQL
$link = mysql_connect( 'localhost', $login, $mdp ); // changer par votre password 
if ( !$link ) {
  die( 'Could not connect: ' . mysql_error() );
}

// Sélection de la base de données
$db = mysql_select_db( 'Terrarium', $link );
if ( !$db ) {
  die ( 'Error selecting database temperatures : ' . mysql_error() );
}
// Récupération des datas

$sql = "SELECT * FROM config";
    $retour = mysql_query($sql);
    if ($retour === FALSE) {
        echo "La requête SELECT a échoué.";
    } else {
        while ($enreg = mysql_fetch_array($retour)) {	            
            $ipdupi = $enreg["ip"];                               
        }
    }

// Fermer la connexion à MySQL
mysql_close($link);

?>

<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Admin</title>	
	<link href="indexadminOK.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../lib/dateheure.js"></script>
	<script type="text/javascript" src="../lib/jquery.js"></script>
	
	<script>
    $(document).ready(
            function() {
                setInterval(function() {
					$('#loadavg').load('loadavg.php').fadeIn("fast");
					$('#mem').load('mem.php').fadeIn("fast");	
					$('#bdd').load('bdd.php').fadeIn("fast"); 
					$('#cpu').load('tempcpu.php').fadeIn("fast");									                     
                }, 1500);
            });
	</script>
		
					
</head>
<body>

  <header>
  
  	<div class="element" class="d" id="date"><script type="text/javascript">window.onload = date('date');</script></div>   

	<div class="element" id="ephem"><?php require'../accueil/ephem.php';?></div>

	<div class="element" class="h" id="heure"><script type="text/javascript">window.onload = heure('heure');</script></div>
  
  </header>

  <div class="wrapper">
   <article>
   
   <h2>Terminal</h2>		
	<iframe id="shell" src="<?php echo 'http://'.$ipdupi.':4200' ;?>" ></iframe>
   
   </article>
   
    <nav><?php require'formulaire.php';?></nav>
    
    <aside>
    
    <h2>PI monitor</h2>
    
		<div class="element" id="model"><?php require'model.php';?></div>
			
		<div class="element" id="cpu"><?php require'tempcpu.php';?></div>
		
		<div class="element" id="loadavg"><?php require'loadavg.php';?></div>
		
		<div class="element" id="mem"><?php require'mem.php';?></div>      
		
		<div class="element" ><div id="bdd"><?php require'bdd.php';?></div></div>
    
    </aside>
  </div> <!-- /wrapper -->

  <footer>
  
  
  	<div class="element2">				
	<a href="../accueil/index.php" title="Accueil" style="text-decoration:none"><div id="accueil">Accueil</div></a>	
	</div>
	
	<p class="element2" id="phpmyadmin"><a href="<?php echo 'http://'.$ipdupi.'/phpmyadmin' ;?>" target="_blank" title="PhpMyAdmin" style="text-decoration:none">PhpMyAdmin</a></p>	
	
	<div class="element2" >
	<a href="logout.php" title="logout" style="text-decoration:none"><div id="logout">déconnexion</div></a>	
	</div>
	</div>
  
  </footer>
</body>

</html>
