<?php                
require 'database_connection.php';
#include "funksjoner.inc.php";
#$navn = $_SESSION['brukernavn']; 
$event_name = $_POST['event_name'];
$event_start_date = date("y-m-d", strtotime($_POST['event_start_date'])); 
$event_end_date = date("y-m-d", strtotime($_POST['event_end_date'])); 

# Henter ut detaljer på innlogga bruker, og lagrer infoen i en array.
$sqlUser = "SELECT brukernavn from session_brukernavn where id = '1'";
$resultatUser = $con->query($sqlUser);
$stored = mysqli_fetch_array($resultatUser)[0];

$uname = $_POST['username'];
# Avtale / kurs blir kun lagret for inneværende bruker. 
$insert_query = "insert into `calendar_event_master`(`event_name`,`event_start_date`,`event_end_date`,`brukernavn`) values ('".$event_name."','".$event_start_date."','".$event_end_date."','".$stored."')";             
if(mysqli_query($con, $insert_query))
{
	$data = array(
                'status' => true,
                'msg' => 'Kurs eller avtale er lagret!'
            );
}
else
{
	$data = array(
                'status' => false,
                'msg' => 'En feil oppstod. Prøv på nytt!'				
            );
}
echo json_encode($data);
?>
