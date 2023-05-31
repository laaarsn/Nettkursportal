<?php
include "funksjoner.inc.php";
?>
<?php
color();

$Message = urlencode("<b><div class='color'>Du må huske å fylle inn alle feltene. </b></div>");
if (isset($_POST['submitbttn'])) {
	if (empty($_POST['bruker']) || empty($_POST['pass']) || empty($_POST['mail']) || empty($_POST['fornavn']) || empty($_POST['etternavn'])) {
		header('Location: ./regbruker.php?Message='.$Message);
		die;
	}
}

# Henter verdier fra skjemafelt i innledende oppgave. Bruker 'POST' da dette er metoden som er angitt på 'Skjema.php' (foretrekker at informasjonen vises ikke i URL).
$brukernavn = $_POST['bruker'];
$passord = $_POST['pass'];
$mail = $_POST['mail'];
$fornavn  = $_POST['fornavn'];
$etternavn = $_POST['etternavn'];
$db = kobleTil();


# Lengde på tabell for antall brukere. Brukes for å loope igjennom hele tabellen for å sjekke om brukernavn / mail finnes fra før. 
$brukerelength = "SELECT COUNT(*) FROM brukere";
$resultatbrukerlength = $db->query($brukerelength);
$len = mysqli_fetch_array($resultatbrukerlength)[0];

# Meldinger som blir gitt bruker dersom brukernavn, passord eller mail-adresse ikke oppfyller de kriterier som er gitt. 
$messageTaken = urlencode("<b><div class='color'>Brukernavn eller mail-adresse finnes allerede i databasen. </b></div>");
$passordUnderkjent = urlencode("<b><div class='color'>Passord må inneholde store og små bokstaver, ha minimum 8 tegn, et tall og inneholde spesialtegn (#!/-). </b></div>");
for ($i =1; $i <= $len; $i++) {
	$sqlsearch = "SELECT * from brukere where bruker_id like $i";
	$resultatsearch = $db->query($sqlsearch);
	$brukere = $resultatsearch->fetch_assoc();

	#Sjekker at passordet som bruker skriver inn utfyller kriteriene som er satt. 
	$storbokstav = preg_match('@[A-Å]@', $passord); 
	$litenbokstav = preg_match('@[a-å]@', $passord); 
	$tall = preg_match('@[0-9]@', $passord); 
	$spesialtegn = preg_match('@[^\w]@', $passord); 

	# Sjekker at brukernavn eller e-mail ikke eksisterer fra før for å unngå duplikater i database.
	# Viktig mtp. at brukernavn brukes for innlogging, og mail brukes for kursbekreftelse og bestilling av nytt passord. 
	if ($brukernavn == $brukere['brukernavn'] || $mail == $brukere['mail'] ) {
		header('Location: ./regbruker.php?messageTaken='.$messageTaken);
		die;

	# Validerer passordet som bruker skriver inn. Sterke passord reduserer sannsynlighet for bruteforce-angrep og lignende. 
	} elseif ((!$storbokstav || !$litenbokstav || !$tall || !$spesialtegn || strlen($passord) < 8)) {
		header('Location: ./regbruker.php?passordUnderkjent='.$passordUnderkjent);
		die;
	}
}

# Dersom if-else-betingelsene lenger opp ikke er utfylt, betyr det at input fra bruker er godkjent, og man går videre i koden til å opprette ny bruker. 
# Setter inn placeholders istedenfor reelle verdier ihht. SQL-sikkerhet.
$sql  = "INSERT INTO brukere 	
	(brukernavn, passord, mail, fornavn, etternavn) 
	VALUES
	(?, ?, ?, ?, ?); 
	";

#Forbereder spørringen i første ledd, det vil si lager en prepared statement ihht. SQL-sikkerhet.
$statement = $db->prepare($sql); 

#Legger inn en argument-gruppe ('sssss'), hvilket forteller verdiene som legges inn er av typen: string.
$statement->bind_param("sssss", $brukernavn, $passord, $mail, $fornavn, $etternavn);

#Utførelse av prepared statement. 
$statement->execute();

echo "<p><b>Ny bruker registrert. Du kan nå logge inn opp i høyre hjørne.</b></p>";
echo "<b>Du kan se oversikt over tilgjengelige kurs på 'Vis kursliste' i menyen";

# Oppretter ny kolonne i tabellen 'bilde_user', siden hver bruker må ha et unikt profilbilde. Hvis ikke vises samme bilde for alle brukere. 
$sqlBilde  = "INSERT INTO bilde_user 	
	(name, image, brukernavn) 
	VALUES
	(?, ?, ?); 
	";

$statement = $db->prepare($sqlBilde); 

# Ved førstegangsinnlogging vises et standardbilde med navnet vist i linjen nedenfor. 
$defaultIMG = "noprofile.jpg";

$statement->bind_param("sss", $fornavn, $defaultIMG, $brukernavn);
$statement->execute();
?>