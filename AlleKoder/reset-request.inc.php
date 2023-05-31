<?php
include "funksjoner.inc.php";
require ('phpmailer/includes/PHPMailer.php');
require ('phpmailer/includes/SMTP.php');
require ('phpmailer/includes/Exception.php');


use PHPMailer\PHPMailer\PHPmailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$Message = urlencode("<b>Du må skrive inn en gyldig mail-adresse! </b>");
$emailcheck = $_POST['email'];

# Verifiserer at gyldig mail-adresse blir oppgitt. 
if (!filter_var($emailcheck, FILTER_VALIDATE_EMAIL)) {
    header('Location: ./reset-password.php?Message='.$Message);
    die;
}

if (isset($_POST['reset-request-submit'])) {

    # Token som sjekker at det er riktig bruker.
    $selector = bin2hex(random_bytes(8));

    # Token som knytter det første tokenet opp mot databasen.
    $token = random_bytes(32);

    $url = "http://localhost/Prosjekt/lag-nytt-passord.php?selector=" . $selector .  "&validator=" . bin2hex($token);

    # Når bruker ønsker å endre passord har vedkommende 1800 sekunder på seg til formålet (30 min). Dette sjekkes i 'reset-passord.inc.php'. 
    $expires = date("U") + 1800;

    $conn = kobleTil();

    $userEmail = $_POST['email'];

    $sql = "DELETE FROM nettkursportalen.pwdreset WHERE pwdResetEmail=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        echo "Det oppstod en feil. #1";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO nettkursportalen.pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        echo "Det oppstod en feil. #2";
        exit();
    } else {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);


    header("Location:reset-password.php?reset=success");



# Lager en ny PHPMailer-tjeneste. 
$mail = new PHPMailer();

# Setter PHPMailer til å bruke SMTP-protokollen. 
$mail->isSMTP();

# Angir SMTP-verten.
$mail->Host = "smtp.gmail.com";

# Aktiverer SMTP-autentisering.
$mail->SMTPAuth = true;

# Angir form for kyrptering (ssl/tls).
$mail->SMTPSecure = "tls";

# Angir port for å koble til SMTP-protokollen.
$mail->Port = "587";

# Angir brukernavnet.
$mail->Username = "laarsn@gmail.com";

# Dette er ikke privat passord for gmail, men generisk app-passord. 
$mail->Password = "yfmzbwawwhhgzgem";

# Angir subject / overskrift på mail.
$mail->Subject = "Gjenoppretting av passord.";

# Angir avsender.
$mail->setFrom("laarsn@gmail.com");

# Aktiverer HTML.
$mail->isHTML(true);

# Angir charset UTF-8 slik at man kan bruke bokstaver som 'æøå'. 
$mail->CharSet = "UTF-8";

# Dette er mailens hovedinnhold.
$mail->Body = '<p>Her er linken for å lage et nytt passord for din bruker:<br> <a href="' . $url . '">' . $url . '</a> <br>Dersom du ikke har bedt om nytt passord fra Nettkurportalen kan du se bort ifra denne mailen.</p>';

# Legger til mottaker. Henter mail-adresse ved å bruke $_POST['email'] (kunne også ha benyttet $_SESSION['epost']).
$mail->addAddress($userEmail);

# Eventuelle vedlegg i e-mail.
//$mail->addAttachment('img/example.jpg');

    # Sender av gårde mail.
    if ( $mail->Send()) {
        echo "E-mail ble sendt!";
    } else {
        echo "Noe feil skjedde...";
    }

} else {
    header("Location:nyttkurs.php");

}