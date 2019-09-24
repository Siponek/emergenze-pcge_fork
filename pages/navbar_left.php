<?php 
# sidebar definition
?>



<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!--li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li-->
                        <?php
							if(basename($_SERVER['PHP_SELF']) == 'index.php') {
						?>
							<li class="nav-item active">
								<a class="nav-link" href="#segn_sintesi"><i class="fas fa-list"></i> Lista segnalazioni</a>
							</li>
							<li class="nav-item active">
								<a class="nav-link" href="#mappa_segnalazioni"><i class="fas fa-map-marked-alt"></i> Mappa segnalazioni</a>
							</li>
						<?php
						} else {
						?>
							
							<li class="nav-item active">
								<a class="nav-link" href="index.php"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</a>
							</li>
						<?php
						}
						?>

                        <li>
                            <a href="#"><i class="fa fa-stream fa-fw"></i> Gestione eventi<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            		<li>
                                    <a href="nuovo_evento.php"><i class="fas fa-plus"></i> Crea nuovo evento</a>
                                </li>
                                <li>
                                    <a href="dettagli_evento.php"><i class="fas fa-info"></i> Dettagli eventi in corso</a>
                                </li>
                                 <li>
                                    <a href="dettagli_evento_c.php"><i class="fas fa-info-circle"></i> Dettagli eventi in fase di chiusura</a>
                                </li>
                                 <li>
                                    <a href="lista_eventi.php"><i class="fas fa-list"></i> Lista eventi / reportistica </a>
                                </li> 
                                <li>
                                   <a href="attivita_sala_emergenze.php"><i class="fas fa-sitemap"></i> Assegna turni sala emergenze</a>
                                </li> 
                                <li>
                                   <a href="storico_sala_emergenze.php"><i class="fas fa-history"></i> Storico turni sala emergenze</a> 

                                </li> 			
<li>					                                  
  <a href="bollettini_meteo.php"><i class="fas fa-list"></i> Lista bollettini</a>
                                </li>
								<li>
								<a href="rete_idro.php"><i class="fas fa-tint"></i> Rete meteorologica regionale (OMIRL) </a>
								</li>
								<li>
                                    <a href="rassegna_stampa.php"><i class="far fa-newspaper"></i> Rassegna stampa comunale </a>
                                </li>
								
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="gestione_squadre.php"><i class="fa fa-users"></i> Gestione squadre</a>
                        </li>
 								<?php if ($profilo_ok==3){ ?>
								<li>
                            <a href="#"><i class="fas fa-phone"></i> Richieste / segnalazioni n. verde <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								 		
                            	<li>
                                    <a href="nuova_richiesta.php">
                                    <i class="fas fa-plus"></i>
                                    Registra segnalazione /richiesta</a>
                                </li>
                                
                                <li>
                                    <a href="elenco_richieste.php"> 
                                    <i class="fas fa-list-ul">
                                    </i> Elenco richieste num verde
                                     <br> <small>(<i class="fas fa-play"></i>eventi in corso / <i class="fas fa-hourglass-half"></i> in chiusura)</small></a>
                                </li>

                                <li>
                                    <a href="elenco_richieste_storico.php">
                                    <i class="fas fa-list"></i>
                                    Elenco richieste num verde
                                    <br> <small>Eventi passati</small></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
								<?php } ?>
                        
                        
                         <li>
                            <a href="#"><i class="fas fa-map-marked-alt"></i> Segnalazioni <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            		<li>
                                    <a href="nuova_segnalazione.php">Nuova segnalazione</a>
                                </li>
                               
                                <li>
                                    <a href="elenco_segnalazioni.php">Elenco delle segnalazioni 
                                    <br><small> (<i class="fas fa-play"></i>eventi in corso / <i class="fas fa-hourglass-half"></i> in chiusura)</small>
                                    </a>
                                </li>
                                <li>
                                    <a href="elenco_segnalazioni_ev_chiusi.php">Elenco storico delle segnalazioni
                                    <br><small> (<i class="fas fa-stop"></i>eventi chiusi)</small>
                                    </a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fas fa-pencil-ruler"></i> Presidi <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            		<li>
                                    <a href="nuovo_sopralluogo.php">Nuovo presidio fisso</a>
                                </li>
                                <li>
                                    <a href="nuovo_sopralluogo_mobile.php">Nuovo presidio mobile</a>
                                </li>
                                <li>
                                    <a href="elenco_sopralluoghi.php">Elenco presidi fissi</a>
                                </li>
                                <li>
                                    <a href="elenco_sopralluoghi_mobili.php">Elenco presidi mobili</a>
                                </li>
                                
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fas fa-exclamation-triangle"></i> Provvedimenti cautelari <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            		<li>
                                    <a href="nuovo_pc_sgombero.php">Sgombero civici</a>
                                </li>
								<li>
                                    <a href="nuovo_pc_sottopasso.php">Interdizione accesso sottopassi</a>
                                </li>
								<li>
                                    <a href="nuovo_pc_strada.php">Chiusura strada</a>
                                </li>
								<li>
                                    <a href="elenco_pc.php">Elenco provvedimenti cautelari</a>
                                </li>

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        

                         <li>
                            <a href="#"><i class="fa fa-address-book fa-fw"></i> Gestione utenti<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								 		<li>
                                    <a href="elenco_utenti.php">Elenco utenti sistema</a>
                                </li>
                            	<li>
                                    <a href="add_volontario.php">
                                    <i class="fas fa-user-plus"></i>
                                    Aggiunta utenti esterni</a>
                                </li>
                                
                                <li>
                                    <a href="reperibilita_aziende.php"> 
                                    <i class="fas fa-user-clock">
                                    </i> Reperibilità COC Esterni</a>
                                </li>

                                <li>
                                    <a href="lista_dipendenti.php">
                                    <i class="fas fa-user-tie"></i>
                                    Permessi dipendenti</a>
                                </li>
                                <li>
                                    <a href="lista_volontari.php">
                                    <i class="fas fa-user-lock"></i>
                                    Permessi utenti esterni</a>
                                </li>
                                <li>
                                    <a href="lista_mail.php">
                                    <i class="fas fa-at"></i>
                                    Contatti a cui notificare incarichi</a>
                                </li>
                                <li>
                                    <a href="rubrica.php">
                                    <i class="fas fa-address-book"></i>
                                    Rubrica Comune di Genova</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        
                        
                        
						
                        <!--li>
                            <a href="reportistica.php"> <i class="fas fa-chart-pie"></i> Riepilogo e report</a>
                        </li-->
                         <li>
                            <a target="_guida_in_linea" href="https://manuale-sistema-di-gestione-emergenze-comune-di-genova.readthedocs.io/it/latest/"> 
                            <i class="fas fa-question"></i> Guida in linea</a>
                        </li>
                        <?php if ($profilo_sistema==1){ ?>
                        <li>
                            <a href="#"><i class="fa fa-user-shield"></i> Funzionalità amministratore sistema<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            		<li>
                                    <a href="elenco_amm.php">Modifica tabelle decodifica</a>
                                </li>
                                <li>
                                    <a href="log_update.php">Log update GeoDataBase</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                       <?php } ?>
                        
                    </ul>
                    
						<div style="text-align: center;">
						   <br>
                		<img class="nav nav-second-level" src="../img/pc_ge.png" width="65%" alt="">
                		<br>
                		
							<a href="http://www.ponmetro.it/" target="_blank">
                		<img class="nav nav-second-level" src="../img/pon_metro/Logo_PONMetro-1.png" width="50%" alt="">
                		</a>
                	</div>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

