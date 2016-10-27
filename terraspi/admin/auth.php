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

$sql = "SELECT loginadmin, mdpadmin FROM config";
    $retour = mysql_query($sql);
    if ($retour === FALSE) {
        echo "La requête SELECT a échoué.";
    } else {
        while ($enreg = mysql_fetch_array($retour)) {	            
            $loginadmin = $enreg["loginadmin"];
            $mdpadmin = $enreg["mdpadmin"];                    
        }
    }

// Fermer la connexion à MySQL
mysql_close($link);



  // Definition des constantes et variables
  define('LOGIN',$loginadmin);   
  define('PASSWORD',$mdpadmin); 
  $errorMessage = '';
 
  // Test de l'envoi du formulaire
  if(!empty($_POST)) 
  {
    // Les identifiants sont transmis ?
    if(!empty($_POST['login']) && !empty($_POST['password'])) 
    {
      // Sont-ils les mêmes que les constantes ?
      if($_POST['login'] !== LOGIN) 
      {
        $errorMessage = 'Mauvais login !';
      }
        elseif($_POST['password'] !== PASSWORD) 
      {  
        $errorMessage = 'Mauvais password !';
      }
        else
      {
        // On ouvre la session
        session_start();
        // On enregistre le login en session
        $_SESSION['login'] = LOGIN;
        // On redirige vers le fichier raspi.php
        header('Location: index.php');
        exit();
      }
    }
      else
    {
      $errorMessage = 'Veuillez inscrire vos identifiants svp !';
    }
  }
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>authentification</title>
  <link rel="stylesheet" href="auth.css">
  </head>
  <body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      
        <legend>Identifiez-vous</legend>
        <?php
          // Rencontre-t-on une erreur ?
          if(!empty($errorMessage)) 
          {
            echo '<p>', htmlspecialchars($errorMessage) ,'</p>';
          }
        ?>
       <p>
          <label for="login">Login :</label> 
          <input type="text" name="login" id="login" value="" />
        </p>
        <p>
          <label for="password">Password :</label> 
          <input type="password" name="password" id="password" value=""/> 
          <input type="submit" name="submit" value="Se logguer" />
        </p>
      
    </form>

<a href="../accueil/index.php" style="text-decoration:none" id="accueil" >Accueil</a>

  </body>
</html>

