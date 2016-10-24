
<?php
$loadavg = exec ('python loadavg.py'); 

$uneminute = substr($loadavg, 2, 4);
$cinqminute = substr($loadavg, 10, 4);
$quinzeminute = substr($loadavg, 18, 4);

echo 'Charge CPU </br>';

echo "</br>1mn:  $uneminute";
echo "</br>5mn:  $cinqminute";
echo "</br>15mn: $quinzeminute";
?>

