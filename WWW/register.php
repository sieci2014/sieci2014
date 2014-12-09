<?php
session_start();
require "config.php"; 
connection();

if ($_POST['send'] == 1) 
{
// Zabezpiecz dane z formularza przed kodem HTML i ewentualnymi atakami SQL Injection
$imie = mysql_real_escape_string(htmlspecialchars($_POST['imie']));
$nazwisko = mysql_real_escape_string(htmlspecialchars($_POST['nazwisko']));
$pesel = mysql_real_escape_string(htmlspecialchars($_POST['pesel']));
$login = mysql_real_escape_string(htmlspecialchars($_POST['login']));
$pass = mysql_real_escape_string(htmlspecialchars($_POST['pass']));
$pass_v = mysql_real_escape_string(htmlspecialchars($_POST['pass_v']));
$email = mysql_real_escape_string(htmlspecialchars($_POST['email']));
$ulica = mysql_real_escape_string(htmlspecialchars($_POST['ulica']));
$nrdomu = mysql_real_escape_string(htmlspecialchars($_POST['nrdomu']));
$nrmieszkania = mysql_real_escape_string(htmlspecialchars($_POST['nrmieszkania']));
$miasto = mysql_real_escape_string(htmlspecialchars($_POST['miasto']));
$kodpocztowy = mysql_real_escape_string(htmlspecialchars($_POST['kodpocztowy']));

/**
* Sprawd¼ czy podany przez u¿ytkownika email, pesel lub login ju¿ istnieje
*/
$existsLogin = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM uzytkownik WHERE Login='$login' LIMIT 1"));
$existsEmail = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM uzytkownik WHERE Email='$email' LIMIT 1"));
$existsPesel = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM uzytkownik WHERE Pesel='$pesel' LIMIT 1"));

$errors = ''; // Zmienna przechowuj±ca listê b³êdów które wyst±pi³y


// Sprawd¼, czy nie wyst±pi³y b³êdy
//if ($imie !='' || $nazwisko!='' || $pesel!='' || $login!='' || $pass!=''  || $pass_v!='' || $email!='' || $ulica!='' || $nrdomu!='' || $miasto!='' || $kodpocztowy!='' ) $errors .= '- Musisz wype³niæ wszystkie pola<br />';
if ($existsLogin[0] >= 1) $errors .= '- Ten login jest zajêty<br />';
if ($existsEmail[0] >= 1) $errors .= '- Ten e-mail jest ju¿ u¿ywany<br />';
if ($existsPesel[0] >= 1) $errors .= '- Ten pesel jest ju¿ u¿ywany<br />';
if ($pass != $pass_v)  $errors .= '- Has³a siê nie zgadzaj±<br />';

/**
	* Je¶li wyst±pi³y jakie¶ b³êdy, to je poka¿
*/
if ($errors != '') 
{
	echo 'Rejestracja nie powiod³a siê, naci¶nij wstecz i popraw nastêpuj±ce b³êdy:<br />'.$errors.'</p>';
}

/**
	* Je¶li nie ma ¿adnych b³êdów - kontynuuj rejestracjê
*/
else 
{
	// Zapisz dane do bazy
	mysql_query("INSERT INTO uzytkownik (ID_biblioteka, Imie, Nazwisko, Pesel, Email, Login, Haslo, Rodzaj_uzytkownika, Ulica, Nr_domu, Nr_mie, Miasto, Kod_poczt) VALUES('1','$imie', '$nazwisko', '$pesel', '$email', '$login', '$pass', 'czytelnik', '$ulica', '$nrdomu', '$nrmieszkania', '$miasto', '$kodpocztowy')") or die ('Wyst±pi³ b³±d w zapytaniu i nie uda³o siê zarejestrowaæ u¿ytkownika.</p>');

	
}
}
?>
