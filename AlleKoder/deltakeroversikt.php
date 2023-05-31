<?php 
include "funksjoner.inc.php";
include "topp.inc.php";
color();
$db = kobleTil();

echo "<hr />";

# Lengde i for-loop for kurs
$kurslength = "SELECT COUNT(*) FROM kurs";
$resultatlength = $db->query($kurslength);
$len = mysqli_fetch_array($resultatlength)[0];

# Lengde i nested for-loop deltakere
$deltakerlength = "SELECT COUNT(*) from kursstatus";
$resultatldeltakerlength = $db->query($deltakerlength);
$len2 = mysqli_fetch_array($resultatldeltakerlength)[0];

# Lengde på antall brukere
$brukerelength = "SELECT COUNT(*) FROM brukere";
$resultatbrukerlength = $db->query($brukerelength);
$len3 = mysqli_fetch_array($resultatbrukerlength)[0];

$sqlkurs  = "SELECT * FROM kurs";
$resultat = $db->query($sqlkurs);



#
#for ($i = 1; $i <= $len; $i++) {
#    $sqlkurscount = "SELECT * from kurs WHERE kurs_id LIKE $i";
#    $resultatcount = $db->query($sqlkurscount);
#    $kurs = $resultatcount->fetch_assoc();
#    echo "<br><b>Kursnavn: " . $kurs['kursnavn'] . "</b>";
#    for ($j = 1; $j <=$len2; $j++) {
#        #$sqldeltaker  = "SELECT * FROM kursstatus WHERE status_id LIKE $j";
#        $sqldeltaker  = "SELECT * from kursstatus";
#        $resultatdeltaker = $db->query($sqldeltaker);
#        $deltakere = $resultatdeltaker->fetch_assoc();
#        
#        # Henter navn fra bruker-tabellen
#        $sqlpersonalia = "SELECT * from brukere WHERE bruker_id LIKE $j";
#        $resultatpersonalia = $db->query($sqlpersonalia);
#        $personalia = $resultatpersonalia->fetch_assoc();
#        if ($kurs['kurs_id'] == $deltakere['kurs_id']) {
#            echo "<br> Påmeldte deltakere: " . $deltakere['brukernavn'];
#        } 
#    }
#   
#}
$sqlkurscount = "SELECT * from kurs";
$resultatcount = $db->query($sqlkurscount);

$sqlkurscount2 = "SELECT * from kursstatus";
$resultatcount2 = $db->query($sqlkurscount2);
#$nesteRow = $resultatcount2->fetch_assoc();


$sqlkurscount3 = "SELECT kursnavn,brukernavn from kursstatus";
$resultatcount3 = $db->query($sqlkurscount3);

echo "<div class='content-table'>";
display_data($resultatcount3);
echo "</div>"
?>
<title> Deltakeroversikt </title>
<style>
.kursposition {
    position: relative;
    bottom: 180px;
}

</style>
<?php
while ($nesteRow = $resultatcount2->fetch_assoc()) {
    echo "<div class='kursposition'>";
    #echo "<b>Kurs-navn: " . $nesteRow['kursnavn'] . "</b><br>";
    $kursnavn = $nesteRow['kursnavn'];
    $sqltwin = "SELECT * from kurs where kursnavn = '$kursnavn'";
    $resultattwin = $db->query($sqltwin);
    $nesteRad = $resultattwin->fetch_assoc();
    echo "Kurs-navn: <b> " . $nesteRow['kursnavn'] . "</b><br>";
    echo "Kursdeltaker: " . $nesteRow['brukernavn'] . "</br>";
    echo "</div>";
}   
?>