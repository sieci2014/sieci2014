<?php 
require "config.php"; 
connection(); 
session_start();

$id=$_POST['zwroc'];

//sprawdzenie loginu i hasla
$sql = "DELETE zamowienie , zamowienie_ksiazka  FROM zamowienie  INNER JOIN zamowienie_ksiazka WHERE zamowienie.ID_zam = zamowienie_ksiazka.ID_zam AND zamowienie.ID_zam = '$id'";
$result = mysql_query($sql)	or die(mysql_error());
//w razie poprawnego zalogowania zapisz dane w sesji i przejdz do strony glownej
	header("Refresh: 0; URL=p_zwrot.php");
?>
