<?php 
session_start();

# Setter databasen 'nettkursportalen' som standardparameter dersom ingenting blir spesifisert. Forenkler funksjonaliteten i testingen.
function kobleTil ($databasenavn="nettkursportalen"){
	$vert = "localhost";
	$bruker = "root";
	$passord = "";
	
	$db = new mysqli($vert, $bruker, $passord, $databasenavn);
	return $db; 
}


function display_data($data) {
	$output = "<table>";
    foreach($data as $key => $var) {
        //$output .= '<tr>';
        if($key===0) {
            $output .= '<tr>';
            foreach($var as $col => $val) {
                $output .= "<td><strong>" . $col .  '</td></strong>';
            }
            $output .= '</tr>';
            foreach($var as $col => $val) {
                $output .= '<td>' . $val . '</td>' ;
            }
            $output .= '</tr>';
        }
        else {
            $output .= '<tr>';
            foreach($var as $col => $val) {
                $output .= '<td>' . $val . '</td>';
				
            }
            $output .= '</tr>';
        }
    }
        $output .= '</table>';
    echo $output ;
	
}


function color() {
	echo "<body style='background-color:lightgrey;'>";
}

function autentiser($tilkobling, $bruker, $pass){

	# Bruker spørsmålstegn ("placeholders") hvor det senere skal bindes variabler.
	$sqlsetning = "SELECT brukernavn, mail FROM brukere";
	$sqlsetning .= " WHERE brukernavn=?";
	$sqlsetning .= " AND passord=?";
		
	# Forbereder spørringen, det vil si lager en 'prepared statement'.
	$statement = $tilkobling->prepare($sqlsetning);

	# Binder innparametrene som skal sendes til databasen.
	# Første s betyr at brukernavn-feltet i spørringen er en tekststreng.
	# Andre s betyr at passord-feltet i spørringen er en tekststreng.
	$statement->bind_param("ss", $bruker, $pass);

	# Utfører spørringen
	$statement->execute();
	
	$statement->store_result();
	
	# Her kommer det et resultat tilbake når spørringen er utført. 
	# bindes til variablene 
	# Det må være nøyaktig match mellom antall felter etter SELECT og antall argumenter i bind_result().
	$statement->bind_result($bruker, $epost);

	# Til slutt gjør jeg selve innloggingssjekken ved å bruke objektvariabelen num_rows.
	# Hvis antall rader er 1 eller mer, så er brukeren logget inn.
	# I så fall settes noen session-statusvariabler som vist under.
	if ($statement->num_rows >= 1){
		$statement->fetch(); //her fylles altså alle variablene fra bind_result() ovenfor med innhold
		$_SESSION['innlogget'] = true;
		$_SESSION['brukernavn'] = $bruker; // fra bind_result
		$_SESSION['epost'] = $epost; // fra bind_result
		
	}

	# hvis ikke ok, så gjenspeiles det i session
	else {
		$_SESSION['innlogget'] = NULL;
		$_SESSION['brukernavn'] = NULL; //fordi ellers kan en snike seg inn
		$_SESSION['epost'] = NULL;
		return false;
	}

	# Lukk spørringen (prepared statement), viktig for ytelsen
	$statement->close();
	
	# Lukk databasetilkoblingen, viktig for ytelsen
    $tilkobling->close();

	return true; //hvis alt gikk bra
}//autentiser 
?>

<style>
.content-table {
	font-family: Courier;
	background: lightblue;
	opacity: .7;
	border-collapse: collapse;
	margin: 25px 5;
	width: 250px;
	border: 3px solid grey;
	font-size: 0.9em;
	border-radius: 5px 5px 0 0;
	overflow: auto;
	box-shadow: 0 80 80px rgba(0, 0, 0, 0.15);
	border-bottom-left-radius: 20px;
    border-top-left-radius: 20px;
	border-bottom-right-radius: 20px;
    border-top-right-radius: 20px;
	position: relative;
	margin-right: 1500px;
	right: -645px;
	top: -520px;
	padding: 5px;
	margin-bottom: -250px;
	max-height: 400px;
	min-height: 400px;
	height: 400px;

}
.content-table tr:hover {
    background-color: #E9F6F5;
}
.content-table tr {
    cursor: pointer;
}
.content-tablekurs {
	font-family: Courier;
	background: lightblue;
	border-collapse: collapse;
	border: 3px solid grey;
	margin: 25px 0;
	font-size: 0.9em;
	min-width: 400px;
	border-radius: 5px 5px 0 0;
	overflow: auto;
	box-shadow: 0 80 80px rgba(0, 0, 0, 0.15);
	border-bottom-left-radius: 15px;
    border-top-left-radius: 15px;
	border-bottom-right-radius: 15px;
    border-top-right-radius: 15px;
	position: relative;
	margin-right: 1400px;
	padding: 5px;
	margin-left: 10px;
}
.content-tablekurs tr:hover {
    background-color: #E9F6F5;
}
.content-tablekurs tr {
    cursor: pointer;
}

</style>

