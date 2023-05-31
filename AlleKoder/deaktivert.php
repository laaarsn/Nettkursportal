
<?php
include "funksjoner.inc.php";
include "topp.inc.php"; // side krever innlogging. 
include "admin.inc.php"; // side kun tilgjengelig for admin-bruker ('lars').
color();
$db = kobleTil();

$sql = "SELECT * from kurs where status = 'inaktiv';";
$resultat = $db->query($sql);
#$array = $resultat->fetch_assoc();

# Sjekker om det finnes deaktiverte kurs. Hvis ikke gis det beskjed til admin.
$sum = "SELECT * from kurs where status = 'inaktiv'";
$resultatSum = $db->query($sum);
$resultatAktiv = $db->query($sum); // SQL-spørringen legges til to ulike resultatvariabler, hvis ikke blir innholdet i array automatisk tomt i while-loopen lenger ned, siden innhold hentes ut. 
$assoc = $resultatSum->fetch_assoc();

if (empty($assoc['kursnavn'])) {
    echo "<b> Det finnes ingen deaktiverte kurs.";
} else {
    while($nesteRad = $resultatAktiv->fetch_assoc()){
        echo "<form action='aktiver_kurs.php' method='post'>";
        echo "<b>Deaktiverte kurs:</b><br>";
        echo "KursID <b>: " . $nesteRad['kurs_id'] . "</b>" . " <input type='submit' name='button' value='Aktiver kurs'<br>";
        $idkurs = $nesteRad['kurs_id'];
        $kursnavn = $nesteRad['kursnavn'];
        echo "<input type='hidden' name='id' value=$idkurs>";
        echo "<input type='hidden' name='kursnavn' value=$kursnavn>";
        echo "<br>Kursnavn<b>: " . $nesteRad['kursnavn'] . "</b>";
        echo "<br>Pris:<b> " . $nesteRad['pris'] . "</b>";
        echo "<br>Påmeldingsfrist<b>: " . $nesteRad['dato'] . "</b>";
        echo "<br>Maks antall deltakere<b>: " . $nesteRad['maksantall'] . "</b>";
        echo "</form>";
        echo "<hr />";
    }
}
?>

<a href='kursliste.php'><h4>Tilbake til Kursoversikt</h4></a>
