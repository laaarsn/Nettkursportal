<?php

include "funksjoner.inc.php";
include "topp.inc.php";
include "admin.inc.php";
color();
$db = kobleTil();

$kursid = $_POST['id'];
$kursnavn = $_POST['kursnavn'];

# Deaktiverte kurs vil ikke vises i kursoversikt. Er også umulig å melde seg på et deaktivert kurs ved å skrive inn tilhørende kurs_id. 
$sqlDeactivate = "UPDATE kurs SET status = 'inaktiv' where kurs_id = '$kursid';";
$resultat = $db->query($sqlDeactivate);
echo "Du har nå deaktivert kurset: <b>" . "$kursnavn" . "</b>";
echo ""
?>

<a href='kursliste.php'><h4>Tilbake til Kursoversikt</h4></a>