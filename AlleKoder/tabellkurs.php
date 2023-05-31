<?php
include "funksjoner.inc.php";
include "topp.inc.php";
color();
echo "<hr>";
echo "<a href='kursliste.php'><b>Tilbake</a></b>&nbsp&nbsp<a href='utlopt.php'><b>Påmelding</a></b><br>";

$db = kobleTil();
$sqloversikt  = "SELECT * FROM kurs";
$resultatoversikt = $db->query($sqloversikt);
echo "<div class='content-tablekurs'>";
display_data($resultatoversikt);
echo "</div>";

?>