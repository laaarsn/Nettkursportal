<style> 
.rolling {
    text-align: right;
}

</style>
<?php

include "funksjoner.inc.php";
include "topp.inc.php";
color();
$db = kobleTil();

# Hente inneværende brukernavn
$brukernavnid = $_SESSION['brukernavn'];
$sqlnavn = "SELECT * from brukere WHERE brukernavn LIKE '$brukernavnid'";
$ressultatnavn = $db->query($sqlnavn);
$brukernavnfornavn = $ressultatnavn->fetch_assoc();
$brukernavn = $brukernavnfornavn['brukernavn'];
$brukernavn_id = $brukernavnfornavn['bruker_id'];

# Hente inneværende bruker_id.
#$sqlbruker_id = "SELECT * from brukere WHERE brukernavn LIKE '$brukernavnid'";
#$resultat_brukerid = $db->query($sqlbruker_id);
#$bruker_id = $resultat_brukerid->fetch_assoc();
#$brukernavn_id = $bruker_id['brukernavn'];


######################
$kursid = $_POST['id'];
$kursnavn = $_POST['kursnavn'];
echo "<h4>Skjema for deltakerregistrering</h4>";
echo "<form action='reg_deltaker.php' method='post'>";
echo "<input type='hidden' name='bruker_id' value='$brukernavn_id'>";
echo "<input type='hidden' name='kursnavn' value='$kursnavn'>";
echo "Brukernavn:<br>";
echo "<input type='text' name='brukernavn' value='$brukernavn'><br>";
echo "Kurs-ID:<br>";
echo "<input type='number' name='id' value='$kursid'><br>"; 
echo "<input type='submit' name='knapp'><br>"; 
echo "<br><a href='utlopt.php'><b>Tilbake til kursoversikt</a></b><br>";


$t=time();

# Legger variabelen i en ny til å sørge for identisk format som den brukt i database.
$tt = date('Y-m-d', $t);

$sqlantall  = "SELECT COUNT(*) FROM kurs";
$resultatantall = $db->query($sqlantall);
$len = mysqli_fetch_array($resultatantall)[0]; //samler resultat fra spørring i en array. må ta første index-verdi siden den kun inneholder ett element.
echo "<b>Tilgjengelige kurs:<br></b>";
for ($j = 1; $j <= $len; $j++) {
    $sqlavailable  = "SELECT COUNT(*) FROM kursstatus WHERE kurs_id LIKE $j"; // beregner antall deltakere per kurs ved å bruke j-variabelen til å gå gjennom alle.
    $resultatavailable = $db->query($sqlavailable);
    $rowtilgjengelig = mysqli_fetch_array($resultatavailable)[0];
    $sqlkurstilgjengelig  = "SELECT * FROM kurs WHERE kurs_id LIKE $j"; #Henter alle kurs fra kurs-tabellen.
    $resultatkurstilgjengelig = $db->query($sqlkurstilgjengelig);
    $maksantalltilgjengelig = $resultatkurstilgjengelig->fetch_assoc();
    
       if ($rowtilgjengelig < $maksantalltilgjengelig['maksantall'] && $maksantalltilgjengelig['dato'] > $tt  ) {
        #array_push($tilgjengelig, $maksantalltilgjengelig['kursnavn'], $maksantalltilgjengelig['pris'], $maksantalltilgjengelig['maksantall']  );
        echo "<hr>";
        echo "<br>" . "Kurs-id: <b>" . $maksantalltilgjengelig['kurs_id'] . " " . $maksantalltilgjengelig['kursnavn'] . "</b>". " " . " Pris: " . "<b>" . $maksantalltilgjengelig['pris'] . "</b>". " Påmeldingsfrist: " . "<b>" . $maksantalltilgjengelig['dato'] . "</b>"; 
    }
}
######################

######################

$db = kobleTil();
?>
