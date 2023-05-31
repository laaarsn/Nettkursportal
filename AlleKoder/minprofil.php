<?php 
include "funksjoner.inc.php";
include "topp.inc.php";
color();
$navn = $_SESSION['brukernavn'];
?>

<div class="ramme">
<h3> Velkommen til  Min Side <h3> <?php echo $navn; ?> </h3>
</div>

Her kan du endre på kontodetaljene: <br>
<form action="" method="POST">
<select name="alternativ">
    <option selected="true" disabled="disabled">Velg alternativ</option>
    <option value='username'>Brukernavn</option>
    <option value='pwd'>Passord</option>
    <option value='mail'>E-post</option>
    <option value='fnavn'>Fornavn</option>
    <option value='enavn'>Etternavn</option>
</select>
<input type="submit" name="enterknapp" value="Velg">
</form>
<?php
if (isset($_POST['enterknapp'])) {

    # Ved endring av personalia kommer det opp et popup-vindu som flytter på ulike elementer. Angir derfor en del nye posisjonsregler i css.
    echo "<style>";
        echo ".calendar {
            color: silver;
            position: relative;
            bottom: 368px;
            left: 810px;
            line-height: 5px;
        }";
        echo ".kursposition 
        {
        position: relative;
        bottom: 370px;
        }";
        echo ".icon {
            position: relative;
            bottom: 373px;
            left: 840px;
        }";
        echo ".content-tableprofil {
            font-family: Courier;
            background: lightblue;
            border-collapse: collapse;
            border: 3px solid grey;
            margin: auto;
            font-size: 0.9em;
            width: 390px;
            min-width: 300px;
            overflow: auto;
            box-shadow: 0 80 80px rgba(0, 0, 0, 0.15);
            border-radius: 25px;
            position: relative;
            margin-right: 1400px; 
            padding: 5px 15px;
            margin-left: 10px;
            margin-bottom: -150px;
            top: 400px;
            left: 493px;
            max-height: 180px;
            min-height: 180px;
            height: 180px;
        }";
        echo ".graf {
            color: silver;
            position: relative;
            bottom: 593px;
            left:805px;
            line-height: 5px;
        }";
        echo ".igraf {
            position: relative;
            bottom: 593px;
            left: 840px;
        }";
        echo "</style>";
    if ($_POST['alternativ'] == "pwd") {
        echo "<form action='endreprofil.php' method='POST'>";
        echo "Skriv inn nytt passord: <br>";
        echo "<input type='password' name='passord'>";
        echo "<input type='submit' name='passordbutton' value='Send inn'>";
        echo "</form>";
    } elseif ($_POST['alternativ'] == "username") {
        echo "<form action='endreprofil.php' method='POST'>";
        echo "Skriv inn nytt brukernavn: <br>";
        echo "<input type='text' name='brukernavn'>";
        echo "<input type='submit' name='userbutton' value='Send inn'>";
        echo "</form>";
    } else if ($_POST['alternativ'] == "mail") {
        echo "<form action='endreprofil.php' method='POST'>";
        echo "Skriv inn ny mail-adresse: <br>";
        echo "<input type='text' name='epost'>";
        echo "<input type='submit' name='mailbutton' value='Send inn'>";
        echo "</form>";
    } else if ($_POST['alternativ'] == "fnavn") {
        echo "<form action='endreprofil.php' method='POST'>";
        echo "Skriv inn nytt fornavn: <br>";
        echo "<input type='text' name='fornavn'>";
        echo "<input type='submit' name='fnavnbutton' value='Send inn'>";
        echo "</form>";
    } else if ($_POST['alternativ'] == "enavn") {
        echo "<form action='endreprofil.php' method='POST'>";
        echo "Skriv inn nytt etternavn: <br>";
        echo "<input type='text' name='etternavn'>";
        echo "<input type='submit' name='enavnbutton' value='Send inn'>";
        echo "</form>";
    }
}

?>

<?php 
$db = kobleTil();

if(isset($_GET['userTaken'])){
    echo " ";
    echo $_GET['userTaken'];
}

if(isset($_GET['mailTaken'])){
    echo " ";
    echo $_GET['mailTaken'];
}
# Lengde i for-loop for kurs
$kurslength = "SELECT COUNT(*) FROM kurs";
$resultatlength = $db->query($kurslength);
$len = mysqli_fetch_array($resultatlength)[0];

# Lengde i nested for-loop deltakere
$deltakerlength = "SELECT COUNT(*) from kursstatus";
$resultatldeltakerlength = $db->query($deltakerlength);
$len2 = mysqli_fetch_array($resultatldeltakerlength)[0];

# Brukes for å hente kurs lengst ned på profilsiden.
$sql = "SELECT * FROM kursstatus WHERE brukernavn = '$navn';";

# Brukes for å info i tabell på Min Side. Forener kurs- og kursstatus-tabell gjennom fellesatributt 'kurs_id'. 
$sql4 = "select k.kursnavn, oppstart, sted from kurs k, kursstatus ks where k.kurs_id = ks.kurs_id and brukernavn = '$navn';";

