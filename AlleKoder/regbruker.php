<?php
include "funksjoner.inc.php";
color();


?>
<html>
<head><title>Innloggingssystem</title>
</head> 
<style>
.h {
  font-family:georgia,garamond,serif;
  font-size:18px;
  font-style:arial;
  color: silver;
  position: relative;
  top: -150px;
} 

.img {
  background-image: url('images/laarsnbeach.jpg');
  padding: 140px 20px;
  text-align-last: left;
  background-repeat: no-repeat;
}

.par{
  padding-left: 0px;
  padding-bottom: 0px;
  font-family: Arial;
  letter-spacing: 1.2px;
  line-height: 20px;
	color:silver;
	font-size: 15px;
	top: -150px;
	position: relative;
}

.farge {
  color: silver;
  font-size: 25px;
}

.btnskrift {
	color: black;
  font-family: 'georgia,garamond,serif';
  font-size: 20px;
  padding-left: 0px;
  margin-top: 0%;
  letter-spacing: .5px;
	position: relative;
	top: -2px;
	font-style:Verdana;
	left: 10px;
}
.btnn{
    width: 170px;
    height: 40px;
    background: #C6DDDC;
    border: none;
    margin-top: 20px;
    margin-bottom: -45px;
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

.color {
	color: #C6DDDC;
  position: relative;
  bottom: 75px;
  font-size: 20px;
}

h3 {
  position: relative;
  bottom: 100px;
}

</style>
</style>
<div class="img">
<body>
<div class="h">
<h1> Ny bruker </h1></div>
<div class="par">
<img src="images/greenfigur.png" color="silver" width="80" height="80"></h>
<form method='post' action='nybrukerdatabase.php'>
  Brukernavn:<br> <input type="text" name='bruker' />
  <br />
  Passord:<br> <input type='password' name='pass' />
  <br />
  Mail-adresse:<br> <input type="text" name="mail">
  <br />
  Fornavn:<br> <input type="text" name="fornavn">
  <br />
  Etternavn:<br> <input type="text" name="etternavn"><br>

  <button class="btnn" name="submitbttn" type="submit"><div class="btnskrift">Registrer bruker</div></button></div>
</form>

<?php 

if(isset($_GET['Message'])){
  echo $_GET['Message'];
}

if(isset($_GET['Oppdatert'])){
  echo '<div class="farge"';
  echo $_GET['Oppdatert'];
  echo "</div>";
}

if(isset($_GET['messageTaken'])){
  echo $_GET['messageTaken'];
}

if(isset($_GET['passordUnderkjent'])){
  echo $_GET['passordUnderkjent'];
}

?>
</body> 
</html> 