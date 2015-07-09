<?php include 'includes/header.php'; ?>

	<?php
	if(isset($_GET['pp_enc_id']))
	{
		//se é um bolo nosso
		$table = encomendasGetByFiltro("pp_enc_id = ".dbInteger(control_post($_GET['pp_enc_id'])),"");
		$data_enc = mysql_fetch_array($table);
		//e aqui vou buscar os dado do meu bolo
		if($data_enc['pp_enc_idbolonosso'] != '')
		{
			$data_bolo = viewBoloGetById($data_enc['pp_enc_idbolonosso']);
		}
	}else{
		//novo bolo
	}
	?>
	
	<div class="row">
	        <div class="col-md-7 col-md-offset-2">
	            <form name="changegr" class="form-horizontal" >
	                <fieldset>

	                    <!-- Form Name -->
	                    <legend>Visualização da Encomenda</legend>
	                        <?php
	                        if($data_enc['pp_enc_idbolonosso'] != '')
				{?>
					<!--se é um bolo nosso-->
					<div class="form-group">
	                            		<label class="col-sm-2 control-label" for="textinput" ></label>
	                            		<div class="col-sm-10">
	                                		<img height="150" width="250" src="<?= $data_bolo['pp_bolo_urlimage'];?>" alt="<?= $data_bolo['pp_bolo_urlimage'];?>"/>
	                            		</div>                            
	                        	</div>
					<div class="form-group">
	                            		<label class="col-sm-2 control-label" for="textinput" ></label>
	                            		<div class="col-sm-10">
	                                		<input type="text" disabled name="valorsearch" id="valorsearch" class="form-control" maxlength="79" value="<?= $data_bolo['pp_bolo_nome'];?>"/> 	                                		
	                            		</div>                            
	                        	</div>
					<?php		
				}else{?>
					<!--novo bolo-->
					
				<?php }?>
				
	                        <!--Cobertura-->
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" >Cobertura</label>
	                            <div class="col-sm-10">
	                            	<select id="cbcobertura" class="form-control" disabled>
	                            		<?php
	                            		if($data_enc['pp_enc_coberturaid'] == '')
	                            		{?>
							<option value="" selected><?= $data_enc['pp_enc_coberturaoutra'];?></option>
							<?php
						}else{
							$data_cob = coberturaGetById($data_enc['pp_enc_coberturaid']);
							?>
							<option value="<?= $data_enc['pp_enc_coberturaid'];?>" selected><?= $data_cob['pp_cobertura_designacao'];?></option>
							<?php
							isset($data_cob);
						}?>
		                    	</select>                                
	                            </div>                            
	                        </div>
	                        <!--<div class="form-group" id="coberturanova" style="display: none">
	                            <label class="col-sm-2 control-label" for="textinput" ></label>
	                            <div class="col-sm-10">
	                                <input type="text" name="novacobertura" id="novacobertura" class="form-control" maxlength="79"/>                            
	                            </div>                            
	                        </div>-->
	                        
	                        <!--recheio-->
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" >Recheio</label>
	                            <div class="col-sm-10">
	                                <select id="cbrecheio" class="form-control" disabled>
			                        <?php
	                            		if($data_enc['pp_enc_recheioid'] == '')
	                            		{?>
							<option value="" selected><?= $data_enc['pp_enc_recheiooutra'];?></option>
							<?php
						}else{
							$data_rec = recheioGetById($data_enc['pp_enc_recheioid']);
							?>
							<option value="<?= $data_enc['pp_enc_recheioid'];?>" selected><?= $data_rec['pp_recheio_designacao'];?></option>
							<?php
							isset($data_rec);
						}?>			                        
		                    	</select>                            
	                            </div>                            
	                        </div>
	                        <!--<div class="form-group" id="recheionova" style="display: none">
	                            <label class="col-sm-2 control-label" for="textinput" ></label>
	                            <div class="col-sm-10">
	                                <input type="text" name="novorecheio" id="novorecheio" class="form-control" maxlength="79"/>                            
	                            </div>                            
	                        </div>-->
	                        
	                        <!--Massa-->
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" >Massa</label>
	                            <div class="col-sm-10">
	                                <select id="cbmassa" class="form-control" disabled>
			                        <?php
	                            		if($data_enc['pp_enc_massaid'] == '')
	                            		{?>
							<option value="" selected><?= $data_enc['pp_enc_massaoutra'];?></option>
							<?php
						}else{
							$data_mas = massaGetById($data_enc['pp_enc_massaid']);
							?>
							<option value="<?= $data_enc['pp_enc_massaid'];?>" selected><?= $data_mas['pp_massa_designacao'];?></option>
							<?php
							isset($data_mas);
						}?>
		                    	</select>                            
	                            </div>                            
	                        </div>
	                        <!--<div class="form-group" id="massanova" style="display: none">
	                            <label class="col-sm-2 control-label" for="textinput" ></label>
	                            <div class="col-sm-10">
	                                <input type="text" name="novamassa" id="novamassa" class="form-control" maxlength="79"/>                            
	                            </div>                            
	                        </div>-->
	                        
	                        <!-- calendario -->
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" >Para Dia</label>
	                            <div class="col-sm-4 input-group date form_datetime">
    					<input size="16" type="text" value="<?= $data_enc['pp_enc_datedone'];?>" name="data" id="data" readonly class="form-control" style="margin: auto auto auto 14px;">
    					<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
				    </div> 				                               	                        
	                        </div>
	                        <div class="form-group">
	                        	<label class="col-sm-2 control-label" for="textinput" >Criada em</label>
	                            	<div class="col-sm-4">
	                            		<input type="text" size="16" disabled class="form-control" value="<?= $data_enc['pp_enc_dateenc'];?>"/>
	                            	</div> 
	                        </div>
	                        <!--peso pessoas-->
	                        <div class="form-group">
		                        <label class="col-sm-2 control-label" for="textinput">Peso</label>
		                        <div class="col-sm-4">
		                          <input disabled value="<?= $data_enc['pp_enc_peso'];?>" type="text" name="peso" id="peso" maxlength="10" class="form-control" required>
		                        </div>
		                        <label class="col-sm-2 control-label" for="textinput">Pessoas</label>
		                        <div class="col-sm-4">
		                          <input disabled value="<?= $data_enc['pp_enc_pessoas'];?>" type="text" name="pessoas" id="pessoas" maxlength="5" class="form-control" required>
		                        </div>
		                </div>
		                
		                <!--dizeres-->
		                <div class="form-group">
		                        <label class="col-sm-2 control-label" for="textinput">Dizeres</label>
		                        <div class="col-sm-10">
		                            <textarea disabled type="text" name="dizeres" id="dizeres" rows="3" maxlength="199" class="form-control"><?= $data_enc['pp_enc_dizeres'];?></textarea>
		                        </div>                  
		                </div>
		                
		                <!--obervações -->
		                <div class="form-group">
		                        <label class="col-sm-2 control-label" for="textinput">Observação</label>
		                        <div class="col-sm-10">
		                            <textarea disabled type="text" name="obs" id="obs" rows="3" maxlength="199" class="form-control"><?= $data_enc['pp_enc_obs'];?></textarea>
		                        </div>                  
		                </div>
	                        
	                        
	                        
	                        <legend>Cliente</legend>
	                        
	                        <div class="form-group">
	                            	<label class="col-sm-2 control-label" for="textinput">Nome</label>
	                            	<div class="col-sm-10">
	                                	<input disabled value="<?= $data_enc['pp_enc_clientname'];?>" type="text" name="nomecliente" id="nomecliente" class="form-control" maxlength="99" /> 
	                        	</div>                            
	                        </div>
	                        <div class="form-group">
	                            	<label class="col-sm-2 control-label" for="textinput">Contacto</label>
	                            	<div class="col-sm-3">
	                                	<input disabled value="<?= $data_enc['pp_enc_clientcontact'];?>" type="text" name="contacto" id="contacto" class="form-control" maxlength="9" /> 
	                        	</div> 
	                        	<label class="col-sm-4 control-label" for="textinput">Pretende Receber sms?</label>
		                        <div class="col-sm-1">
		                        	<?php
	                            		if($data_enc['pp_enc_sendsms'] == '0')
	                            		{?>
							<label class="checkbox-inline"><input name="sms" id="sms" type="checkbox" value="" disabled ></label>
							<?php
						}else{?>
							<label class="checkbox-inline"><input name="sms" id="sms" type="checkbox" value="" disabled checked ></label>
							<?php							
						}?>		                        	
		                        </div>                           
	                        </div>
	                        
	                    	<!--<div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" ></label>
	                            <div class="col-sm-2">
	                                <input type="button" onclick="addEncomenda()" class="btn btn-primary" value="Inserir Encomenda">
	                            </div>
	                        </div> -->
	                    
	                </fieldset>
	            </form>
            
        	</div><!-- /.col-lg-12 -->
   	 </div><!-- /.row -->


<?php include 'includes/footer.php';?>