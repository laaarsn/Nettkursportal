<!-- addEventListener er en metode som kaller opp en funksjon dersom en klasse inneholder et gitt ord, 
i dette tilfellet 'visKnapp'. Dette gjør at man kan 'toggle' (vise / ikke vise) flere elementer (kurs i dette tilfellet) i et treff fra søkemotoren ved å veksle mellom ulike klasser.
Ved hjelp av denne metoden trenger man heller ikke å lage dynamiske klassenavn / ID'er i HTML.
-->

<script>
document.addEventListener("click",(e) => {
   const el = e.target;
   if(el.classList.contains("visKnapp")){
      el.nextElementSibling.classList.toggle("active") /* Dersom man klikker på knappen 'visKnapp' kan man toggle mellom klassene content-div og content-div.active */
   }
});
</script>

<!-- Legger på css-kode som forteller hva klassen skal vise ved aktiv / inaktiv (ligger skjult 'by default').  -->
<style>
.content-div {
	display:none;
}

.visKnapp {
	border-radius: 10px;
	border: 2px solid black;
}

/* viktig at denne klassen har samme navn som 'toggle-ordet' i addEventListener-metoden (active). */
.content-div.active { 
	display:block;
}
</style>

<?php
include "funksjoner.inc.php";
color();

$db = kobleTil();
$search = $_POST['search'];
$sok = "SELECT * FROM kurs WHERE kursnavn LIKE '%$search%'" ; // Viktig med prosent-tegn før og etter søkeord i en SQL-søkemotor. F.eks så vil søket 'er' gi treff på både 'erlend', 'bollerud' og 'peder'. 
$resultatSearch = $db->query($sok);


$sqlLengde = "SELECT count(*) from kurs;";
$resultatLen = $db->query($sqlLengde);
$len = mysqli_fetch_array($resultatLen)[0];


echo "<h4><b>'$search'</b> ga følgende treff:</h4>";

$teller = 0;
while($nesteRad = $resultatSearch->fetch_assoc()){
	$info = $nesteRad['info'];
	echo "Kurs-ID: <b>" . $nesteRad['kurs_id'] . "</b>";
	echo "<br>Navn: <b>" . $nesteRad['kursnavn'] . "</b>";
	echo "<br>Pris: <b>" . $nesteRad['pris'] . "</b>";
	echo "<br>Påmeldingsfrist: <b>" . $nesteRad['dato'] . "</b>";
	echo "<br>Maks antall: <b>" . $nesteRad['maksantall'] . "</b><br>";
	$teller++;

	?>

	<!-- Her vises det til klassen jeg la inn i Eventlisteneren lenger opp -->
	<button class="visKnapp">Vis/skjul info</button>
	<div class="content-div">
	<?php echo "<b>". $info. "</b>"; ?>	
	</div>
	
	<?php
	echo "<br><a href='utlopt.php'>Gå til påmelding?</a>";
	echo "<hr />";
}
?>

<b><a href='index.php'>Tilbake til Hovedside</a></b>