<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
require "config.php"; 
connection(); 
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
			<li><a href="uzytkownik.php">Strona główna</a></li>
			<li><a href="#" class="active">Przeglądaj</a></li>
			<li><a href="u_szukaj.php">Szukaj</a></li>
			<li><a href="u_wypozyczenia.php">Wypożyczenia</a></li>
			<li><a href="wyloguj.php">Wyloguj</a></li>
		</ul>
	</div>
	<div id="menubottom"></div>

	
	<div id="content">

		<div id="normalcontent">
			<div class="contentarea">
				<!-- Normal content area start -->
				<p><h1>Przeglądaj</h1></p>
				<?php
										
					$SQL = "SELECT ksiazka.ID_ks, ksiazka.Tytul_ks, autor.Imie_aut, autor.Nazwisko_aut, ksiazka.Wyd_ks, ksiazka.Rok_wyd, ksiazka.status FROM ksiazka, autor WHERE ksiazka.ID_autor = autor.ID_autor";
					//$SQL = "SELECT * FROM ksiazka";
					$result = mysql_query($SQL);

					print '<center><table cellpadding="0" cellspacing="0" class="db-table">';
					print '<tr><th>Tytuł</th><th>Autor</th><th>Wydawnictwo</th><th>Rok wydania</th><th>Status</th><th>Rezerwacja</th></tr>';

					while ($db_field = mysql_fetch_assoc($result)) 
					{
					   print '<tr><td>';
                       print $db_field['Tytul_ks'] . '</td><td>';
                       print $db_field['Imie_aut'] . " " . $db_field['Nazwisko_aut'] . '</td><td>';
                	   print $db_field['Wyd_ks'] . '</td><td>';
                	   print $db_field['Rok_wyd'] . '</td><td>';
					   if ($db_field['status']=="0")
                	   {
                	      print "dostępna</td><td>";
				          print '<form action="rezerwacja.php" method="post">
												<input type="hidden" name="execute" value='.$db_field['ID_ks'].'>
												<input type="submit" value="Rezerwuj">
												</form></td></tr>';
                	   }
					   else if ($db_field['status']=="1")
                	   {
                	      print "wypożyczona</td><td></td></tr>";
                	   }
					   else if ($db_field['status']=="2")
                	   {
                	      print "rezerwacja</td><td></td></tr>";
                	   }
                	   
                    }
					print '</table></center>';

				?>
				
				
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
