<?php 
require "config.php"; 
connection(); 
session_start();

$username=$_POST['login'];
$password=sha1($_POST['password']);
// Ochrona przed sql injection
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
//sprawdzenie loginu i hasla
$sql = "SELECT ID, Rodzaj_uzytkownika FROM uzytkownik WHERE Login = '$username' AND Haslo = '$password'";
$result = mysql_query($sql)	or die(mysql_error());
//w razie poprawnego zalogowania zapisz dane w sesji i przejdz do strony glownej
if (mysql_num_rows($result)) 
{
	

	$uprawnienia = mysql_fetch_assoc($result);
	$_SESSION['log'] = true;
	$_SESSION['id'] = $uprawnienia["ID"];

	if ($uprawnienia["Rodzaj_uzytkownika"]=="czytelnik")
	{
		header("Refresh: 0; URL=uzytkownik.php");
	}
	else if ($uprawnienia["Rodzaj_uzytkownika"]=="pracownik")
	{
		header("Refresh: 0; URL=pracownik.php");
	}
	else
	{
		echo 'B³¹d. ';
	}
}
echo 'Podano z³e dane.';
?>
