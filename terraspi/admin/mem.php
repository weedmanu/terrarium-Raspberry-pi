
<?php
$mem = exec ('free -tm');



$Total = substr($mem, 14, 5);
$Use = substr($mem, 25, 5);
$Free = substr($mem, 36, 5);

echo 'Mémoire</br>';
echo "</br>Total:  $Total MB";
echo "</br>Use:    $Use MB";
echo "</br>Free:   $Free MB";

?>

