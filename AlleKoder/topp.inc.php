<style>
.content .par{
    padding-left: 0px;
    padding-bottom: 40px;
    font-family: Arial;
    letter-spacing: 1.2px;
    line-height: 20px;
	color:silver;
	font-size: 50px;
	top: -130px;
	position: relative;
}

.content h1{
    font-family: 'georgia,garamond,serif';
    font-size: 20px;
    padding-left: 0px;
    margin-top: 0%;
    letter-spacing: 2px;
	color:#C6DDDC;
	position: relative;
	top: -120px;
	font-style:Verdana;
}

.content h2{
    font-family: 'georgia,garamond,serif';
    font-size: 50px;
    padding-left: 0px;
    margin-top: 0%;
    letter-spacing: 2px;
	color:#C6DDDC;
	position: relative;
	top: -150px;
	font-style:Verdana;
}

.img {
  background-image: url('images/laarsnbeach.jpg');
  padding: 140px 20px;
  text-align-last: left;
  background-repeat: no-repeat;
  width: 1700px;
  position: relative;
  left: -10px;
}	

</style>

<?php
$bruker = $_SESSION['brukernavn'];
//Forutsetter at funksjoner.inc.php er inkludert allerede (p� siden som inkluderer denne)
if (autoriser()){
	echo "<div class='content'>";
	echo "<div class='img'>";
	echo "<h1>Velkommen til</h1><br>";
	echo "<div class='par'>Min Side</div>";
    echo "<h2>";
    echo $bruker . "!</h2>";
	echo "</p>";
	echo "</div>";
	echo "</div>";
}
else {
    color();
    echo "<b>Innloggingsøkt utgått. Du må logge inn på nytt.</b><br>";
	exit("<b><a href='index.php'>Logg inn</a></b>");
}
?>