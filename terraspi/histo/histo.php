<?php require'bdd.php';?>

<!DOCTYPE html> 
<head> 
		<meta charset="utf-8" /> 
        <title>historique</title> <!-- titre -->
        <link rel="icon" type="image/png" href="img/serpent.png" />
        <script type="text/javascript" src="../lib/jquery.js"></script> <!-- appel de la librairie jquery --> 
        <script src="../lib/highcharts.js"></script> <!-- appel de la librairie highcharts --> 
        <script src="../lib/gray.js"></script> <!-- appel du thème highcharts -->
        <script src="../lib/graph.js"></script> <!-- appel du 1er graphique highcharts -->
        <script src="../lib/dateheure.js"></script><!-- appel de la fonction dateheure -->
        <link rel="stylesheet" href="histo.css" /> <!-- appel du fichier qui s'occupe de la mise en page --> 
</head>

<body>

<header>    <!-- entête -->

<div class="conteneur">       
	 
	<div class="element" id="date"> <!-- contiendra la date -->
	
		<script type="text/javascript">window.onload = date('date');</script>
	
	</div>

	<div class="element" id="heure"> <!-- contiendra l'heure --> 
	
		<script type="text/javascript">window.onload = heure('heure');</script>	
	
	</div>  
	
</div>      

</header>
        
        
        
<section>	<!-- corps de page -->	
	
	<h1>Historique (données brutes)</h1>
						
	<div id="container"> <!-- contiendra le graphique -->

		<div class="loader">Loading...</div>
	
	</div> 
	
</section>
        
        
        
<footer>	<!-- pied de page -->
	
	<div class="conteneur">       

		<div class="element" id="serpent">
			<a href="../accueil/index.php" style="text-decoration:none"><span id="accueil">Accueil</span></a> <!--lien vers la page d'accueil-->
		</div> 

		<a href="<?php echo $histo;?>" style="text-decoration:none">
		<div class="element" id="bdd"><?php echo "Il y a $nb entrées dans la base de donnée";?></div> <!-- la bdd -->		
		</a>


		<div class="element" id="pc">
			<a href="../admin/index.php" style="text-decoration:none"><span id="admin">Admin</span></a><!--lien vers la page admin-->
		</div>            
			
	</div>									

</footer>
             
 

</body>
</html>


