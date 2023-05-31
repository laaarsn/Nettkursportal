<!-- addEventListener er en metode som kaller opp en funksjon dersom en klasse inneholder et gitt ord, 
i dette tilfellet 'visKnapp'. Dette gjør at man kan 'toggle' (vise / ikke vise) flere elementer (kurs i dette tilfellet) i et treff fra søkemotoren ved å veksle mellom ulike klasser.
Ved hjelp av denne metoden trenger man heller ikke å lage dynamiske klassenavn / ID'er i HTML.
-->

<script>
document.addEventListener("click",(e) => {
   const el = e.target;
   if(el.classList.contains("visKnapp")){
      el.nextElementSibling.classList.toggle("active") /* Dersom man klikker på knappen 'visKnapp' kan man toggle mellom klassene content-div og content-div.active */
   }
});
</script>

<style>
.signup {
    text-align: justify;
    margin-top: 5px;
    margin-bottom: 0px;

}

.content-div {
	display:none;
}

.visKnapp {
	border-radius: 8px;
}

/* viktig at denne klassen har samme navn som 'toggle-ordet' i addEventListener-metoden (active). */
.content-div.active { 
	display:block;
}
</style>


<?php
include "funksjoner.inc.php";
//include "topp.inc.php";
color();
$db = kobleTil();
$sqlkurs  = "SELECT * FROM kurs";
$resultat = $db->query($sqlkurs);
$resultat2 = $db->query($sqlkurs);

# Lager en variabel som bruker en funksjon som henter nåværende dato.
$t=time();

# Legger variabelen i en ny til å sørge for identisk format som den brukt i database.
$tt = date('Y-m-d', $t);

# Beregner lengde på tabellen 'kurs'. Brukes i for-loopen (den stopper opp når den har gått igjennom alle deltakere).
$sqlantall  = "SELECT COUNT(*) FROM kurs";
$resultatantall = $db->query($sqlantall);
echo "<hr />";
$len = mysqli_fetch_array($resultatantall)[0]; //samler resultat fra spørring i en array. må ta første index-verdi siden den kun inneholder ett element.

# Beregner lengden på antall registrerte påmeldinger.
$sqlantall2  = "SELECT COUNT(*) FROM kursstatus";
$resultatantall2 = $db->query($sqlantall2);
$len2 = mysqli_fetch_array($resultatantall2)[0];


?>

<form action="" method="get">
    <title> Påmelding kurs </title>
<h3><b> Velg fra nedtrekkslisten hvilket kursfilter du vil ha: </b></h3>
<p> Alternativet <i>'tilgjengelig for påmelding'</i> viser kurs man kan melde seg på: </p><br>
<select name="filter">
    <option selected="true" disabled="disabled">Velg alternativ</option>
    <option value='full'>Fulle kurs</option>
    <option value='ledig'>Ledige kurs</option>
    <option value='tilgjengelig'>Fremtidige kurs</option>
    <option value='utgaatt'>Utgåtte kurs</option>
    <option value='paamelding'>Tilgjengelig for påmelding</option>
    <input type='submit' name='filterknapp' value="Enter">
</select>
</form>
<?php 

# Aktiveres hvis kurs er utløpt (reg_deltaker.php).
if(isset($_GET['Messagetime'])){
    echo " ";
    echo $_GET['Messagetime'];
}

# Aktiveres hvis kurs er fullt (reg_deltaker.php).
if(isset($_GET['Messagefull'])){
    echo " ";
    echo $_GET['Messagefull'];
}

# Aktiveres hvis deltaker allerede er påmeldt (reg_deltaker.php). 
if(isset($_GET['alreadyMember'])){
    echo " ";
    echo $_GET['alreadyMember'];
}

# Aktiveres hvis man prøver å melde seg på et deaktivert kurs (reg_deltaker.php). 
if(isset($_GET['deaktivert'])){
    echo " ";
    echo $_GET['deaktivert'];
}

