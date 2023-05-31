<?php
include "funksjoner.inc.php";
require ('phpmailer/includes/PHPMailer.php');
require ('phpmailer/includes/SMTP.php');
require ('phpmailer/includes/Exception.php');


use PHPMailer\PHPMailer\PHPmailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>
<?php
color();

# Lager en variabel som bruker en innebygd funksjon som henter nåværende dato.
$t=time();

# Legger variabelen i en ny til å sørge for identisk format som den brukt i database.
$tt = date('Y-m-d', $t);
$kursid = $_POST['id'];
$db = kobleTil();
$sqlkurs  = "SELECT * FROM kurs WHERE kurs_id LIKE $kursid";
$resultat = $db->query($sqlkurs);
$nesteRad = $resultat->fetch_assoc();
$sqlmaks  = "SELECT COUNT(*) FROM kursstatus WHERE kurs_id LIKE $kursid"; // beregner antall deltakere per kurs ved å bruke i-variabelen til å gå gjennom alle.
$resultatmaks = $db->query($sqlmaks);
$row = mysqli_fetch_array($resultatmaks)[0];

# Variabler nedenfor brukes for info ved sending av mail til påmeldte brukere. 
$oppstart = $nesteRad['oppstart'];
$sted = $nesteRad['sted'];
$pris = $nesteRad['pris'];
$url = "<a href='http://localhost/Prosjekt/minprofil.php'>Ta meg til Laarsn Nettkursportal</a>";

$Messagetime = urlencode("<b>Kurset du prøver å melde deg på har gått ut på dato. </b>");
$Messagefull = urlencode("<b>Kurset du prøver å melde deg på er dessverre fullt. </b>");

## Dersom kurs er utløpt vil det naturligvis ikke være mulig å melde seg på.
if ($nesteRad['dato'] < $tt) {

	# Blir henvist til påmeldingssiden med beskjed om at kurs er utløpt. 
	header('Location: ./utlopt.php?Messagetime='.$Messagetime);
die;
} elseif ($nesteRad['maksantall'] <= $row ) {

	# Samme gjelder hvis kurs er fullt.
	header('Location: ./utlopt.php?Messagefull='.$Messagefull);
	die;
} 


# Henter verdier fra skjemafelt i innledende oppgave. Bruker 'POST' da dette er metoden som er angitt på 'Skjema.php' (foretrekker at informasjonen vises ikke i URL).
$bruker_id = $_POST['bruker_id'];
$brukernavn = $_POST['brukernavn'];
$kursnavn = $_POST['kursnavn'];
$db = kobleTil();

$sqlalready = "SELECT * from kursstatus where bruker_id = '$bruker_id' and kurs_id = '$kursid';";
$resultatalready = $db->query($sqlalready);
$nesteRow = $resultatalready->fetch_assoc();

$sqlAktiv = "SELECT * from kurs where kurs_id = '$kursid';";
$resultatAktiv = $db->query($sqlAktiv);
$arrayAktiv = $resultatAktiv->fetch_assoc();

