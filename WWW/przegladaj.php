<?php
require "config.php"; 
connection(); 
session_start();

$SQL = "SELECT * FROM ksiazka";
$result = mysql_query($SQL);

while ($db_field = mysql_fetch_assoc($result)) 
{
	print $db_field['Tytul_ks'] . "<BR>";
	print $db_field['Wyd_ks'] . "<BR>";
	print $db_field['Rok_wyd'] . "<BR>";
	print $db_field['Opis_ks'] . "<BR>";

}

?>
