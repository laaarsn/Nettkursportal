<?php
 include "funksjoner.inc.php";
 color();

 $db = kobleTil(); 

# Lengde i for-loop for kurs:
$kurslength = "SELECT COUNT(*) FROM kurs";
$resultatlength = $db->query($kurslength);
$len = mysqli_fetch_array($resultatlength)[0];

$antaltotalt = 0;
for ($x = 1; $x <= $len; $x++) {

	# Forener kurs-tabell og koblingstabell gjennom felles attributt 'kurs_id'. Henter informasjon om antall påmeldte per kurs ved å loope igjennom tabellene. 
	$sqlnew = "SELECT COUNT(*) from kurs k, kursstatus ks where k.kurs_id = ks.kurs_id and k.status = 'aktiv' and ks.kurs_id LIKE $x";
	$resultatnew = $db->query($sqlnew);
	$sumkurs = $resultatnew->fetch_assoc();

	# Henter ut nødvendig informasjon fra kurs-tabell (pris og kursnavn).
	$sqlnew2  = "SELECT * FROM kurs where kurs_id LIKE $x";
	$resultatnew2 = $db->query($sqlnew2);
	$priskurs = $resultatnew2->fetch_assoc();
	$navn = $priskurs['kursnavn'];
	
	$antalldeltakere = $sumkurs['COUNT(*)'];
	$sqlUpdate = "UPDATE grafer_sektor
	SET antall = $antalldeltakere
	WHERE id = $x;";
	$antaltotalt += $antalldeltakere;
	$resultatUpdate = $db->query($sqlUpdate);
}
echo "<b>Antall påmeldte totalt: " . $antaltotalt . "</b>";

# Gjør diagrammet dynamisk med å koble meg til en sql-database for innhenting av data.
$link = mysqli_connect("localhost", "root", "");
mysqli_select_db($link, "nettkursportalen");

# Data fra sql-databasen legges i en ny matrise. 
$ny_matrise = array();
$teller = 0;
$resultat = mysqli_query($link, "select * from grafer_sektor");
while($row = mysqli_fetch_array($resultat)) {

	# For å legge til alle rader i tabellen som egne elementer i ordlisten, bruker jeg teller-variabel som indeksverdi.
	# Denne vil øke med +1 i verdi for hver iterasjon i while-loopen. 
	$ny_matrise[$teller]["label"]=$row["kursnavn"];
	$ny_matrise[$teller]["y"]=$row["antall"];
	$teller++;
}

?>

<!-- CanvasJS.com -->
<!DOCTYPE HTML>
<html>
<head>  
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "Oversikt over aktive kurs"
	},
	subtitles: [{
		text: "Fordeling kursdeltakere"
	}],
	data: [{
		type: "pie",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - #percent%",
		yValueFormatString: "", //%#,##0
		dataPoints: <?php echo json_encode($ny_matrise, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 50%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html> 
<a href='minprofil.php'><h3>Tilbake Min Side</h3></a>