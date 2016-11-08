<?php

    // on récupère les infos dans config.json
$json = file_get_contents("/var/www/html/terraspi/csv/bdd.json");
$config = json_decode($json);

// on passe en variable php les champs qui nous intéressent
$login = $config->{'mysql'}->{'loginmysql'};
$mdp = $config->{'mysql'}->{'mdpmysql'};

//  Connexion à MySQL.
$link = mysql_connect( 'localhost', $login, $mdp );  
if ( !$link ) {
  die( 'Could not connect: ' . mysql_error() );
}
// Sélection de la base de données.
$db = mysql_select_db( 'Terrarium', $link );
if ( !$db ) {
  die ( 'Error selecting database Terrarium : ' . mysql_error() );
}
// Récupération des datas
$sql = "SELECT * FROM config";
    $retour = mysql_query($sql);
    if ($retour === FALSE) {
        echo "La requête SELECT a échoué.";
    } else {
        while ($result = mysql_fetch_array($retour)) {	                    
            $lon = $result["longitude"];
			$lat = $result["latitude"];
			$alt = $result["altitude"];
			$jour = $result["jour"];
			$nuit = $result["nuit"];
			$limitebasse = $result["limitebasse"];
			$limitehaute = $result["limitehaute"];
			$warmpi = $result["warmpi"];
			$envoyeur = $result["envoyeur"];
			$mdpenvoyeur = $result["mdpenvoyeur"];
			$receveur = $result["receveur"];
			$loginadmin = $result["loginadmin"];
			$mdpadmin = $result["mdpadmin"]; 
			$ipdupi = $result["ip"];						           
        }
    }    
 // Fermer la connexion à MySQL
mysql_close($link);
?>


<form method="post" action="traitement.php" id="form" >
		
	   <legend>Heure été / hiver</legend>	   
	   <input type="radio" name="HeureEteHiver"  id="HeureEte" value="200" /> <label for="HeureEte">été</label>	  
	   <input type="radio" name="HeureEteHiver" id="HeureHiver" value="100" checked/> <label for="HeureHiver">hiver</label>	   
		
	   <legend>position</legend>		
       <label for="lon">longitude:</label>
       <input type="text" name="lon" id="lon"  value="<?php echo $lon ?>"/><br/>
       <label for="alt">latitude:</label>
       <input type="text" name="lat" id="lat" value="<?php echo $lat ?>"/><br/>
       <label for="alt">altitude:</label>
       <input type="number" name="alt" id="alt" value="<?php echo $alt ?>"/><br/>

	   <legend>consigne</legend>
       <label for="jour">jour:</label>
       <input type="number" name="jour" id="jour" value="<?php echo $jour ?>" /> <br/>
       <label for="nuit">nuit:</label>
       <input type="number" name="nuit" id="nuit" value="<?php echo $nuit ?>" /> 

	   <legend>warning terrarium</legend>       
       <label for="limitebasse">limite basse:</label>
       <input type="number" name="limitebasse" id="limitebasse" value="<?php echo $limitebasse ?>" /> <br/>  
       <label for="limitehaute">limite haute:</label>
       <input type="number" name="limitehaute" id="limitehaute" value="<?php echo $limitehaute ?>" /><br/>  

   
	    <legend>mail</legend>      
		<label for="envoyeur">envoyeur: <em>(gmail obligatoire)</em></label><br/>
		<input type="mail" name="envoyeur" id="envoyeur" value="<?php echo $envoyeur ?>" /> <br/>
		<label for="mddpenvoyeur">mot de passe:</label><br/>
		<input type="password" name="mdpenvoyeur" id="mdpenvoyeur" value="<?php echo $mdpenvoyeur ?>" /> <br/>
		<label for="receveur">receveur: <em>(gmail Non obligatoire)</em></label><br/>
		<input type="mail" name="receveur" id="receveur" value="<?php echo $receveur ?>" /> 

	    <legend>warning Raspberry</legend>
        <label for="warmpi">warning pi</label>
        <input type="number" name="warmpi" id="warmpi" value="<?php echo $warmpi ?>" /> <br>   
        <label for="ipdupi">ip du pi</label>   
        <input type="text" name="ipdupi" id="ipdupi" value="<?php echo $ipdupi ?>" />      
       
	    <legend>admin</legend>
        <label for="loginadmin">login:</label>
        <input type="text" name="loginadmin" id="loginadmin" value="<?php echo $loginadmin ?>" /> <br/>
        <label for="mdpadmin">mot de passe:</label>
        <input type="password" name="mdpadmin" id="mdpadmin" value="<?php echo $mdpadmin ?>" /> <br/>         
	    <br/>

	<script type="text/javascript" language="javascript">
function Confirmation()
{
if (confirm("Etes-vous sûr de vouloir valider?")) {
this.form.submit();

}

}

</script>
	<input type="submit" name="valider" value="valider" class="bouton" OnClick="return confirm('Etes-vous sûr de vouloir valider?')" />
</form>
