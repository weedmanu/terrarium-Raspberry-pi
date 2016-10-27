<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Histozoom</title> <!-- titre --> 
        <script type="text/javascript" src="../lib/jquery.js"></script> <!-- appel de la librairie jquery --> 
        <script src="../lib/highcharts.js"></script> <!-- appel de la librairie highcharts --> 
        <script src="../lib/graphtemp.js"></script> <!-- appel du 1er graphique highcharts -->
        <script src="../lib/graphhum.js"></script> <!-- appel du 2eme graphique highcharts -->
        <script src="../lib/gray.js"></script> <!-- appel du thème highcharts -->
        <link rel="stylesheet" href="indexhisto.css" /> <!-- appel du fichier qui s'occupe de la mise en page -->    
</head>


<body>

<div id="container"></div> <!-- contiendra le 1er graphique -->


<div id="conteneur"> <!-- contiendra les liens des autres pages-->

    <div class="element" id="pc"><a href="../admin/index.php" style="text-decoration:none"><span id="manage">admin</span></a></div>

    <div class="element" id="serpent"><a href="../accueil/index.php" style="text-decoration:none"><span id="histo">Accueil</span></a></div>

</div>


<div id="container2"></div> <!-- contiendra le 2eme graphique -->


</body>

</html>



