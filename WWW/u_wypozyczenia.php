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
			<li><a href="u_przegladaj.php">Przeglądaj</a></li>
			<li><a href="u_szukaj.php">Szukaj</a></li>
			<li><a href="#" class="active">Wypożyczenia</a></li>
			<li><a href="wyloguj.php">Wyloguj</a></li>
		</ul>
	</div>
	<div id="menubottom"></div>

	
	<div id="content">

		<div id="normalcontent">
			<div class="contentarea">
				<!-- Normal content area start -->
				<p><h1>Wypożyczenia</h1></p>
				
				<?php
										
					$SQL = 'SELECT k.Tytul_ks, zk.ID_ks, zk.ID_zam, zk.Data_zam, zk.Data_do_kiedy FROM zamowienie_ksiazka zk, zamowienie z, ksiazka k WHERE z.ID='.$_SESSION["id"].' AND zk.ID_zam=z.ID_zam AND k.ID_ks = zk.ID_ks';
					
					
					
					$result = mysql_query($SQL) or die(mysql_error());
				
					
					print '<center><table cellpadding="0" cellspacing="0" class="db-table">';
					print '<tr><th>Tytuł</th><th>Od kiedy zarezerwowane</th><th>Do kiedy zarezerwowane</th></tr>';

					while ($db_field = mysql_fetch_assoc($result)) 
					{
					   print '<tr><td>';
                       print $db_field['Tytul_ks'] . '</td><td>';
                       print $db_field['Data_zam'] . '</td><td>';
                	     print $db_field['Data_do_kiedy'] . '</td></tr>';
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