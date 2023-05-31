<?php
include "funksjoner.inc.php";
color();
include "topp.inc.php";

$id = $_SESSION['brukernavn'];
$db = kobletil();

if (isset($_POST['passordbutton'])) {
    $pwd = $_POST['passord'];

    #Sjekker at passordet som bruker skriver inn utfyller kriteriene som er satt. 
	$storbokstav = preg_match('@[A-Z]@', $pwd);
	$litenbokstav = preg_match('@[a-z]@', $pwd);
	$tall = preg_match('@[0-9]@', $pwd);
	$spesialtegn = preg_match('@[^\w]@', $pwd);
    if ((!$storbokstav || !$litenbokstav || !$tall || !$spesialtegn || strlen($pwd) < 8)) {
        echo "<b>Passord må inneholde store og små bokstaver, ha minimum 8 tegn, et tall og inneholde spesialtegn (#!/-).<br></b>";
        echo "<a href='minprofil.php'>Tilbake til Min Side</a>";
        die;
    }
    $sqlpwd  = "UPDATE `brukere` SET passord = '$pwd' WHERE brukernavn = '$id';";
    $resultatpwd = $db->query($sqlpwd);
    echo "<b>Passordet ble endret!</b><br>";
    echo "<a href='minprofil.php'>Tilbake til min profil</a>";
} elseif (isset($_POST['userbutton'])) {
    $brukernavn = $_POST['brukernavn'];
    $sqlusermatch = "SELECT * from brukere WHERE brukernavn = '$brukernavn'";
    $resultatmatch = $db->query($sqlusermatch);
    $brukere = $resultatmatch->fetch_assoc();
    if (!(empty($brukere['brukernavn']))) {

        #$userTaken = urlencode("<b>Brukernavnet eksisterer fra før. Prøv med et annet. </b><br>");
        #header('Location: ./minprofil.php?userTaken='.$userTaken);
        echo "<b>Brukernavn er opptatt.<br></b>";
        echo "<a href='minprofil.php'>Tilbake til Min Side</a>";
        die;
    } else { 
        $sqluser  = "UPDATE `brukere` SET brukernavn = '$brukernavn' WHERE brukernavn = '$id';";
        $resultatuser = $db->query($sqluser);
        echo "<b>Brukernavn ble endret!</b><br>";
        echo "<a href='minprofil.php'>Tilbake til min profil</a>";

        #Koblingstabellen som forbinder brukernavn opp mot påmeldte kurs må også oppdateres, hvis ikke så forsvinner kursene fra oversikten hos bruker.
        $sqlnickname = "UPDATE `kursstatus` SET brukernavn = '$brukernavn' WHERE brukernavn = '$id';";
        $resultatnickname = $db->query($sqlnickname);

        # Samme gjelder profilbildetabellen. Hvis gammelt brukernavn henger igjen, har ikke tabellen noe referansepunkt.  
        $sqlBilde = "UPDATE `bilde_user` SET brukernavn = '$brukernavn' WHERE brukernavn = '$id';";
        $resultatnickname = $db->query($sqlBilde);
        $_SESSION['brukernavn'] = $brukernavn;
        die; 
    }
} elseif (isset($_POST['mailbutton'])) {
    $mail = $_POST['epost'];
    $sqlmailmatch = "SELECT * from brukere WHERE mail = '$mail'";
    $resultatmail = $db->query($sqlmailmatch);
    $brukerMail = $resultatmail->fetch_assoc();
    if (!(empty($brukerMail['mail']))) {
        #$mailTaken = urlencode("<b>Mail-adressen eksisterer fra før. Prøv med en annen. </b><br>");
        #header('Location: ./minprofil.php?mailTaken='.$mailTaken);
        echo "<b>Mail-adresse eksisterer fra før.<br></b>";
        echo "<a href='minprofil.php'>Tilbake til Min Side</a>";
        die;
    } else { 
        $sqlmail  = "UPDATE `brukere` SET mail = '$mail' WHERE brukernavn = '$id';";
        $resultatepost = $db->query($sqlmail);
        echo "<b>Mail-adresse ble endret!</b><br>";
        echo "<a href='minprofil.php'>Tilbake til min profil</a>";
        $_SESSION['epost'] = $mail;
        die; 
    }
} elseif (isset($_POST['fnavnbutton'])) {
    $fornavn = $_POST['fornavn'];
    $sqlfornavn  = "UPDATE `brukere` SET fornavn = '$fornavn' WHERE brukernavn = '$id';";
    $resultatmail = $db->query($sqlfornavn);
    echo "<b>Fornavn ble endret!</b><br>";
    echo "<a href='minprofil.php'>Tilbake til min profil</a>";
} elseif (isset($_POST['enavnbutton'])) {
    $etternavn = $_POST['etternavn'];
    $sqletternavn  = "UPDATE `brukere` SET etternavn = '$etternavn' WHERE brukernavn = '$id';";
    $resultatmail = $db->query($sqletternavn);
    echo "<b>Etternavn ble endret!</b><br>";
    echo "<a href='minprofil.php'>Tilbake til min profil</a>";
}

?>