<?php
if (autoriserAdmin()) {
	echo "<div class='topnav'>";
  	echo "	<a class='active' href='index.php'>Hjem</a>";
  	echo "	<a href='nyttkurs.php'>Registrer nytt kurs</a>";
  	echo "	<a href='kursliste.php'>Vis kursliste</a>";
  	echo "	<a href='utlopt.php'>Status kurs / Påmelding</a>";
  	echo "	<a href='deltakeroversikt.php'>Deltakeroversikt</a>";
  	echo "	<a href='minprofil.php'>Min Side</a>";
} elseif (autoriser()) {
	echo "<div class='topnav'>";
	echo "	<a class='active' href='index.php'>Hjem</a>";
  	echo "	<a href='utlopt.php'>Status kurs / Påmelding</a>";
	echo "	<a href='deltakeroversikt.php'>Deltakeroversikt</a>";
  	echo "	<a href='minprofil.php'>Min Side</a>";
} else {
	echo "<div class='topnav'>";
	echo "	<a class='active' href='index.php'>Hjem</a>";
  	echo "	<a href='utlopt.php'>Status kurs / Påmelding</a>";
  	echo "	<a href='deltakeroversikt.php'>Deltakeroversikt</a>";
  	echo "	<a href='regbruker.php'>Ny bruker?</a>";
  	echo "	<a href='reset-password.php'>Glemt passord?</a>";
}
?>
<!--<div class="topnav">
  <a class="active" href="nyttkurs.php">Hjem</a>
  <a href="kursliste.php">Vis kursliste</a>
  <a href="utlopt.php">Status kurs / Påmelding</a>
  <a href="deltakeroversikt.php">Deltakeroversikt</a>
  <a href="regbruker.php">Ny bruker?</a>
  <a href="reset-password.php">Glemt passord?</a>
  <a href="minprofil.php">Min Side</a>-->
<style>


.center {
    color:white;
	/*position: relative;
	right: -590px;
	
	css for brukerinnlogging.
	float:left;*/
	text-align: right;
	
}

.search{
	width: 200px;
	float: left;
	margin-left: 0px;
	margin-bottom: -100px;
	margin-top: -3px;
	position: static;
}

.srch{
    font-family: 'Times New Roman';
    width: 230px;
    height: 30px;
    background: grey;
    border: 1px solid black;
    margin-top: 13px;
    color: white;
    border-right: none;
    font-size: 16px;
    float: left;
    padding: 10px;
    border-bottom-left-radius: 10px;
    border-top-left-radius: 10px;
	position: static;
	
}

.btn{
    width: 100px;
    height: 30px;
    background: #539E9E;
    border: 1px solid black;
    margin-top: 13px;
    color: white;
    font-size: 15px;
    border-bottom-right-radius: 10px;
    border-top-right-radius: 10px;
    transition: 1s ease;
    cursor: pointer;
	position: relative;
	top: -43px;   /* -57px*/
	right: -225px; /*-195px*/
}
.btn:hover{
    color: #000;
}

.btn:focus{
    outline: none;
}

.srch:focus{
    outline: none;
}

::placeholder {
	color:silver;
}

</style>
<form action="getsok.php" method="post"> 
<div class="search">
    <input class="srch" type="text" name="search" placeholder="Søk etter kurs i portalen...">
     <button class="btn" type="submit">Søk</button></a>
</div>
</form>
<form method='post' action=''>
	<style>
	.heightadjust {
		margin-top: -30px;
	}

</style>
<?php

  // Fjerner innloggingsalternativ dersom bruker allerede er logget inn. 
  if(autoriser()) {
		echo "<b><div class='heightadjust'><a href='loggut.php' style='float: right;'>Logg ut</a></div></b>";
		#echo "<b><div class='heightadjust'><a href='minprofil.php' style='float: right;'>Min Side</a></div></b>";
  } else {
	$brukernavn = $_SESSION['brukernavn'];
	echo "<form action='' method='post'>";
	?>
		<input type="hidden" id="uname" value="<?php echo $brukernavn ?> " >
		<?php
		?>
		<?php
		echo "<div class='center'>";
		echo "Brukernavn:";
		echo "<input type='text' name='bruker' />";
		echo "Passord:";
		echo "<input type='password' name='pass' />";
		echo "<input type='submit' name='logginn' value='Logg inn'>";
		echo "</div>";
		echo "</form>";
	}
?>
</div>
</form>
<link rel="stylesheet" type="text/css" href="menu.css">
<link rel="stylesheet" type="text/css" href="styling.css">

<?php 
$tilkobling = kobleTil();
$dbUserSession = kobleTil();
if (isset($_POST['logginn'])){
	$innloggingok = autentiser($tilkobling, $_POST['bruker'], $_POST['pass']);
	
	if ($innloggingok == true){
		header("Location:minprofil.php");
		$sessionUser = $_POST['bruker'];

		# Lager en enkel session-tabell som inneholder brukernavn på innlogga bruker. Denne infoen brukes for å gi ut unike kursavtaler i kalenderen.
		$sqlUser  = "UPDATE `session_brukernavn` SET brukernavn = '$sessionUser' WHERE id = '1';";
    	$resultatpwd = $dbUserSession->query($sqlUser);
	}
	else {
		echo "<h4>Feil innlogging, prøv igjen</h4>";
	}
}

function autoriser(){
	if (isset($_SESSION['innlogget'])  &&  $_SESSION['innlogget']  == true){
		return true;
	}
	else {
		return false;
	}
}

# Enkelte sider krever admin-tilgang, lager derfor en funksjon som verifiserer om admin-bruker er logget inn eller ikke. 
function autoriserAdmin() {
	if (isset($_SESSION['innlogget']) && $_SESSION['brukernavn'] == 'lars') {
		return true;
	}
	else {
		return false;
	}
}

function loggUt(){
	$_SESSION['innlogget'] = NULL;
	$_SESSION['brukernavn'] = NULL;
	$_SESSION['epost'] = NULL;
}
?>
