<!DOCTYPE html> 
<head> 
        <meta charset="utf-8" /> 
        <!-- titre -->
        <title>Terrarium</title>
         <!-- appel de la librairie jquery --> 
        <script type="text/javascript" src="../lib/jquery.js"></script>
         <!-- appel de la librairie Rgraph --> 
        <script src="../lib/RGraph.common.core.js"></script>
        <script src="../lib/RGraph.common.csv.js"></script>
        <script src="../lib/RGraph.gauge.js"></script>
        <!-- appel de la fonction date et heure javascript --> 
        <script type="text/javascript" src="../lib/dateheure.js"></script>
        <!-- appel du thème de la page --> 
        <link rel="stylesheet" href="index.css" /> 
        
<!-- fonction qui rafraîchi les jauges toute les 30 secondes -->      
<script type="text/javascript"> 
      
var auto_refresh = setInterval(
  function ()
  {
    $('#gauge').load('jauge.php').fadeIn("slow");
  }, 30000); // rafraichis toutes les minutes ,30000 millisecondes  
  
</script> 
    
</head>

<body>
    <header>    <!-- entête -->
        
        <div id="conteneur">   
            
            <!-- contiendra la date -->
            <div class="element" id="date">
                <span id="date"></span>
                <script type="text/javascript">window.onload = date('date');</script>
            </div>     
            
            <div class="element" id="heure">
                <span id="heure"></span>
                <script type="text/javascript">window.onload = heure('heure');</script>
            </div>
        </div>      
    </header>
    
    <!-- corps de page -->      
    <section>   
        
        <!-- contiendra les jauges -->
        <div id="conteneur1">  
            <div class="element" id="gauge">
                <?php require'jauge.php';?>
            </div> 
        </div>  
        
        <div id="ephem">
            <?php require'ephem.php';?>
        </div>
            
    </section>
        
        
    <!-- pied de page -->    
    <footer>
        
        <div id="conteneur2">
            
            <div class="element" id="pc">
                <a href="../admin/index.php" style="text-decoration:none"><span id="manage">Admin</span></a>
            </div>
            
            <div class="element" id="serpent">
                <a href="../histo/index.php" style="text-decoration:none"><span id="histo">Historique</span></a>
            </div>          
             
        </div>                                                  

    </footer>   

</body>




