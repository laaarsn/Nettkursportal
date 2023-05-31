<?php 
include "funksjoner.inc.php";
color();
require ('phpmailer/includes/PHPMailer.php');
require ('phpmailer/includes/SMTP.php');
require ('phpmailer/includes/Exception.php');
?>

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
  padding: 140px 20px;
  text-align-last: left;
  background-repeat: no-repeat;
}

.buttonbtn {
    position: relative;
    top: -195px;
    border-bottom-right-radius: 5px;
    border-top-right-radius: 5px;
    left: -7px;
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
    top: -120px;
    font-weight: bold;
    font-size: 18px;
    color:silver;
}
</style>
<div class="imgpwd">
<title> Gjenoppretting passord </title>
<h1> Resett ditt passord </h1>
<p> En mail vil bli sendt til deg med instruksjoner om hvordan du resetter passord.</p>
<form action="reset-request.inc.php" method="post">
    <input class="pwd" type="text" name="email" placeholder="Skriv inn din mail-adresse...">
    <!--<input type="submit" name="reset-request-button" value="Send mail!">-->
    <button class="buttonbtn" type="submit" name="reset-request-submit">Motta mail!</button>
</form></div>
<?php
if(isset($_GET['Message'])){
    echo $_GET['Message'];
}

if (isset($_GET["reset"])) {
    if ($_GET['reset'] == "success") {
        echo '<p><b>Sjekk din mail for link til nytt passord!</p></b>';
    }
}
?>