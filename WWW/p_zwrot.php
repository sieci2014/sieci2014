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
			<li><a href="p_szukaj.php">Szukaj</a></li>
			<li><a href="#" class="active">Zwrot</a></li>
			<li><a href="p_rejestracja.php">Rejestracja</a></li>
			<li><a href="wyloguj.php">Wyloguj</a></li>
		</ul>
	</div>
	<div id="menubottom"></div>

	
	<div id="content">

		<div id="normalcontent">
			<div class="contentarea">
				<!-- Normal content area start -->
				<p><h1>Zwroty</h1></p>
				<form name="form-szukaj" action="" method="post">
				<p><center><div id="button">Szukaj u użytkownika: <input type="text" name="haslo">&nbsp;
				<input type="submit" class="submit" name="submit" value="Szukaj" />
				
				</div>
				<div>Szukaj wg:&nbsp;&nbsp;<input type="radio" name="typ" value="0" checked="checked" /> imienia i nazwiska&nbsp;&nbsp;&nbsp;<input type="radio" name="typ" value="1"/>  numeru pesel
				</div>
				
				</center></p>
				</form>
				</br>
				
				<div>
				<?       
											                
                $haslo=$_POST['haslo'];
                // Ochrona przed sql injection
                $haslo = stripslashes($haslo);
                $haslo = mysql_real_escape_string($haslo);
                $typ=$_POST['typ'];
                 if($_POST['submit']) 
     			{  
				   if($typ==0)
				   {              
                 $sql = "SELECT uzytkownik.Imie, uzytkownik.Nazwisko, uzytkownik.Pesel, ksiazka.Tytul_ks, autor.Imie_aut, autor.Nazwisko_aut, zamowienie_ksiazka.Data_zam, zamowienie_ksiazka.Data_do_kiedy, zamowienie.ID_zam FROM uzytkownik, ksiazka, autor, zamowienie_ksiazka, zamowienie WHERE zamowienie.ID=uzytkownik.ID AND zamowienie.ID_zam=zamowienie_ksiazka.ID_zam AND zamowienie_ksiazka.ID_ks=ksiazka.ID_ks AND ksiazka.ID_autor=autor.ID_autor AND (uzytkownik.Imie LIKE '%$haslo%' OR uzytkownik.Nazwisko LIKE '%$haslo%')";
             	 }else if($typ==1)
				 {
				  $sql = "SELECT uzytkownik.Imie, uzytkownik.Nazwisko, uzytkownik.Pesel, ksiazka.Tytul_ks, autor.Imie_aut, autor.Nazwisko_aut, zamowienie_ksiazka.Data_zam, zamowienie_ksiazka.Data_do_kiedy, zamowienie.ID_zam FROM uzytkownik, ksiazka, autor, zamowienie_ksiazka, zamowienie WHERE zamowienie.ID=uzytkownik.ID AND zamowienie.ID_zam=zamowienie_ksiazka.ID_zam AND zamowienie_ksiazka.ID_ks=ksiazka.ID_ks AND ksiazka.ID_autor=autor.ID_autor AND (uzytkownik.Pesel LIKE '%$haslo%')";
				 }
				 }else
				 {
				 $sql = "SELECT uzytkownik.Imie, uzytkownik.Nazwisko, uzytkownik.Pesel, ksiazka.Tytul_ks, autor.Imie_aut, autor.Nazwisko_aut, zamowienie_ksiazka.Data_zam, zamowienie_ksiazka.Data_do_kiedy, zamowienie.ID_zam FROM uzytkownik, ksiazka, autor, zamowienie_ksiazka, zamowienie WHERE zamowienie.ID=uzytkownik.ID AND zamowienie.ID_zam=zamowienie_ksiazka.ID_zam AND zamowienie_ksiazka.ID_ks=ksiazka.ID_ks AND ksiazka.ID_autor=autor.ID_autor";
				 }
                $result = mysql_query($sql)	or die(mysql_error());
                
                //w razie poprawnego zalogowania zapisz dane w sesji i przejdz do strony glownej
                if (mysql_num_rows($result)) 
                {
                	print '<center><table cellpadding="0" cellspacing="0" class="db-table">';
					print '<tr><th>Tytuł</th><th>Autor</th><th>Wypożyczył</th><th>Pesel</th><th>Od</th><th>Do</th><th>Zwrot</th></tr>';
                	while ( $db_field = mysql_fetch_assoc($result) ) {
					   print '<tr><td>';
                       print $db_field['Tytul_ks'] . '</td><td>';
                       print $db_field['Imie_aut'] .' '.$db_field['Nazwisko_aut'].'</td><td>';
                	   print $db_field['Imie'] .' '.$db_field['Nazwisko']. '</td><td>';
                	   print $db_field['Pesel'] . '</td><td>';
					   print $db_field['Data_zam'] . '</td><td>';
					   print $db_field['Data_do_kiedy'] . '</td><td>';
	             	   print '<form name="form-zwrot" action="zwrot.php" method="post"><input type="hidden" name="zwroc" value="'.$db_field['ID_zam'].'"><div id="button"><input type="submit" class="submit" value="Zwrot" /></form></td></tr>';


                	   
                	   
                      }echo '</table></center>';
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