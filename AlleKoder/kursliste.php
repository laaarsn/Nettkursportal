<head><title>Status for kurs</title>
</head>

<?php
include "funksjoner.inc.php";
include "topp.inc.php"; // side krever innlogging. 
include "admin.inc.php"; // side kun tilgjengelig for admin-bruker ('lars').
?>

<?php
color();

$db = kobleTil(); // trenger ikke oppgi databasenavn da denne er standardparameter i funksjonsfilen.
$sql  = "SELECT * FROM kurs";
$resultat = $db->query($sql);
echo "<hr />";
echo "<link rel='stylesheet' type='text/css' href='styling.css'>";
echo "<a href='tabellkurs.php'><b>Se kursliste i tabellform?</a></b><br>";
echo "<a href='graph2.php'><b>Se grafisk fremstilling av inntekt?</a></b><br>";
echo "<a href='deaktivert.php'><b>Vis deaktiverte kurs</a></b><br>";
echo "<br>";

############################################

$sqldyr  = "SELECT MAX(pris) FROM kurs";
$resultatdyr = $db->query($sqldyr);
$prisdyr = mysqli_fetch_array($resultatdyr)[0];
$sqlbillig  = "SELECT MIN(pris) FROM kurs";
$resultatbillig = $db->query($sqlbillig);
$prisbillig = mysqli_fetch_array($resultatbillig)[0];

while($nesteRadd = $resultat->fetch_assoc()){
	if ($nesteRadd['pris'] == $prisdyr) {
		echo "<b>" .$nesteRadd['kursnavn'] . "</b> er det dyreste kurset og koster: <b>" . $prisdyr . " kr</b><br>";
	} elseif ($nesteRadd['pris'] == $prisbillig) {
		echo "<b>" . $nesteRadd['kursnavn'] . "</b> er det billigste kurset og koster: <b>" . $prisbillig ." kr</b><br>";
	}
}

############################################
echo "<hr>";

# Lengde i for-loop for kurs:
$kurslength = "SELECT COUNT(*) FROM kurs";
$resultatlength = $db->query($kurslength);
$len = mysqli_fetch_array($resultatlength)[0];

# Lager tellere for total inntekt og totalt antall påmeldte. 
$antall = 0;
$totalinntekt = 0;

for ($x = 1; $x <= $len; $x++) {
	$sqlnew = "SELECT COUNT(*) from kurs k, kursstatus ks where k.kurs_id = ks.kurs_id and ks.kurs_id LIKE $x";
	$resultatnew = $db->query($sqlnew);
	$sumkurs = $resultatnew->fetch_assoc();
	$sqlnew2  = "SELECT * FROM kurs where kurs_id LIKE $x";
	$resultatnew2 = $db->query($sqlnew2);
	$priskurs = $resultatnew2->fetch_assoc();
	$inntekt = $sumkurs['COUNT(*)'] * $priskurs['pris']; // finner total inntekt per kurs
	$antall += $sumkurs['COUNT(*)']; // legger sammen påmeldinger fra alle kurs i en variabel
	echo "" . $priskurs['kursnavn'] . " gir: <b>" . $inntekt . ",-</b>";
	$totalinntekt += $inntekt; // legger sammen inntekter fra alle kurs i en variabel
	echo " Antall påmeldte for <b>" . $priskurs['kursnavn'] . " </b>er: <b>" . $sumkurs['COUNT(*)']." </b>stk.<br>";
}
echo "<br>Antall påmeldte totalt er: <b>" . $antall . "</b>";
echo "<br>Total inntekt fra kursene er: <b><h3>" .$totalinntekt."</b>,-</h3>";

############################################

# Viser kun aktive kurs for brukeren. 
$status = "aktiv";

$sqloversikt  = "SELECT * FROM kurs where status like '$status'";
$resultatoversikt = $db->query($sqloversikt);

// fetch_assoc() er en funksjon som samler verdier / treff fra en spørring inn til en assosiativ matrise / array.
echo "<b>Aktive kurs fra Nettkursportalen:</b><br>";
echo "<hr />";
while($nesteRad = $resultatoversikt->fetch_assoc()){
	echo "<form action='deaktiver_kurs.php' method='post'>";
	echo "KursID <b>: " . $nesteRad['kurs_id'] . "</b>" . " <input type='submit' name='button' value='Deaktiver kurs'<br>";
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
}//slutt while


?>