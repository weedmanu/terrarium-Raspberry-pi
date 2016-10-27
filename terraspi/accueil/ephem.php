

<?php
$lines = file('../csv/ephem.csv');
foreach($lines as $cle=>$line) {
$line = trim($line);
$info[$cle] = split(',', $line); }

$am = $info[1][0];
$pm = $info[1][1];


    $heureAM = substr($am, 0, 1);
    $minAM = substr($am, 1, 2);
    $heurePM = substr($pm, 0, 2);
    $minPM = substr($pm, 2, 2);   

    
    echo "Le soleil se lévera à $heureAM H $minAM min et se couchera à $heurePM H $minPM min";

?>