if (isset($_GET['filterknapp'])){

    # Alt 1. Kurs som er fullt.
    if ($_GET["filter"] == "full") {
        echo "<br>Kurs som dessverre er fullbooket fra kursoversikten: <br>";
        for ($i = 1; $i <= $len; $i++) {
            $sqlcount  = "SELECT COUNT(*) FROM kursstatus WHERE kurs_id LIKE $i"; // Beregner antall deltakere per kurs ved å bruke i-variabelen til å loope gjennom alle.
            $resultatcount = $db->query($sqlcount);
            $row = mysqli_fetch_array($resultatcount)[0]; // Henter resultat fra sql-spørring. Denne legges i en array og får index-verdi = 0.
            $sqlkurs  = "SELECT * FROM kurs WHERE kurs_id like $i"; // Bruker denne spørringen til å finne maks antall tillatte for alle kurs i tabellen.  
            $resultatkurs = $db->query($sqlkurs);
            $maksantall = $resultatkurs->fetch_assoc();

            # Hvis summen for antall påmeldte er større enn eller lik maks tillatt grense ---> kurs er fullt. 
            if ($row >= $maksantall['maksantall'] ) {
                echo "<br>" . $maksantall['kurs_id'] . "<b>" . " " . $maksantall['kursnavn'] . "</b><br>";
                echo "Antall påmeldte: <b>" . $maksantall['maksantall'] . "</b>";
                echo "<hr>";
            }
        }

    # Alt 2. Kurs som er i fremtiden.    
    } elseif ($_GET['filter'] == "tilgjengelig") {
        echo "<br>Her er kurs som <b>IKKE</b> har utløpt: <br><hr>";
        while ($nesteRad = $resultat->fetch_assoc()) {
            if ($nesteRad['dato'] > $tt) {
                echo "<br>" . $nesteRad['kurs_id']  ."<b>". " ". $nesteRad['kursnavn'] . "</b><br>";
                echo "<hr>";
            } 
        }

    # Alt 3. Utgåtte kurs for påmeldingsfrist.    
    } elseif ($_GET['filter'] == "utgaatt")  {
        echo "<br>Her er kurs som <b>HAR</b> har utløpt: <br><hr>";
        while ($nesteRad = $resultat->fetch_assoc()) {
            if ($nesteRad['dato'] < $tt) {
                echo "<br>" . $nesteRad['kurs_id']  ."<b>". " ". $nesteRad['kursnavn'] . "</b><br>";
                echo "Kurset gikk ut: <b>" . $nesteRad['dato'] . "</b>";
                echo "<hr>";
            } 
        }

    # Alt 4. Ikke fullt.    
    } elseif ($_GET['filter'] == "ledig") {
        echo "<br>Ledige kurs i kursoversikten: <br>";
        for ($i = 1; $i <= $len; $i++) {
            $sqlcount1  = "SELECT COUNT(*) FROM kursstatus WHERE kurs_id LIKE $i"; // beregner antall deltakere per kurs ved å bruke i-variabelen til å gå gjennom alle.
            $resultatcount1 = $db->query($sqlcount1);
            $row1 = mysqli_fetch_array($resultatcount1)[0];
            $sqlkurs1  = "SELECT * FROM kurs WHERE kurs_id like $i"; #Henter alle kurs fra kurs-tabellen.
            $resultatkurs1 = $db->query($sqlkurs1);
            $maksantall1 = $resultatkurs1->fetch_assoc();
            if ($row1 < $maksantall1['maksantall'] ) {
                echo "<br>" . $maksantall1['kurs_id'] . "<b>" . " " . $maksantall1['kursnavn'] . "</b><br>";
                echo "<hr>";
            }
        }

    # Alt 5. Både ledige plasser og ikke gått ut på dato -> klar for påmelding.
    } elseif ($_GET["filter"] == "paamelding") {
        echo "<br>Aktive kurs som verken er fullbooket eller utgått på dato: <br>";
        for ($j = 1; $j <= $len; $j++) {
            $sqlavailable  = "SELECT COUNT(*) FROM kursstatus WHERE kurs_id LIKE $j"; // beregner antall deltakere per kurs ved å bruke j-variabelen til å gå gjennom alle.
            $resultatavailable = $db->query($sqlavailable);
            $rowtilgjengelig = mysqli_fetch_array($resultatavailable)[0];
            $sqlkurstilgjengelig  = "SELECT * FROM kurs WHERE kurs_id LIKE $j"; #Henter alle kurs fra kurs-tabellen.
            $resultatkurstilgjengelig = $db->query($sqlkurstilgjengelig);
            $maksantalltilgjengelig = $resultatkurstilgjengelig->fetch_assoc();
               if ($rowtilgjengelig < $maksantalltilgjengelig['maksantall'] && $maksantalltilgjengelig['dato'] > $tt && $maksantalltilgjengelig['status'] == 'aktiv'  ) {
                    echo "<hr>";
                    $info = $maksantalltilgjengelig['info'];
                    echo "<form action='nydeltaker.php' method='post'>";
                    echo  "Kurs-ID: " . $maksantalltilgjengelig['kurs_id'] . "&nbsp <input type='submit' name='button' value='Påmelding'> ";
                    $idkurs = $maksantalltilgjengelig['kurs_id'];
                    $kursnavn = $maksantalltilgjengelig['kursnavn'];
                    echo "<br> Kursnavn: <b>"  . $maksantalltilgjengelig['kursnavn'] . "</b>"; 
                    echo "<br> Pris: <b>" . $maksantalltilgjengelig['pris'] . ",-</b>";
                    echo "<br> Frist: <b>" . $maksantalltilgjengelig['dato'] . "</b>";
                    echo "<br> Oppstart: <b>" . $maksantalltilgjengelig['oppstart'] . "</b>";
                    echo "<br> Oppmøtested: <b>" . $maksantalltilgjengelig['sted'] . "</b>";
                    $ledig = ($maksantalltilgjengelig['maksantall']-$rowtilgjengelig); // Regner ut antall ledige plasser. Praktisk å vite for brukerne.
                    echo "<br> Kapasitet: <b>" . $maksantalltilgjengelig['maksantall'] . "</b> (". $ledig . " ledige plasser)";
                    echo "<input type='hidden' name='id' value=$idkurs>"; // Sender kurs-id til påmeldingsside som 'hidden', slik at riktig kurs-id automatisk kommer opp for bruker. 
                    echo "<input type='hidden' name='kursnavn' value=$kursnavn>";
                    echo "</form>";
                    ?>
                    <button class="visKnapp">Vis/skjul info</button>
	                <div class="content-div">
                        <?php echo "<b>". $info. "</b>"; ?>	
	                </div>
                    <?php
                }
        }        
    }
} 


?>
