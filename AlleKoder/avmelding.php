<?php 
include "funksjoner.inc.php";
include "topp.inc.php";
color();

$kursid = $_POST['kurs_id'];
$brukerid = $_POST['bruker_id'];
$kursnavn = $_POST['kursnavn'];
$brukernavn = $_SESSION['brukernavn'];

$db = kobleTil();

# Fjerner påmelding fra koblingstabellen. Kurset blir heller ikke synlig i tabelloversikten for aktuell bruker. 
$sqlDelete = "DELETE from kursstatus WHERE bruker_id = '$brukerid' AND kurs_id = '$kursid'";
$resultatDelete = $db->query($sqlDelete);
echo "<br>Du er nå avregistrert fra kurset: <b>" . $kursnavn . "</b>";
echo "<br> Kurset er også fjernet fra Din Kalender.<br><br>";
echo "<a href='minprofil.php'>Gå tilbake?</a>";

# Fjerner også kurset fra kalenderen, slik at den ikke inneholder kurs man ikke lenger er påmeldt (dynamisk).
$sqlKurs = "DELETE from calendar_event_master WHERE event_name = '$kursnavn' AND brukernavn = '$brukernavn'";
$resultatKurs = $db->query($sqlKurs);
?>