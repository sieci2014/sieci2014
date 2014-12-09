<?php 
require "config.php"; 
connection(); 
session_start();

$haslo=$_POST['haslo'];
$typ=$_POST['typ'];
// Ochrona przed sql injection
$haslo = stripslashes($haslo);
$haslo = mysql_real_escape_string($haslo);

//sprawdzenie loginu i hasla
if ($typ==0)
{
 $sql = "SELECT ksiazka.ID_ks, autor.Imie_aut, autor.Nazwisko_aut, ksiazka.Tytul_ks, ksiazka.Wyd_ks, ksiazka.Rok_wyd, ksiazka.status FROM ksiazka, autor WHERE ksiazka.ID_autor = autor.ID_autor AND (Imie_aut LIKE '%$haslo%' OR Nazwisko_aut LIKE '%$haslo%')";
}
else
{
 $sql = "SELECT Login, Haslo FROM uzytkownik WHERE Login = '$username' AND Haslo = '$password'";
}

$result = mysql_query($sql)	or die(mysql_error());

//w razie poprawnego zalogowania zapisz dane w sesji i przejdz do strony glownej
if (mysql_num_rows($result)) 
{
	/*$_SESSION['zalogowany'] = true;
	$_SESSION['username'] = $_POST['login'];
	$_SESSION['password'] = $_POST['password'];*/
	
	while ( $db_field = mysql_fetch_assoc($result) ) {
       print $db_field['Tytul_ks'] . "<BR>";
       print $db_field['Imie_aut'] .' '.$db_field['Nazwisko_aut']."<BR>";
	   print $db_field['Wyd_ks'] . "<BR>";
	   print $db_field['Rok_wyd'] . "<BR>";
	   if ($db_field['status']=="0")
	   {
	   	 print "dostępna<BR>";
	   }else if ($db_field['status']=="1")
	   {
	     print "wypożyczona<BR>";
	   }else if ($db_field['status']=="2")
	   {
	     print "rezerwacja<BR>";
	   }
	   
	   

      }
}

?>