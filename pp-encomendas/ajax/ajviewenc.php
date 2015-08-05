<?php
include '../includes/allpageaj.php';

//se é um bolo nosso
$data_enc = encomendasGetById($_GET['encomenda']);
//$data_enc = mysql_fetch_array($table);
//e aqui vou buscar os dado do meu bolo
if($data_enc['pp_enc_idbolonosso'] != '')
{
	$data_bolo = viewBoloGetById($data_enc['pp_enc_idbolonosso']);
}

//$data = encomendasGetById($_GET['encomenda']);
if(strlen($data_enc['pp_enc_clientname']) > 0)
{
	?>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="textinput" >Nome do Cliente</label>
		<div class="col-sm-10">
			<input value="<?= $data_enc['pp_enc_clientname'];?>" disabled type="text" name="cl_name" class="form-control" maxlength="100" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="textinput">Contacto</label>
		<div class="col-sm-4">
	  		<input type="text" value="<?= $data_enc['pp_enc_clientcontact'];?>" disabled maxlength="9" name="cl_telefone" id="cl_telefone" class="form-control" required>
		</div>                                            
	</div>

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
	
	
	
	<?php
	if($_GET['page'] != "sms")
	{?>
		<!--<div class="form-group">
			<label class="col-sm-2 control-label" for="textinput" ></label>
			<div class="col-sm-10">
				<input type="button" id="botaochangename" name="botaochangename" onclick="copyGr()" class="btn btn-primary" value="<?= $_GET['buttonname'];?>">
			</div>	
		</div>-->
		<?php 
	}else{// = sms
		
		if($data_enc['pp_enc_sendsms'] == 1)
		{?>
			<div class="form-group">
	        		<label class="col-sm-2 control-label" for="textinput" ></label>
	              		<div class="col-sm-3">
	                		<input type="button" onclick="sendSms()" class="btn btn-primary" value="Enviar">
	                	</div>
	     		</div>
	     		<div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" ></label>
                            <div class="col-sm-11">
                                <label class="col-sm-11 control-label" for="textinput" >*O envio de sms é um processo demorado, por isso não refrescar a pagina.</label>
                                <label class="col-sm-8 control-label" for="textinput" > No minimo demora 20 segundos, paciência.</label>
                            </div>                            
                        </div>
	     		<!--*O envio de sms é um processo demorado, por isso não refrescar a pagina.<br/>
                    	*No minimo demora 20 segundos, paciência.-->
	     		<?php
		}else{?>
			<div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" ></label>
                            <div class="col-sm-11">
                                <label class="col-sm-11 control-label" for="textinput" >Esse cliente não pretende receber sms.</label>
                            </div>                            
                        </div>
			
			<?php
		}
	}
}
closeDataBase();
?>
                    