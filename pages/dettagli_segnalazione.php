<?php 
$id=$_GET["id"];
$subtitle="Dettagli segnalazione n. ".$id;


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="roberto" >

    <title>Gestione emergenze</title>
<?php 
require('./req.php');

require('/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php');

require('./check_evento.php');
?>
    
</head>

<body>

    <div id="wrapper">

        <?php 
            require('./navbar_up.php')
        ?>  
        <?php 
            require('./navbar_left.php')
        ?> 
            

        <div id="page-wrapper">
            <!--div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Titolo pagina</h1>
                </div>
            </div-->
            <!-- /.row -->
            
            <br><br>
            <div class="row">
            <div class="col-md-6">
				<?php
					$query= "SELECT *, st_x(st_transform(geom,4326)) as lon , st_y(st_transform(geom,4326)) as lat FROM segnalazioni.v_segnalazioni WHERE id=".$id.";";
					//echo $query;
					$result=pg_query($conn, $query);
					while($r = pg_fetch_assoc($result)) {
					?>            
            
               <h4><br><b>Tipo criticità</b>: <?php echo $r['criticita']; ?></h4>
               <hr>
            	
						
						<?php 
						// controllo se ci sono altre segnalazioni sullo stesso civico
						$check_civico=0;
						$query_civico="SELECT * FROM segnalazioni.v_segnalazioni where id_civico=".$r['id_civico']." and id !=".$id.";";
						$result_civico=pg_query($conn, $query_civico);
								while($r_civico = pg_fetch_assoc($result_civico)) {
									$check_civico=1;
									?>
									Altre segnalazioni sullo stesso civico:
									<div class="panel-group">
									  <div class="panel panel-default">
									    <div class="panel-heading">
									      <h4 class="panel-title">
									        <a data-toggle="collapse" href="#c_civico_s<?php echo $r_civico['id'];?>"> <?php echo $r['criticita'];?></a>
									      </h4>
									    </div>
									    <div id="c_civico_s<?php echo $r_civico['id'];?>" class="panel-collapse collapse">
									      <div class="panel-body"-->
									<?php
										echo $r_civico["descrizione"];
									?>
									<button class="btn"> Unisci segnalazione. </button>
									</div>
						    </div>
						  </div>
						</div>
								<?php	
								}
						 if($check_civico==0 and $r['id_civico']!=''){
						 	echo "Non ci sono altre segnalazioni in corrispondenza dello stesso civico.<br><br>";
						 }
						 ?>
						 
						 
						 <?php 
						// controllo se ci sono altre segnalazioni nelle vicinanze
						$check_vic=0;
						if ($r['id_civico']!=''){
							$query_vic="SELECT * FROM segnalazioni.v_segnalazioni where st_distance(st_transform('".$r['geom']."'::geometry(point,4326),3003),st_transform(geom,3003))< 200 and id_evento=".$r['id_evento']." and (id_civico!=".$r['id_civico']." or id_civico is null) and id !=".$id.";";
						} else {
							$query_vic="SELECT * FROM segnalazioni.v_segnalazioni where st_distance(st_transform('".$r['geom']."'::geometry(point,4326),3003),st_transform(geom,3003))< 200 and id_evento=".$r['id_evento']." and id !=".$id.";";
						}
						//echo $query_vic."<br>";
						$result_vic=pg_query($conn, $query_vic);
								while($r_vic = pg_fetch_assoc($result_vic)) {
									$check_vic=1;
									?>
									Altre segnalazioni nelle vicinanze:
									<div class="panel-group">
									  <div class="panel panel-default">
									    <div class="panel-heading">
									      <h4 class="panel-title">
									        <a data-toggle="collapse" href="#c_civico_s<?php echo $r_vic['id'];?>"> <?php echo $r['criticita'];?></a>
									      </h4>
									    </div>
									    <div id="c_civico_s<?php echo $r_vic['id'];?>" class="panel-collapse collapse">
									      <div class="panel-body"-->
									<?php
										echo $r_civico["descrizione"];
									?>
									<button class="btn"> Unisci segnalazione. </button>
									</div>
						    </div>
						  </div>
						</div>
								<?php	
								}
								
						 if($check_vic==0){
						 	echo "Non ci sono altre segnalazioni nelle vicinanze.<br><br>";
						 }
						 ?>
						
						
						<div style="text-align: center;">
								<button type="button" class="btn btn-info"  data-toggle="modal" data-target="#lavorazione"class="fas fa-plus"></i> 
								<?php
								if ($check_civico==0 and $check_vic==0){
									echo "Elabora segnalazione";
								} else {
									echo "Elabora come nuova segnalazione";
								}
								?>
								</button>			   					
						</div>




<!-- Modal lavorazione-->
<div id="lavorazione" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Inserire allerta</h4>
      </div>
      <div class="modal-body">
      

        <form autocomplete="off" action="segnalazione/lavorazione.php?id='<?php echo $id?>'" method="POST">
			<div class="form-group">
					<label for="nome"> Chi si occuperà della gestione della segnalazione ?</label> <font color="red">*</font><br>
					<label class="radio-inline"><input type="radio" name="uo" value="centrale">Invia alla centrale</label>
					<label class="radio-inline"><input type="radio" name="uo" value="elabora">Elabora come tua Unità operativa </label>
				</div>
		



        <button  id="conferma" type="submit" class="btn btn-primary" disabled="">Inserisci in lavorazione</button>
            </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
      </div>
    </div>

  </div>
</div>   



						<hr>
						<!--h4> Persona a rischio? </h4-->
						<?php 
						if($r['rischio'] !='t') {
							echo '<h4> <i class="fas fa-circle fa-1x" style="color:#ff0000"></i> Persona a rischio</h4>';
						} else if ($r['rischio'] !='f') {
							echo '<h4> <i class="fas fa-circle fa-1x" style="color:#008000"></i> Non ci sono persone a rischio</h4>';
						} else {
							echo '<h4> <i class="fas fa-circle fa-1x" style="color:#ffd800"></i> Non è specificato se ci siano persone a rischio</h4>';
						}
						?>
						<hr>
						<h4><i class="fas fa-list-ul"></i> Generalità </h4>
					
					   
						<br><b>Identificativo segnalazione</b>: <?php echo $r['id']; ?>
						<br><b>Identificativo evento</b>: <?php echo $r['id_evento']; ?>
						<br><b>Descrizione</b>: <?php echo $r['descrizione']; ?>
						<br><b>Data e ora inserimento</b>: <?php echo $r['data_ora']; ?>
						<br><b>Operatore inserimento</b>: <?php echo $r['id_operatore']; ?>
						
						
						
						<!--div class="panel-group">
						  <div class="panel panel-default">
						    <div class="panel-heading">
						      <h4 class="panel-title">
						        <a data-toggle="collapse" href="#c_segnalante">Generalità segnalante</a>
						      </h4>
						    </div>
						    <div id="c_segnalante" class="panel-collapse collapse">
						      <div class="panel-body"-->
						      <hr>
						     <h4><i class="fas fa-user"></i> Segnalante </h4> 
						     <?php 
						     $query_segnalante="SELECT * FROM segnalazioni.v_segnalanti where id_segnalazione=".$id.";";
						     $result_segnalante=pg_query($conn, $query_segnalante);
								while($r_segnalante = pg_fetch_assoc($result_segnalante)) {
									echo "<br><b>Tipo</b>:".$r_segnalante['descrizione'];
									if ($r_segnalante['altro_tipo']!='') {
										echo "(".$r_segnalante['altro_tipo'].")";
									}
									echo "<br><b>Nome</b>:".$r_segnalante['nome_cognome'];
									echo "<br><b>Telefono</b>:".$r_segnalante['telefono'];
									echo "<br><b>Note segnalante</b>:".$r_segnalante['note'];
								}
						     ?>
						      <!--/div>
						      <div class="panel-footer">Panel Footer</div>
						    </div>
						  </div>
						</div-->
						
						
						<br>
						
						<br>
						</div> 
						<div class="col-md-6">
						<h4> <i class="fas fa-map-marker-alt"></i> Indirizzo </h4>
						<?php if($r['id_civico'] !='') {
								$queryc= "SELECT * FROM geodb.civici WHERE id=".$r['id_civico'].";";
								$resultc=pg_query($conn, $queryc);
								while($rc = pg_fetch_assoc($resultc)) {
									echo "<b>Indirizzo civico</b>:" .$rc['desvia'].", ".$rc['testo'].", ".$rc['cap'];
									echo "<br><b>Municipio</b>:" .$rc['desmunicipio'];
								}
						}
						$lon=$r['lon'];
						$lat=$r['lat'];
						?>
						<hr>
						<h4> <i class="fas fa-map-marked-alt"></i> Mappa </h4>
						<div id="map_dettaglio" style="width: 100%; padding-top: 100%;"></div>
						
						<hr>
						<?php 
							// cerco l'oggetto a rischio
							$check_or=0;
							$query_or="SELECT * FROM segnalazioni.join_oggetto_rischio WHERE id_segnalazione=".$id." AND attivo='t';";
							$result_or=pg_query($conn, $query_or);
							while($r_or = pg_fetch_assoc($result_or)) {
								$check_or=1;
								$id_tipo_oggetto_rischio=$r_or['id_tipo_oggetto'];
								$id_oggetto_rischio=$r_or['id_oggetto'];
							}
							//echo $query_or;
							// cerco i dettagli dell'oggetto a rischio
							$query_or2="SELECT * from segnalazioni.tipo_oggetti_rischio where id= ".$id_tipo_oggetto_rischio.";";
							//echo $query_or2;
							$result_or2=pg_query($conn, $query_or2);
							while($r_or2 = pg_fetch_assoc($result_or2)) {
								$nome_tabella_oggetto_rischio=$r_or2['nome_tabella'];
								$descrizione_oggetto_rischio=$r_or2['descrizione'];
								$nome_campo_id_oggetto_rischio=$r_or2['campo_identificativo'];
							}
							if($check_or==1) {
								echo "<h4> Oggetto a rischio </h4>";
								echo "<b>Tipo oggetto a rischio</b>:".$descrizione_oggetto_rischio;
								echo "<br><b>Id oggetto a rischio </b>:".$id_oggetto_rischio;
							} else if ($check_or==0) {
								echo "<h4> Nessun oggetto a rischio segnalato.</h4>";
							}
							// eventualmente da tirare fuori altri dettagli
							//$query_or3="SELECT * from ".$nome_tabella_oggetto_rischio."  where ".$nome_campo_id_oggetto_rischio." = ".$id_oggetto_rischio.";";
							
 						?>	
						</div>
			
					<?php
					}
					?>


            </div>
            <!-- /.row -->
    </div>
    <!-- /#wrapper -->

<?php 

require('./footer.php');

require('./req_bottom.php');


?>


<script type="text/javascript">
						
						
		//var lat=44.411156;
		//var lon=8.932661;
		var lat=<?php echo $lat;?>;
		var lon=<?php echo $lon;?>;
		var mymap = L.map('map_dettaglio', {scrollWheelZoom:false}).setView([lat, lon], 16);
	
		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
			maxZoom: 18,
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
				'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
			id: 'mapbox.streets'
		}).addTo(mymap);
	
		L.marker([lat, lon]).addTo(mymap)
    		.bindPopup('Segnalazione n. 3');
    		//.openPopup();
	

</script>

    

</body>

</html>