$resultatsql = $db->query($sql);
$resultatsql5 = $db->query($sql4);

# Brukes for å avgjøre om tabell skal vises eller ikke. Tom ordliste -> ingen tabell. Minst ett element i ordliste -> tabell vises. 
$sqlsettle = "SELECT * from kursstatus where brukernavn = '$navn'";
$resultatsettle = $db->query($sqlsettle);
$assoc = $resultatsettle->fetch_assoc();

$test = "<hr>";
# Ingen vits i å vise en stor tom tabell dersom ingen kurs er registrert.
if (empty($assoc['kursnavn'])) {

} else {
    # Dersom array ikke er tom så vises tabell over registrert(e) kurs.
    echo "<div class='content-tableprofil'>";
    display_data($resultatsql5);
    echo "</div>";
}

?>
<div class="calendar">
<h4> Legg til kurs  </h4>
<h4> i Din Kalender </h4>
</div>
<!--<img src="images/calendar.png" color="silver" width="80" height="80">-->
<div class="icon">
<a href="http://localhost/Prosjekt/dynamic-full-calendar.php"> <img src="images/calendar3blue.png" alt="kalender" width="40" height="40"></a>
</div>
<div class="graf">
<h4> Se statistikk på  </h4>
<h4> deltakeroversikt </h4>
</div>
<div class="igraf">
<a href="http://localhost/Prosjekt/graph.php"> <img src="images/charts.png" alt="grafer" width="40" height="40"></a>
</div>

       <!-- #echo "<form action='dynamic-full-calendar.html' method='post'>";
        ##echo "<input type='hidden' name='navn' value='$navn'>";
        #echo "<button type='submit'>";
        #echo "<img src='images/calendar2.png' alt='buttonpng' width='90' height='90' />";
        #echo "</button>";
        #echo "</div>";-->
<?php

