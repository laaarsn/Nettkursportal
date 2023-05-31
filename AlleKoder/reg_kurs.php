<?php
include "funksjoner.inc.php";

?>

<?php
color();

# Henter verdier fra skjemafelt i innledende oppgave. Bruker 'POST' da dette er metoden som er angitt på 'Skjema.php' (foretrekker at informasjonen ikke vises i URL).
$Message = urlencode("<b><div class='color'>Du må huske å fylle inn alle feltene. </b></div>");
if (empty($_POST['navn']) || empty($_POST['nummer']) || empty($_POST['dato']) || empty($_POST['pris']) || empty($_POST['info'])) {
    header('Location: ./nyttkurs.php?Message='.$Message);
    die;
}


$maksantall = $_POST['nummer'];
$kursnavn = $_POST['navn'];
$frist = $_POST['dato'];
$pris = $_POST['pris'];
$info = $_POST['info'];
$oppstart = $_POST['oppstart'];
$sted = $_POST['sted'];
$db = kobleTil();

## Setter inn placeholders istedenfor reelle verdier ihht. SQL-sikkerhet.
$sql  = "INSERT INTO kurs 	
	(kursnavn, maksantall, dato, oppstart, sted, pris, info, status) 
	VALUES
	(?, ?, ?, ?, ?, ?, ?, ?); 
	";

#Forbereder spørringen i første ledd, det vil si lager en prepared statement ihht. SQL-sikkerhet.
$statement = $db->prepare($sql); 

# Nytt kurs blir automatisk registrert som aktivt og blir gjort tilgjengelig for bruker. Kan senere deaktivieres av admin. 
$status = "aktiv";

#Legger inn en argument-gruppe ('sisssiss'), som sier noe om datatypen som sendes til databasen (i = integer / heltall, s = tekststreng).
$statement->bind_param("sisssiss", $kursnavn, $maksantall, $frist, $oppstart, $sted, $pris, $info, $status);

#Utførelse av prepared statement. 
$statement->execute();
echo "<p><b>Nytt kurs lagt til!</b></p>";
#echo "<b>Spørring som ble kjørt:</b><pre>$sql</pre>";
echo "<b>Du kan se oversikt over tilgjengelige kurs på 'Vis kursliste' i menyen";

# Må også legge til kurset som ny kolonne i graf-tabell, slik at graf-tabellen vet at det nye kurset eksisterer (den oppdaterer kun eksisterende kolonner i 'graph.php' for å unngå duplikate rader).
# Ikke nødvendig med prepared statements og placeholders, legger til dummy-verdi sammen med kursnavn (reell verdi vil bli gitt i 'graph.php').
$sqlLeggtilSektor = "INSERT INTO grafer_sektor 
				(kursnavn, antall) 
				VALUES 
				('$kursnavn', 'test');
				";

$resultatLeggtil = $db->query($sqlLeggtilSektor);

# Samme prinsipp som med sektordiagrammet. Dette diagrammet skal legge frem inntekter for hvert kurs. 
$sqlLeggtilStolpe = "INSERT INTO grafer_stolpe 
				(kursnavn, inntekt) 
				VALUES 
				('$kursnavn', 'test');
				";

$resultatStolpe = $db->query($sqlLeggtilStolpe);
?>