<?php

/*********funkcja laczenie z baza danych***********/
function connection() 
{ 
    // serwer 
    $mysql_server = "localhost"; 
    // admin 
    $mysql_admin = "u694572259_sieci"; 
    // has³o 
    $mysql_pass = "sieci2014"; 
    // nazwa bazy 
    $mysql_db = "u694572259_sieci"; 
    // nawi±zujemy po³±czenie z serwerem MySQL 
    @mysql_connect($mysql_server, $mysql_admin, $mysql_pass) 
    or die('Brak po³±czenia z serwerem MySQL.'); 
    // ³±czymy siê z baz± danych 
    @mysql_select_db($mysql_db) 
    or die('B³±d wyboru bazy danych.');
		mysql_query("SET NAMES utf8");
		mysql_query("SET NAMES utf8 COLLATE utf8_polish_ci"); // polskie znaki 	
} 

function disconnection()
{
	mysql_close($mysql_db);
}

?>
