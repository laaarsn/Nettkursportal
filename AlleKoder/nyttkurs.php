<?php
include "funksjoner.inc.php";
include "admin.inc.php";
color();
?>	
<?php

if(isset($_GET['Message'])){
    echo $_GET['Message'];
}

?>
<style>
.content .par{
    padding-left: 0px;
    padding-bottom: 40px;
    font-family: Arial;
    letter-spacing: 1.2px;
    line-height: 20px;
	color:silver;
	font-size: 15px;
	top: -130px;
	position: relative;
}

.content h2{
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

.btnskrift {
	color: black;
    font-family: 'georgia,garamond,serif';
    font-size: 20px;
    padding-left: 0px;
    margin-top: 0%;
    letter-spacing: 0.5px;
	position: relative;
	top: -2px;
	font-style:Verdana;
	left: 10px;
}

.img {
  background-image: url('images/laarsnbeach.jpg');
  padding: 140px 20px;
  text-align-last: left;
  background-repeat: no-repeat;
}
.btnn{
    width: 170px;
    height: 40px;
    background: #C6DDDC;
    border: none;
    margin-top: 30px;
    font-size: 18px;
    border-radius: 15px;
    cursor: pointer;
    color: #fff;
    transition: 0.4s ease;
    z-index: 999;
}
.btnn:hover{
    background: lightblue;
    color: #ff7200;
	transition: 1s ease;
}
.btnn a{
    text-decoration: none;
    color: #000;
    font-weight: bold;
}

.skjemafelt {
    opacity: 0.75;
}

textarea::placeholder {
    color:black;
    
}



</style>
<head><title>Forside</title>
</head>
<div class="img">
    <div class='content'>
        <h2>Skjema for kursregistrering</h2>
        <form action="reg_kurs.php"  method="post">
            <div class='par'>Navn på kurs (*):<br>
	        <input type="text" name="navn" alt="right"><br>
	        Maks antall deltakere (*):<br>
	        <input type="number" name="nummer"><br>
	        Påmeldingsfrist (YYYY-MM-DD) (*): <br>
	        <input type="text" name="dato"><br>
	        Pris for kurs (*):<br>
	        <input type="number" name="pris"><br>
            Oppstartsdato (*):<br>
            <input type="text" name="oppstart"><br>
            Sted (*):<br>
            <input type="text" name="sted"><br>
            Info om kurset (*):<br><div class="skjemafelt">
            <textarea cols=48 rows=6 name="info" placeholder="En kort beskrivelse av kurset. Kontaktperson, kontaktopplysninger etc..."></textarea><br></div>
	        <button class="btnn" type="submit"><div class="btnskrift">Registrer kurs</div></button>
	        <!--<div class="btnn"><input type="submit" name="knapp" value="Registrer kurs!"></div>-->
            </form>
        </div>
    </div>
</div>

<!--<div class="bunn">
    <h4><i>Kontakt:</i></h4>
</div>-->