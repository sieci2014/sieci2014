<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php 
session_start();
if(!$_SESSION['id'])
{
	header("Refresh: 0; URL=index.php");
}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Biblio - system wypożyczeń bibliotek</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="stylesheet" type="text/css" href="default.css" />
</head>
<body>

<div id="upbg"></div>

<div id="outer">


	<div id="header">
		<div id="headercontent">
			<h1>Biblio</h1>
			<h2>System wypożyczeń bibliotek</h2>
		</div>
	</div>


	<div id="headerpic"></div>

	
	<div id="menu">
		<!-- HINT: Set the class of any menu link below to "active" to make it appear active -->
		<ul>
			<li><a href="pracownik.php">Strona główna</a></li>
			<li><a href="p_przegladaj.php">Przeglądaj</a></li>
			<li><a href="p_szukaj.php">Szukaj</a></li>
			<li><a href="p_zwrot.php">Zwrot</a></li>
			<li><a href="#" class="active">Rejestracja</a></li>
			<li><a href="wyloguj.php">Wyloguj</a></li>
		</ul>
	</div>
	<div id="menubottom"></div>

	
	<div id="content">

		<div id="normalcontent">
			<div class="contentarea">
				<!-- Normal content area start -->
				<p><h1>Rejestracja</h1></p><br />
				<form method="post" action="register.php">
				
				 <label for="imie">Imię:</label>
				 <input maxlength="32" type="text" name="imie" id="imie" /><br /><br />
				 
				 <label for="nazwisko">Nazwisko:</label>
				 <input maxlength="32" type="text" name="nazwisko" id="nazwisko" /><br /><br />

				 <label for="pesel">Pesel:</label>
				 <input maxlength="32" type="text" name="pesel" id="pesel" /><br /><br />
				 
				 <label for="login">Login:</label>
				 <input maxlength="32" type="text" name="login" id="login" /><br /><br />
				 
				 <label for="pass">Hasło:</label>
				 <input maxlength="32" type="password" name="pass" id="pass" /><br /><br />

				 <label for="pass_again">Hasło (ponownie):</label>
				 <input maxlength="32" type="password" name="pass_v" id="pass_again" /><br /><br />

				 <label for="email">Email:</label>
				 <input type="text" name="email" maxlength="50" id="email" /><br /><br />
				 
				 <label for="ulica">Ulica:</label>
				 <input type="text" name="ulica" maxlength="50" id="ulica" /><br /><br />

				 <label for="nrdomu">Nr domu:</label>
				 <input type="text" name="nrdomu" maxlength="5" id="nrdomu" /><br /><br />

				 <label for="nrmieszkania">Nr mieszkania:</label>
				 <input type="text" name="nrmieszkania" maxlength="5" id="nrmieszkania" /><br /><br />
				 
				 <label for="miasto">Miasto:</label>
				 <input type="text" name="miasto" maxlength="50" id="nrdomu" /><br /><br />
				 
				 <label for="kodpocztowy">Kod pocztowy:</label>
				 <input type="text" name="kodpocztowy" maxlength="10" id="kodpocztowy" /><br /><br />
				 
				 <input type="hidden" name="send" value="1" />
				 <input type="submit" value="Zarejestruj" />
				</form>
			</div></p>
				
				
				<!-- Normal content area end -->
			</div>
		</div>

	
		

	</div>

	<div id="footer">
			<div class="left">&copy; 2014 Biblio</div>
	</div>
	
</div>

</body>
</html>