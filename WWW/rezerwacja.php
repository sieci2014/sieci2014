<?php
session_start();
require "config.php"; 
connection();

if (isset($_POST['execute']))
{
$data = date("y-m-d G:i:s");
$date_month = new DateTime($data);
$date_month->modify('+1 month');

$result = mysql_query('INSERT INTO zamowienie_ksiazka (ID_ks, Data_zam, Data_do_kiedy) VALUES ('.$_POST['execute'].', "2014-12-09", "2015-01-09")') or die(mysql_error());

$result = mysql_query('INSERT INTO zamowienie (ID) VALUES ('.$_SESSION['id'].')') or die(mysql_error());

mysql_query('UPDATE Ksiazka SET status=2 WHERE ID_ks='.$_POST['execute'].'');
?>
<h3>Ksi±¿ka zosta³a zarezerwowana</h3>
<p>Za chwilê nast±pi przekierowanie na stronê g³ówn±</p>
<?php
header("Refresh: 5; URL=uzytkownik.php");
}
?>
