
<?php

 //On exécute la commande pour recup le modele
$model = exec(" cat /proc/cpuinfo | grep 'Revision' | awk '{print $3}' | sed 's/^1000//'");

if($model=="0010") { 

echo "PI 1 Model B+";
}
elseif($model=="a01041") {
    
echo "PI 2 Model B";
} 
elseif($model=="a22082") {
    
echo "PI 3 Model B";
} 
else {
    echo"";
}
?>

