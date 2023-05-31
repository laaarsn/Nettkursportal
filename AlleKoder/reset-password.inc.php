<?php
include "funksjoner.inc.php";
color();
require ('phpmailer/includes/PHPMailer.php');
require ('phpmailer/includes/SMTP.php');
require ('phpmailer/includes/Exception.php');
$conn = kobleTil();
if (isset($_POST["reset-password-submit"])) {

    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-repeat"];

    # Lister opp ulike kriterier som gjelder for nytt passord og legger de i variabler.  
	$storbokstav = preg_match('@[A-Z]@', $password); 
	$litenbokstav = preg_match('@[a-z]@', $password); 
	$tall = preg_match('@[0-9]@', $password); 
	$spesialtegn = preg_match('@[^\w]@', $password); 

    # Beskjeder som gis bruker dersom kriterier på passord ikke er oppfylt. 
    $passordUnderkjent = urlencode("<b>Passord må inneholde store og små bokstaver, ha minimum 8 tegn, et tall og inneholde spesialtegn (#!/-). </b>");
    $empty = urlencode("<b>Skriv inn et nytt passord, dette må også gjentas for bekreftelse. </b>");
    $identical = urlencode("<b>Du skrev to forskjellige passord. Passord må matche!</b>");

    # Merk at jeg også legger på selector- og validator-token på header-beskjed. 
    # Dersom denne ikke legges med regnes passordendringen som ugyldig (kreves for autentisering), og bruker får ikke ny mulighet til å endre passord. 
    if (empty($password) || empty($passwordRepeat)) {
        header('Location:lag-nytt-passord.php?selector=' . $selector . '&validator=' . $validator . '&empty=' . $empty);
        die();
    } else if ($password != $passwordRepeat) {
        header('Location:lag-nytt-passord.php?selector=' . $selector . '&validator=' . $validator . '&identical=' . $identical);
        die();
    } elseif ((!$storbokstav || !$litenbokstav || !$tall || !$spesialtegn || strlen($password) < 8)) {
        header('Location:lag-nytt-passord.php?selector=' . $selector . '&validator=' . $validator . '&passordUnderkjent=' . $passordUnderkjent);
		die;
    }

    $currentDate = date("U");

    # Sjekker at nåværende tidspunkt ikke har høyrere verdi enn daværende tidspunkt + 1800 sekunder mtp. sikkerhet. Isåfall returneres tom verdi.
    $sql = "SELECT * FROM nettkursportalen.pwdreset WHERE pwdResetSelector=? AND pwdResetExpires >= ?"; 
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        echo "Det oppstod en feil. #3";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $selector,$currentDate);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if (!$row = mysqli_fetch_assoc($result)) {
            echo "Du må gjenoppta passordprosessen. #1";
            exit();
        } else {
            
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

            if ($tokenCheck === false) {
                echo "Du må gjenoppta passordprosessen. #2";
                exit();
            } elseif ($tokenCheck === true) {

                $tokenEmail = $row["pwdResetEmail"];

                $sql = "SELECT * FROM brukere WHERE mail=?;";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "Det oppstod en feil! #4";
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if (!$row = mysqli_fetch_assoc($result)) {
                        echo "Det oppstod en feil! Finner ikke noen bruker med denne mailen. #5";
                        exit();
                    } else {

                        $sql = "UPDATE brukere SET passord=? WHERE mail=?";
                        
                        $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "Det oppstod en feil! #6";
                    exit();
                } else {
                    $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ss", $password, $tokenEmail);
                    mysqli_stmt_execute($stmt);

                    $sql = "DELETE FROM nettkursportalen.pwdreset WHERE pwdResetEmail=?";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "Det oppstod en feil! #7";
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                        mysqli_stmt_execute($stmt);
                        $Oppdatert = urlencode("<b><h3>Gratulerer! Passordet ditt har blitt oppdatert.</h3></b>");
                        header('Location:./regbruker.php?Oppdatert='.$Oppdatert);
                        die;
                    }
                }

                    }
                }
            }

        }
    }

} else {
    header("Location:nyttkurs.php");
}
?>