<?php
session_start();
include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';
$profilo=$_GET['p'];

$tipo=$_GET['t'];

if ($tipo==1){
	//squadre attive
	$filter= ' and num_componenti > 0 and id_stato < 3 ';
} else if($tipo==0){
	//squadre non attive
	$filter= ' and (num_componenti = 0 or id_stato = 3) ';
}

if(!$conn) {
    die('Connessione fallita !<br />');
} else {
	//$idcivico=$_GET["id"];
	$query="SELECT id,nome,stato,id_stato,num_componenti,componenti From \"users\".\"v_squadre\" where profilo='".$profilo."'::text ".$filter." ORDER BY  \"id_stato\", \"nome\" ;";
   //echo $query;
	$result = pg_query($conn, $query);
	#echo $query;
	#exit;
	$rows = array();
	while($r = pg_fetch_assoc($result)) {
    		$rows[] = $r;
    		//$rows[] = $rows[]. "<a href='puntimodifica.php?id=" . $r["NAME"] . "'>edit <img src='../../famfamfam_silk_icons_v013/icons/database_edit.png' width='16' height='16' alt='' /> </a>";
	}
	pg_close($conn);
	#echo $rows ;
	if (empty($rows)==FALSE){
		//print $rows;
		print json_encode(array_values(pg_fetch_all($result)));
	} else {
		echo "[{\"NOTE\":'No data'}]";
	}
}

?>


