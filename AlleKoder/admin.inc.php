<?php
$bruker = $_SESSION['brukernavn'];

//Forutsetter at funksjoner.inc.php er inkludert allerede (på siden som inkluderer denne)
if (autoriserAdmin()){
} else {
    color();
    echo "<b>Du har ikke tilgang til denne siden.</b><br>";
	exit("<b><a href='index.php'>Tilbake til Hovedside</a></b>");
}
?>