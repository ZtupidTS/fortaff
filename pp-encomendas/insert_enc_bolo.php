<?php include 'includes/header.php'; ?>

	<?php
	if(isset($_GET['pp_bolo_id']))
	{
		//se é um bolo nosso
		$table = viewBoloGetByFiltro("pp_bolo_id = ".dbInteger(control_post($_GET['pp_bolo_id'])),"");
		$data = mysql_fetch_array($table);		
	}else{
		//novo bolo
	}
	?>
	
	<div class="row">
	        <div class="col-md-7 col-md-offset-2">
	            <form name="changegr" class="form-horizontal" >
	                <fieldset>

	                    <!-- Form Name -->
	                    <legend>Criação da Encomenda</legend>
	                        <?php
	                        if(isset($_GET['pp_bolo_id']))
				{?>
					<!--se é um bolo nosso-->
					<div class="form-group">
	                            		<label class="col-sm-2 control-label" for="textinput" ></label>
	                            		<div class="col-sm-10">
	                                		<img height="150" width="250" src="<?= $data['pp_bolo_urlimage'];?>"/>
	                            		</div>                            
	                        	</div>
					<div class="form-group">
	                            		<label class="col-sm-2 control-label" for="textinput" ></label>
	                            		<div class="col-sm-10">
	                                		<input type="text" disabled name="valorsearch" id="valorsearch" class="form-control" maxlength="79" value="<?= $data['pp_bolo_nome'];?>"/> 	                                		
	                            		</div>                            
	                        	</div>
					<?php		
				}else{?>
					<!--novo bolo-->
					
				<?php }?>
	                        
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" >Cobertura</label>
	                            <div class="col-sm-10">
	                            	<select id="cbcobertura" class="form-control">
			                        <option></option>
			                        <?php 
			                        $cobertura = coberturaGetAll();

			                        while ($cb = foreachRow($cobertura)) 
			                        {
			                            if($data['pp_bolo_coberturaid'] == $cb['pp_cobertura_id'])
			                            {
						    	?>
			                            	<option value="<?= $cb['pp_cobertura_id'];?>" selected><?= $cb['pp_cobertura_designacao'];?></option>
			                            	<?php
						    }else{
						    	?>
			                            	<option value="<?= $cb['pp_cobertura_id'];?>"><?= $cb['pp_cobertura_designacao'];?></option>
			                            	<?php
						    }
			                        }?>
			                        <option value="outro">Outro</option>
		                    	</select>                                
	                            </div>                            
	                        </div>
	                        <div class="form-group" id="coberturanova" style="display: none">
	                            <label class="col-sm-2 control-label" for="textinput" ></label>
	                            <div class="col-sm-10">
	                                <input type="text" name="novacobertura" id="novacobertura" class="form-control" maxlength="79"/>                            
	                            </div>                            
	                        </div>
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" >Recheio</label>
	                            <div class="col-sm-10">
	                                <select id="cbrecheio" class="form-control">
			                        <option></option>
			                        <?php 
			                        $recheio = recheioGetAll();

			                        while ($re = foreachRow($recheio)) 
			                        {
			                            if($data['pp_bolo_recheioid'] == $re['pp_recheio_id'])
			                            {
						    	?>
			                            	<option value="<?= $re['pp_recheio_id'];?>" selected><?= $re['pp_recheio_designacao'];?></option>
			                            	<?php
						    }else{
						    	?>
			                            	<option value="<?= $re['pp_recheio_id'];?>"><?= $re['pp_recheio_designacao'];?></option>
			                            	<?php
						    }
			                        }?>
			                        <option value="outro">Outro</option>			                        
		                    	</select>                            
	                            </div>                            
	                        </div>
	                        <div class="form-group" id="recheionova" style="display: none">
	                            <label class="col-sm-2 control-label" for="textinput" ></label>
	                            <div class="col-sm-10">
	                                <input type="text" name="novorecheio" id="novorecheio" class="form-control" maxlength="79"/>                            
	                            </div>                            
	                        </div>
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" >Massa</label>
	                            <div class="col-sm-10">
	                                <select id="cbmassa" class="form-control">
			                        <option></option>
			                        <?php 
			                        $massa = massaGetAll();

			                        while ($ma = foreachRow($massa)) 
			                        {
			                            if($data['pp_bolo_massaid'] == $ma['pp_massa_id'])
			                            {
						    	?>
			                            	<option value="<?= $ma['pp_massa_id'];?>" selected><?= $ma['pp_massa_designacao'];?></option>
			                            	<?php
						    }else{
						    	?>
			                            	<option value="<?= $ma['pp_massa_id'];?>"><?= $ma['pp_massa_designacao'];?></option>
			                            	<?php
						    }
			                        }?>
			                        <option value="outro">Outro</option>
		                    	</select>                            
	                            </div>                            
	                        </div>
	                        <div class="form-group" id="massanova" style="display: none">
	                            <label class="col-sm-2 control-label" for="textinput" ></label>
	                            <div class="col-sm-10">
	                                <input type="text" name="novamassa" id="novamassa" class="form-control" maxlength="79"/>                            
	                            </div>                            
	                        </div>
	                        
	                        <legend>Cliente</legend>
	                        
	                        <div class="form-group">
	                            	<label class="col-sm-2 control-label" for="textinput">Nome</label>
	                            	<div class="col-sm-10">
	                                	<input type="text" disabled name="valorsearch" id="valorsearch" class="form-control" maxlength="79" value="<?= $data['pp_bolo_nome'];?>"/> 
	                        	</div>                            
	                        </div>
	                        
	                    	<div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" ></label>
	                            <div class="col-sm-2">
	                                <input type="button" onclick="addBolo()" class="btn btn-primary" value="Inserir Bolo">
	                            </div>
	                        </div> 
	                    
	                </fieldset>
	            </form>
            
        	</div><!-- /.col-lg-12 -->
   	 </div><!-- /.row -->

    <script>
    //aqui é para quando escolha a opção outro nas combobox
    $("#cbcobertura").change(function(){
    		cbcobertura = $('#cbcobertura').val();
    		if(cbcobertura == 'outro')
    		{
			$('#coberturanova').show();
			//$('#cbcobertura').prop("disabled", true);			
		}else{
			$('#coberturanova').hide();
		}
    	});
    $("#cbrecheio").change(function(){
    		cbrecheio = $('#cbrecheio').val();
    		if(cbrecheio == 'outro')
    		{
			$('#recheionova').show();
			//$('#cbcobertura').prop("disabled", true);			
		}else{
			$('#recheionova').hide();
		}
    	});
    $("#cbmassa").change(function(){
    		cbmassa = $('#cbmassa').val();
    		if(cbmassa == 'outro')
    		{
			$('#massanova').show();
			//$('#cbcobertura').prop("disabled", true);			
		}else{
			$('#massanova').hide();
		}
    	});
    </script>

<?php include 'includes/footer.php';?>