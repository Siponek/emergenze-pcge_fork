<?php 

require('/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php');

$cf=$_GET['cf'];

$query = "UPDATE users.utenti_sistema SET telegram_attivo='t' where matricola_cf='".$cf."';";
$result = pg_query($conn, $query);

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>