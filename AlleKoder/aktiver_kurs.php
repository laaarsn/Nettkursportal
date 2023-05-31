<?php
include "funksjoner.inc.php"; 
include "topp.inc.php"; // side krever innlogging. 
include "admin.inc.php"; // side kun tilgjengelig for admin-bruker ('lars').
color();
$db = kobleTil(); 

$kursid = $_POST['id'];
$kursnavn = $_POST['kursnavn'];

$sqlActivate = "UPDATE kurs SET status = 'aktiv' where kurs_id = '$kursid';";
$resultat = $db->query($sqlActivate);
echo "Du har nå aktivert kurset: <b>" . "$kursnavn" . "</b>";
echo "";
?>

<a href='kursliste.php'><h4>Tilbake til Kursoversikt</h4></a>

