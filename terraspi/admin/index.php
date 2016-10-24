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
$json = file_get_contents("/home/pi/terra/config.json");
$config = json_decode($json);
// on passe en variable php les champs qui nous intéressent
$ip = $config->{'ip'}->{'shellinabox'};
?>

<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>DIY Terrarium connecté Raspberry pi</title>
	<link rel="stylesheet" href="indexadmin.css">
	<script type="text/javascript" src="../lib/dateheure.js"></script>
	<script type="text/javascript" src="../lib/jquery.js"></script>
	
	<script type="text/javascript">
	var auto_refresh = setInterval(
	function ()
	{
		$('#loadavg').load('loadavg.php').fadeIn("fast");
		$('#cpu').load('Tempcpu.php').fadeIn("fast");
		$('#mem').load('mem.php').fadeIn("fast");    
	}, 1000); // rafraichis toutes les 10000 millisecondes
 
	var auto_refresh = setInterval(
	function ()
	{
		$('#bdd').load('bdd.php').fadeIn("fast");    
	}, 15000); // rafraichis toutes les 15000 millisecondes

	</script>
  
</head>
<body>

<header>
	
	<div class="element" class="d">
		<span id="date"></span>
		<script type="text/javascript">window.onload = date('date');</script>
	</div>   

	<div class="element" id="ephem"><?php require'../accueil/ephem.php';?></div>  

	<div class="element" class="h">
		<span id="heure"></span>
		<script type="text/javascript">window.onload = heure('heure');</script>
	</div>

</header>
 
 
<div id="content">
	
    <main>
		
		<h2>Terminal</h2>		
		<iframe id="shell" src="<?php echo 'http://'.$ip.':4200' ?>"></iframe>
    
    </main>
    
    
    <nav>
		
		<h2>Sites Web</h2>
		
        
		<p class="element" id="terrarium"><a href="../accueil/index.php" title="terrarium" style="text-decoration:none">Terrarium</a></p>		
		
		<p class="element" id="phpmyadmin"><a href="http://192.168.0.75/phpmyadmin/" target="_blank" title="PhpMyAdmin" style="text-decoration:none">PhpMyAdmin</a></p>
		
		<p class="element" id="nas" ><a href="https://192.168.0.2:13125/index.cgi " target="_blank" title="Nas" style="text-decoration:none">Nas</a></p>    
    
    </nav>
    
    
    <aside>
		
		<h2>PI monitor</h2>
    
		<div class="element" id="model"><?php require'model.php';?></div>
			
		<div class="element" id="cpu"><?php require'tempcpu.php';?></div>
		
		<div class="element" id="loadavg"><?php require'loadavg.php';?></div>
		
		<div class="element" id="mem"><?php require'mem.php';?></div>      
    
    </aside>
    
    
</div>

<footer> 

			
				
	<div class="element2">				
	<a href="../accueil/index.php" title="Accueil" style="text-decoration:none" target="_blank"><div id="accueil">Accueil</div></a>	
	</div>
	
	<div class="element2" ><div id="bdd"><?php require'bdd.php';?></div></div>
	
	<div class="element2" >
	<a href="logout.php" title="logout" style="text-decoration:none"><div id="logout">déconnexion</div></a>	
	</div>
	</div>
			

</footer>  
 
 </body>
 </html>