# En bruker kan ikke melde seg på samme kurs flere ganger. Denne koden unngår duplikater i database. 
if (!(empty($nesteRow['bruker_id']))) {
	$alreadyMember = urlencode("<b>Du er allerede påmeldt dette kurset. </b><br>");
	header('Location: ./utlopt.php?alreadyMember='.$alreadyMember);
	die;

# En bruker kan ikke melde seg på deaktiverte kurs. 
} elseif ($arrayAktiv['status'] != "aktiv") {
	$deaktivert = urlencode("<b>Kurset du prøver å melde deg på er ikke aktivt. </b><br>");
	header('Location: ./utlopt.php?deaktivert='.$deaktivert);
	die;
}
 else {
	$sql  = "INSERT INTO kursstatus 	
	(kurs_id, bruker_id, brukernavn, kursnavn) 
	VALUES
	(?, ?, ?, ?); 
	";

	#Forbereder spørringen i første ledd, det vil si lager en prepared statement ihht. SQL-sikkerhet.
	$statement = $db->prepare($sql);

	#Legger inn en argument-gruppe ('ssi'), hvilket forteller at den siste argumentgruppen er av typen: string, string, integer / heltall.
	$statement->bind_param("iiss", $kursid, $bruker_id, $brukernavn, $kursnavn);

	#Utførelse av prepared statement. 
	$statement->execute();
	echo "<p><b>Du er nå registrert på dette kurset!</b></p>";
	echo "<b>Du kan se oversikt over kursdeltakere på 'Deltakeroversikt' i menyen<br>";
	echo "<b><a href='minprofil.php'>Gå til Min Side</a><br>";
	echo "<br>";
	echo "<b>Eller registrer deg på </b><br>";
	echo "<b><a href='utlopt.php'>flere kurs</a>";

# Lager en ny PHPMailer-tjeneste. Ønsker å sende kursdeltaker en mail med bekreftelse på kursdeltakelse.  
$mail = new PHPMailer();

# Innlogget bruker sin mail-adresse.
$userEmail = $_SESSION['epost'];

# Setter PHPMailer til å bruke SMTP-protokollen. 
$mail->isSMTP();

# Angir SMTP-verten.
$mail->Host = "smtp.gmail.com";

# Aktiverer SMTP-autentisering.
$mail->SMTPAuth = true;

# Angir form for kryptering. (ssl/tsl).
$mail->SMTPSecure = "tls";

# Angir port for å koble til SMTP-protokollen.
$mail->Port = "587";

# Angir brukernavnet.
$mail->Username = "laarsn@gmail.com";

# Dette er ikke privat passord for gmail, men generisk app-passord. 
$mail->Password = "yfmzbwawwhhgzgem";

# Angir subject / overskrift på mail. 
$mail->Subject = "Påmelding kurs fra Laarsn Nettkursportal.";

# Angir avsender.
$mail->setFrom("laarsn@gmail.com");

# Aktiverer HTML.
$mail->isHTML(true);

# Angir charset 'UTF-8' slik at man kan bruke bokstaver som 'æøå'. 
$mail->CharSet = "UTF-8";

# Dette er mailens hovedinnhold.
$mail->Body = '<p>Du er herved påmeldt kurset: <b>' . $kursnavn .'.</b></p>
<br> Betaling kan gjøres over Vipps på telefon: 48 111 529 med beløpet: <b>' . $pris .',-</b> senest 10 virkedager etter kursets oppstartsdato. Kan også be om faktura på oppmøtested.
Informasjon fra kurset: <b>
<br>' . $arrayAktiv['info'] . '</b> 
<br><br> Oppmøtested: <b>' . $sted .'</b>
<br> Oppstartsdato (YYYY-MM-DD): <b>' . $oppstart . '</b>
<br><br> Oversikt over dine kurs kan du finne på Din Side inne på Nettkursportalen: <b><br>' . $url . '</b>';

# Legger til mottaker. Henter mail-adresse ved å bruke $_SESSION['epost'].
$mail->addAddress($userEmail);

# Eventuelle vedlegg i e-mail.
#$mail->addAttachment('img/example.jpg');

    # Sender av gårde mail. 
    if ( $mail->Send()) {
        echo "<br><br>En e-post har blitt sendt til oppgitt mail-adresse med praktisk informasjon tilknyttet kurset du har registrert deg for.";
    } else {
        echo "<br><br>En feil oppstod, vennligst prøv på nytt...";
    }
}

# Kurset man registrerer seg på havner også automatisk inn i kalenderen på Min Side (dynamisk).
$insert_query = "insert into `calendar_event_master`(`event_name`,`event_start_date`,`event_end_date`,`brukernavn`) values ('".$kursnavn."','".$oppstart."','".$oppstart."','".$brukernavn."')";             
if(mysqli_query($db, $insert_query))
{
	$data = array(
                'status' => true,
                'msg' => 'Kurs eller avtale er lagret!'
            );
}
else
{
	$data = array(
                'status' => false,
                'msg' => 'En feil oppstod. Prøv på nytt!'				
            );
}
#echo json_encode($data);

?>