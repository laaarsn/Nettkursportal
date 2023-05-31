<?php
 include "funksjoner.inc.php";
 include "admin.inc.php";
 color();

 $db = kobleTil(); 

# Lengde i for-loop for kurs:
$kurslength = "SELECT COUNT(*) FROM kurs";
$resultatlength = $db->query($kurslength);
$len = mysqli_fetch_array($resultatlength)[0];

$total = 0;
for ($x = 1; $x <= $len; $x++) {

	# Forener kurs-tabell og koblingstabell gjennom felles attributt 'kurs_id'. Dersom kurs_id fra begge har samme verdi, betyr det at deltaker er påmeldt det gitte kurset.
	$sqlnew = "SELECT COUNT(*) from kurs k, kursstatus ks where k.kurs_id = ks.kurs_id and ks.kurs_id LIKE $x";
	$resultatnew = $db->query($sqlnew);
	$sumkurs = $resultatnew->fetch_assoc();

	# Henter ut nødvendig informasjon fra kurs-tabell (pris og kursnavn).
	$sqlnew2  = "SELECT * FROM kurs where kurs_id LIKE $x";
	$resultatnew2 = $db->query($sqlnew2);
	$priskurs = $resultatnew2->fetch_assoc();
	$inntekt = $sumkurs['COUNT(*)'] * $priskurs['pris'];
	$antalldeltakere = $sumkurs['COUNT(*)'];
	$navn = $priskurs['kursnavn'];
    $total += $inntekt;

	$sqlUpdate = "UPDATE grafer_stolpe
	SET inntekt = $inntekt
	WHERE id = $x;";

	$resultatUpdate = $db->query($sqlUpdate);
}

# Gjør diagrammet dynamisk med å koble meg til en sql-database for innhenting av data.
$link = mysqli_connect("localhost", "root", "");
mysqli_select_db($link, "nettkursportalen");

# Data fra sql-databasen legges i en ny matrise. 
$ny_matrise = array();
$teller = 0;
$resultat = mysqli_query($link, "select * from grafer_stolpe");
while($row = mysqli_fetch_array($resultat)) {
	$ny_matrise[$teller]["label"]=$row["kursnavn"];
	$ny_matrise[$teller]["y"]=$row["inntekt"];
	$teller++;
}

?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title: {
		text: "Nettkursportalen: Inntektsoversikt"
	},
	axisY: {
		title: "Inntekt i kroner"
	},
    axisX: {
        title: "Kursnavn"
    },
	data: [{
		type: "column", //bar, line, area, pie
		dataPoints: <?php echo json_encode($ny_matrise, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 330px; width: 75%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>    

<?php 
echo "<b><h3>Total inntekt er: " . $total . "</h3></b>";
?>
<a href='kursliste.php'><h3>Tilbake til Kursoversikt</h3></a>