# Henter brukernavn på inneværende bruker for å finne riktig profilbilde fra databasen. 
$user = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM bilde_user WHERE brukernavn = '$navn'"));
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Nettkursportalen: Min Side</title>
    <link rel="stylesheet" href="styling.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <?php

    # Ny posisjonering for div. elementer ved null registrerte kurs (0 kurs = ingen tabell), siden dette gir nye forutsetniger for posisjonering. 
    # Angir ikke disse sammen med oppdaterte css-regler lenger opp, da stylesheet-referansen ovenfor ville ha overkjørt reglene. 
    if (empty($assoc['kursnavn'])) {
        echo "<style>";
        echo ".upload{
            width: 125px;
            position: relative;
            margin: auto;
            left: -850;
            top: -666;
        }";
        echo ".kursposition {
            position: relative;
            bottom: 355px;
            }";
        echo ".calendar {
            color: silver;
            position: relative;
            bottom: 261px;
            left: 810px;
            line-height: 5px;
            }";
        echo ".icon {
            position: relative;
            bottom: 268px;
            left: 840px;
            }";
        
        echo ".graf {
            color: silver;
            position: relative;
            bottom: 488px;
            left:800px;
            line-height: 5px;
        }";
        echo ".igraf {
            position: relative;
            bottom: 487px;
            left: 840px;
            opacity: .9;
        }";
        echo "</style>";
    } if (isset($_POST['enterknapp']) && empty($assoc['kursnavn']) ) {
        echo "<style>";
        echo ".upload{
            width: 125px;
            position: relative;
            margin: auto;
            left: -850;
            top: -721;
        }";
        echo ".kursposition {
            position: relative;
            bottom: 370px;
            }";
        echo ".calendar {
            color: silver;
            position: relative;
            bottom: 314px;
            left: 810px;
            line-height: 5px;
        }";
        echo ".icon {
            position: relative;
            bottom: 321px;
            left: 840px;
        }";
    
    echo ".graf {
        color: silver;
        position: relative;
        bottom: 541px;
        left:800px;
        line-height: 5px;
    }";
    echo ".igraf {
        position: relative;
        bottom: 540px;
        left: 840px;
        opacity: .9;
    }";
    echo "</style>";
    } elseif (isset($_POST['enterknapp']) && !empty($assoc['kursnavn']) ) {
        echo "<style>";
        echo ".calendar {
            color: silver;
            position: relative;
            bottom: 368px;
            left: 810px;
            line-height: 5px;
        }";
        echo ".kursposition 
        {
        position: relative;
        bottom: 370px;
        }";
        echo ".icon {
            position: relative;
            bottom: 373px;
            left: 840px;
        }";
        echo ".content-tableprofil {
            font-family: Courier;
            background: lightblue;
            border-collapse: collapse;
            border: 3px solid grey;
            margin: auto;
            font-size: 0.9em;
            width: 390px;
            min-width: 300px;
            overflow: auto;
            box-shadow: 0 80 80px rgba(0, 0, 0, 0.15);
            border-radius: 25px;
            position: relative;
            margin-right: 1400px; 
            padding: 5px 15px;
            margin-left: 10px;
            margin-bottom: -150px;
            top: -705px;
            left: 475px;
            max-height: 180px;
            min-height: 180px;
            height: 180px;
        }";
        echo ".graf {
            color: silver;
            position: relative;
            bottom: 593px;
            left:805px;
            line-height: 5px;
        }";
        echo ".igraf {
            position: relative;
            bottom: 593px;
            left: 840px;
        }";
        echo ".upload{
            width: 125px;
            position: relative;
            margin: auto;
            left: -850;
            top: -755;
        }";
        echo ".kursposition {
            position: relative;
            bottom: 420px;
        }";
        echo "</style>";
    }
    ?>
  </head>
  <body>
  <!-- Bruker multipart/form-data når 'input_type' inkluderer filer. -->
    <form class="form" id = "form" action="" enctype="multipart/form-data" method="post">
      <div class="upload">
        <?php
        $id = $user["id"];
        $name = $user["name"];
        $image = $user["image"];
        ?>
        <img src="images/<?php echo $image; ?>" width = 125 height = 125 title="<?php echo $image; ?>">
        <div class="round">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <input type="hidden" name="name" value="<?php echo $name; ?>">
          <input type="file" name="image" id = "image" accept=".jpg, .jpeg, .png">
          <i class = "fa fa-camera" style = "color: black; position: relative; top: 8px; cursor: pointer;"></i>
        </div>
      </div>
    </form>
    <script type="text/javascript">
      document.getElementById("image").onchange = function(){
          document.getElementById("form").submit();
      };
    </script>
    <?php
    if(isset($_FILES["image"]["name"])){
      $id = $_POST["id"];
      $name = $_POST["name"];

      $imageName = $_FILES["image"]["name"];
      $imageSize = $_FILES["image"]["size"];
      $tmpName = $_FILES["image"]["tmp_name"];

      // Tillatte bildetyper.
      $validImageExtension = ['jpg', 'jpeg', 'png'];

      # Bruker explode-funksjonen for å få tak i filutvidelsen. Angir hvor "explode" skal skje, altså etter punktummet.
      $imageExtension = explode('.', $imageName);

      # For å være sikker omgjør jeg alle navn til små bokstaver (noen filnavn kan nemlig ha store bokstaver), og henter filutvidelse ved å bruke 'end' (alt etter exploden).
      $imageExtension = strtolower(end($imageExtension));

      # Sjekker at fil har riktig format (jpg, jpeg, png...). in_array() sjekker om en angitt verdi eksisterer i en forhåndsgitt ordliste.
      if (!in_array($imageExtension, $validImageExtension)){
        echo
        "
        <script>
          alert('Feil bildeformat');
          document.location.href = '../Prosjekt/minprofil.php';
        </script>
        ";
      }

      # Tilsvarer 1.14 mb. Filen kan ikke overskride denne grensen.  
      elseif ($imageSize > 1200000){
        echo
        "
        <script>
          alert('Filen er for stor');
          document.location.href = '../Prosjekt/minprofil.php';
        </script>
        ";
      }
      else{

        #Angir nytt unikt navn på profilbilde. Legger  også på riktig filutvidelse.
        $newImageName = $name . " - " . date("Y.m.d") . " - " . date("h.i.sa"); 
        $newImageName .= '.' . $imageExtension;
        $query = "UPDATE bilde_user SET image = '$newImageName' WHERE brukernavn = '$navn'";
        mysqli_query($db, $query);
        move_uploaded_file($tmpName, 'images/' . $newImageName);
        echo
        "
        <script>
        document.location.href = '../Prosjekt/minprofil.php';
        </script>
        ";
      }
    }
?>
  </body>
</html>
<?php

$sqlinfo = "SELECT brukernavn, mail, fornavn, etternavn from brukere where brukernavn = '$navn'";
$resultatInfo = $db->query($sqlinfo);

#echo "<div class='content-tableCredentials'>";
#display_data($resultatInfo);
#echo "</div>";
echo "<div class='kursposition'>";
echo "<b>Du er påmeldt disse kursene:</b> <br>";
while($nesteRad = $resultatsql->fetch_assoc()){
    $kursid = $nesteRad['kurs_id'];
    $brukerid = $nesteRad['bruker_id'];
    $kursnavn = $nesteRad['kursnavn'];
    echo "<form action='avmelding.php' method='post'>";
    echo "<input type='hidden' name='bruker_id' value='$brukerid'>";
    echo "<input type='hidden' name='kurs_id' value='$kursid'>";
    echo "<input type='hidden' name='kursnavn' value='$kursnavn'>";
	echo "<br><b>" . $nesteRad['kursnavn'] . "<br>";
    echo "<input type='submit' name='knapp' value='Avregistrer'><br>";
    echo "</form>";
	echo "<hr style='width:5%;text-align:left;margin-left:0'>";
}
echo "</div>";
?>

