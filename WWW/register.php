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
* Sprawd� czy podany przez u�ytkownika email, pesel lub login ju� istnieje
*/
$existsLogin = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM uzytkownik WHERE Login='$login' LIMIT 1"));
$existsEmail = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM uzytkownik WHERE Email='$email' LIMIT 1"));
$existsPesel = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM uzytkownik WHERE Pesel='$pesel' LIMIT 1"));

$errors = ''; // Zmienna przechowuj�ca list� b��d�w kt�re wyst�pi�y


// Sprawd�, czy nie wyst�pi�y b��dy
//if ($imie !='' || $nazwisko!='' || $pesel!='' || $login!='' || $pass!=''  || $pass_v!='' || $email!='' || $ulica!='' || $nrdomu!='' || $miasto!='' || $kodpocztowy!='' ) $errors .= '- Musisz wype�ni� wszystkie pola<br />';
if ($existsLogin[0] >= 1) $errors .= '- Ten login jest zaj�ty<br />';
if ($existsEmail[0] >= 1) $errors .= '- Ten e-mail jest ju� u�ywany<br />';
if ($existsPesel[0] >= 1) $errors .= '- Ten pesel jest ju� u�ywany<br />';
if ($pass != $pass_v)  $errors .= '- Has�a si� nie zgadzaj�<br />';

/**
	* Je�li wyst�pi�y jakie� b��dy, to je poka�
*/
if ($errors != '') 
{
	echo 'Rejestracja nie powiod�a si�, naci�nij wstecz i popraw nast�puj�ce b��dy:<br />'.$errors.'</p>';
}

/**
	* Je�li nie ma �adnych b��d�w - kontynuuj rejestracj�
*/
else 
{
	// Zapisz dane do bazy
	mysql_query("INSERT INTO uzytkownik (ID_biblioteka, Imie, Nazwisko, Pesel, Email, Login, Haslo, Rodzaj_uzytkownika, Ulica, Nr_domu, Nr_mie, Miasto, Kod_poczt) VALUES('1','$imie', '$nazwisko', '$pesel', '$email', '$login', '$pass', 'czytelnik', '$ulica', '$nrdomu', '$nrmieszkania', '$miasto', '$kodpocztowy')") or die ('Wyst�pi� b��d w zapytaniu i nie uda�o si� zarejestrowa� u�ytkownika.</p>');

	
}
}
?>
