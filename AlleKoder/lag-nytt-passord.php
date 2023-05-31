<style> 
.pwd {
    border-bottom-left-radius: 5px;
    border-top-left-radius: 5px;
    position: relative;
    top: -195px;
}
.pwd::placeholder {
    color: grey;
}
.imgpwd {
  background-image: url('images/laarsnbeach.jpg');
  padding: 240px 20px;
  hidden-align-last: left;
  background-repeat: no-repeat;
}


.imgpwd h1 {
    font-family: 'georgia,garamond,serif';
    position: relative;
    top: -140px;
    color:silver;
}

.imgpwd p {
    font-family: 'georgia,garamond,serif';
    font-style: italic;
    position: relative;
    top: -150px;
    font-weight: bold;
    font-size: 18px;
    color:silver;
}
.butnn{
    width: 150px;
    height: 30px;
    background: #539E9E;
    border: none;
    margin-top: 15px;
    font-size: 18px;
    border-radius: 15px;
    cursor: pointer;
    color: #fff;
    transition: 0.4s ease;
    z-index: 999;
}
.butnn:hover{
    background: #1C87B0;
    color: 0.5s grey;
	transition: 1s ease;
}

.positionText {
    position: relative;
    top: -110px;
}

.positionInput {
    position: relative;
    top: -290px;
}
.positionErrorMessage {
    position: relative;
    top: 300px;
}
</style>
<?php 
include "funksjoner.inc.php";
color();
require ('phpmailer/includes/PHPMailer.php');
require ('phpmailer/includes/SMTP.php');
require ('phpmailer/includes/Exception.php');
?>



<?php

# Sjekker om noen prøver å gå inn "bakdøra" ved å skrive inn lenke til passordside uten å ha mottatt mail og klikket på tilsendt lenke. 
$db = kobleTil();
$sqlSafety = "SELECT * from pwdreset";
$resultatSafety = $db->query($sqlSafety);
$assoc = $resultatSafety->fetch_assoc();

if (empty($assoc)) {
    echo "<b>Vennligst start passordprosessen på nytt ved å klikke på 'Glemt passord?'.</b>";
    die();
}

echo "<div class='imgpwd'>";


# Hvis man ikke skriver inn nytt passord / repeterer nytt passord aktiveres denne beskjeden.
if(isset($_GET['empty'])){
    echo "<div class='positionErrorMessage'>" . $_GET['empty'] .  "</div>";
}

# Hvis man ikke skriver inn to identiske passord aktiveres denne beskjeden.
if(isset($_GET['identical'])){
    echo "<div class='positionErrorMessage'>" . $_GET['identical'] .  "</div>";
}

# Hvis passordet man skriver inn ikke utfyller alle kriterier aktiveres denne beskjeden. 
if(isset($_GET['passordUnderkjent'])){
    echo "<div class='positionErrorMessage'>" . $_GET['passordUnderkjent'] .  "</div>";
}

# Dersom bruker prøver å ta seg inn på siden uten å ha klikket på lenke vil ikke token-variablene ha verdier. Legger derfor på en funksjon som fjerner feilmeldingen for null-verdier. 
error_reporting(0);
$selector = $_GET["selector"];
$validator = $_GET["validator"];

# Dersom ugyldig token blir angitt, vil ikke bruker bli gitt mulighet for å prøve å endre passord. 
if (empty($selector) || empty($validator) || $selector != $assoc['pwdResetSelector'] || ctype_xdigit($validator) != $assoc['pwdResetToken'] ) {
    echo "<p>Vi kunne ikke validere din passordforespørsel.</p>";
    die;
} else {
    if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
        echo "<div class='positionText'>";
        echo "<br>";
        echo "<b><p>Skriv inn ønsket passord og bekreft det nye passordet i påfølgende felt. </b></p>";
        echo "<br> ";
        echo "</div>";
        ?>
    <form action="reset-password.inc.php" method="post">
        <div class="positionInput">
        <input type="hidden" name="selector" value="<?php echo $selector; ?>">
        <input type="hidden" name="validator" value="<?php echo $validator; ?>">
        <input type="password" name="pwd" placeholder="Skriv inn ditt passord...">
        <input type="password" name="pwd-repeat" placeholder="Gjenta ditt passord..."><br>
        <button class="butnn" type="submit" name="reset-password-submit">Resett passord</button></div>
    </form>
    </div>
        <?php
    }

}


?>