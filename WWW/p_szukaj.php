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
			<li><a href="pracownik.php">Strona główna</a></li>
			<li><a href="p_przegladaj.php">Przeglądaj</a></li>
			<li><a href="#" class="active">Szukaj</a></li>
			<li><a href="p_zwrot.php">Zwrot</a></li>
			<li><a href="p_rejestracja.php">Rejestracja</a></li>
			<li><a href="wyloguj.php">Wyloguj</a></li>
		</ul>
	</div>
	<div id="menubottom"></div>

	
	<div id="content">

		<div id="normalcontent">
			<div class="contentarea">
				<!-- Normal content area start -->
				<p><h1>Szukaj</h1></p>
				<form name="form-szukaj" action="" method="post">
				<p><center><div id="button"><input type="text" name="haslo">&nbsp;
				<input type="submit" class="submit" name="submit" value="Szukaj" />
				
				</div>
				<div>Szukaj wg:&nbsp;&nbsp;<input type="radio" name="typ" value="0" checked="checked" /> autora&nbsp;&nbsp;&nbsp;<input type="radio" name="typ" value="1"/>  tytułu
				</div>
				</center></p>
				</form>
				</br>
				
				<div>
				<?       
     			if($_POST['submit']) 
     			{           		  
                
                $haslo=$_POST['haslo'];
                $typ=$_POST['typ'];
                // Ochrona przed sql injection
                $haslo = stripslashes($haslo);
                $haslo = mysql_real_escape_string($haslo);
                if ($haslo!="")
				{
                
                if ($typ==0)
                {
                 $sql = "SELECT ksiazka.ID_ks, autor.Imie_aut, autor.Nazwisko_aut, ksiazka.Tytul_ks, ksiazka.Wyd_ks, ksiazka.Rok_wyd, ksiazka.status FROM ksiazka, autor WHERE ksiazka.ID_autor = autor.ID_autor AND (Imie_aut LIKE '%$haslo%' OR Nazwisko_aut LIKE '%$haslo%')";
                }
                else
                {
                 $sql = "SELECT ksiazka.ID_ks, autor.Imie_aut, autor.Nazwisko_aut, ksiazka.Tytul_ks, ksiazka.Wyd_ks, ksiazka.Rok_wyd, ksiazka.status FROM ksiazka, autor WHERE ksiazka.ID_autor = autor.ID_autor AND Tytul_ks LIKE '%$haslo%'";
                }
                
                $result = mysql_query($sql)	or die(mysql_error());
                
                //w razie poprawnego zalogowania zapisz dane w sesji i przejdz do strony glownej
                if (mysql_num_rows($result)) 
                {
                	/*$_SESSION['zalogowany'] = true;
                	$_SESSION['username'] = $_POST['login'];
                	$_SESSION['password'] = $_POST['password'];*/
                	print '<center><table cellpadding="0" cellspacing="0" class="db-table">';
					print '<tr><th>Tytuł</th><th>Autor</th><th>Wydawnictwo</th><th>Rok wydania</th><th>Status</th></tr>';
                	while ( $db_field = mysql_fetch_assoc($result) ) {
					   print '<tr><td>';
                       print $db_field['Tytul_ks'] . '</td><td>';
                       print $db_field['Imie_aut'] .' '.$db_field['Nazwisko_aut'].'</td><td>';
                	   print $db_field['Wyd_ks'] . '</td><td>';
                	   print $db_field['Rok_wyd'] . '</td><td>';
                	   if ($db_field['status']=="0")
                	   {
                	   	 print "dostępna</td></tr>";
                	   }else if ($db_field['status']=="1")
                	   {
                	     print "wypożyczona</td></tr>";
                	   }else if ($db_field['status']=="2")
                	   {
                	     print "rezerwacja</td></tr>";
                	   }
                	   
                      }echo '</table></center>';
                }}else{}

                
    	   		} 
	   	   		?> 

				</div>
				
				
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