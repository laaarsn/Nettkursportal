<h1>Opprettelse av tabell</h1>
Denne tabellen skal lage tabellene 'kurs' og 'deltagere'.
<?php
$db = new mysqli("localhost", "root", "", "EksamenV21");



$sqlkurs  = "CREATE TABLE kurs (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	kursnavn VARCHAR( 20 ) NOT NULL ,
	maksantall int ( 8 ) ,
	frist DATE NOT NULL ,
    pris INT ( 8 ) 
	)";

if ($db->query($sqlkurs)) {
	echo "<p><b>Tabellen ble opprettet!</b></p>";
	echo "<b>Sp�rring som ble kj�rt:</b><pre>$sqlkurs</pre>";
}
else {
	echo "<p>Noe gikk galt</p>";
}

$sqldeltakere  = "CREATE TABLE deltakere (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	kursid INT ( 8 ) NOT NULL ,
	deltakernavn VARCHAR ( 50 ) 
	)";

if ($db->query($sqldeltakere)) {
	echo "<p><b>Tabellen ble opprettet!</b></p>";
	echo "<b>Sp�rring som ble kj�rt:</b><pre>$sqldeltakere</pre>";
}
else {
	echo "<p>Noe gikk galt</p>";
}
?>