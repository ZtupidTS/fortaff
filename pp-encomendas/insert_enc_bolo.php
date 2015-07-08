<?php include 'includes/header.php'; ?>

	<script>
	function addEncomenda()
	{
		var continu = true;
		//cobertura
		var cobertura = $('#cbcobertura').find('option:selected').text();
		var coberturanova = '';
		var idcobertura = '';
		if(continu && cobertura == 'Outro')
		{
			if($('#novacobertura').val() == '')
			{
				alert('Tem que preencher a designação da nova cobertura');
				continu = false;
			}else{
				coberturanova = $('#novacobertura').val();				
			}		
		}
		if(continu && coberturanova == '' && cobertura != 'Outro')
		{
			if(cobertura == '')
			{
				alert('Tem que seleccionar uma cobertura');
				continu = false;
			}else{
				idcobertura =  $('#cbcobertura').val();
			}
		}
		
		//recheio
		var recheio = $('#cbrecheio').find('option:selected').text();
		var recheionova = '';
		var idrecheio = '';
		if(continu && recheio == 'Outro')
		{
			if($('#novorecheio').val() == '')
			{
				alert('Tem que preencher a designação do novo recheio');
				continu = false;
			}else{
				recheionova = $('#novorecheio').val();				
			}		
		}
		if(continu && recheionova == '' && recheio != 'Outro')
		{
			if(recheio == '')
			{
				alert('Tem que seleccionar um recheio');
				continu = false;
			}else{
				idrecheio =  $('#cbrecheio').val();
			}
		}
		
		//massa
		var massa = $('#cbmassa').find('option:selected').text();
		var massanova = '';
		var idmassa = '';
		if(continu && massa == 'Outro')
		{
			if($('#novamassa').val() == '')
			{
				alert('Tem que preencher a designação da nova massa');
				continu = false;
			}else{
				massanova = $('#novamassa').val();				
			}		
		}
		if(continu && massanova == '' && massa != 'Outro')
		{
			if(massa == '')
			{
				alert('Tem que seleccionar uma massa');
				continu = false;
			}else{
				idmassa =  $('#cbmassa').val();
			}
		}
		
		//data e hora
		var data = $('#data').val();
		if(data == '' && continu)
		{
			alert('Tem que preencher a data da encomenda');
			continu = false;
		}else{
			//aqui comparar com a data do dia
			var today = new Date();
			var newdate = new Date(data);
			
			if(newdate < today)
			{
				alert('A data da encomenda é inferior a data do dia, favor corrigir');
				continu = false;
			}else{
				data = data+':00';
			}
		}
		
		//peso e pessoas
		var peso = $('#peso').val();
		var pessoas = $('#pessoas').val();
		if(peso == '' && pessoas == '' && continu)
		{
			alert('Tem que preencher o peso ou o numero de pessoas');
			continu = false;
		}
		
		//dizeres
		var dizeres = $('#dizeres').val();
		
		//obs
		var obs = $('#obs').val();
		
		//nome cliente
		var nomecliente = $('#nomecliente').val();
		if(nomecliente == '' && continu)
		{
			alert('Tem que preencher o nome do cliente');
			continu = false;
		}
		
		//contacto
		var contacto = $('#contacto').val();
		if(contacto == '' && continu)
		{
			alert('Tem que preencher o contacto do cliente');
			continu = false;
		}
		if(contacto != "" )
	    	{
	        	var pattern = /[0-9]{9}/;
	        	if(!pattern.test(contacto)) {
	            		alert( "Tem de preencher o contacto do cliente correctamente" );
	            		$('#contacto').focus();	            		
	        	}
	    	}
	    	
	    	//checkbox sms
	    	var sendsms = '';
	    	if ($('#sms').is(":checked") && continu)
	    	{
			sendsms = '1';
		}else{
			sendsms = '0';
		}
	    	
	    	//enviar para o ajax
	    	if(continu)
		{
			$.get( "ajax/ajinsert_encomenda.php", { 
				coberturanova: coberturanova,
				idcobertura: idcobertura,
				recheionova: recheionova,
				idrecheio: idrecheio,
				massanova: massanova,
				idmassa: idmassa,
				data: data,
				peso: peso,
				pessoas: pessoas,
				dizeres: dizeres,
				osb: obs,
				nomecliente: nomecliente,
				contacto: contacto,
				sendsms: sendsms}, 'text' )
				.done(function( data ) {
			   	    var newdata = data.trim();
				    if(newdata == "ok")
				    {
				    	alert('Encomenda inserida com sucesso');
				    	window.location = "index.php";			    	
				    }else{
				    	//$('#suppliertype').hide();
				    	alert(newdata);
				    }
				});
		}
	}	
	</script>
	
	
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
				
	                        <!--Cobertura-->
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
	                        
	                        <!--recheio-->
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
	                        
	                        <!--Massa-->
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
	                        
	                        <!-- calendario -->
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" >Dia e Hora</label>
	                            <div class="col-sm-4 input-group date form_datetime">
    					<input size="16" type="text" value="" name="data" id="data" readonly class="form-control" style="margin: auto auto auto 14px;">
    					<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
				    </div>                           
	                        </div>
	                        
	                        <!--peso pessoas-->
	                        <div class="form-group">
		                        <label class="col-sm-2 control-label" for="textinput">Peso</label>
		                        <div class="col-sm-4">
		                          <input type="text" name="peso" id="peso" maxlength="10" class="form-control" required>
		                        </div>
		                        <label class="col-sm-2 control-label" for="textinput">Pessoas</label>
		                        <div class="col-sm-4">
		                          <input type="text" name="pessoas" id="pessoas" maxlength="5" class="form-control" required>
		                        </div>
		                </div>
		                
		                <!--dizeres-->
		                <div class="form-group">
		                        <label class="col-sm-2 control-label" for="textinput">Dizeres</label>
		                        <div class="col-sm-10">
		                            <textarea type="text" name="dizeres" id="dizeres" rows="3" maxlength="199" class="form-control"></textarea>
		                        </div>                  
		                </div>
		                
		                <!--obervações -->
		                <div class="form-group">
		                        <label class="col-sm-2 control-label" for="textinput">Observação</label>
		                        <div class="col-sm-10">
		                            <textarea type="text" name="obs" id="obs" rows="3" maxlength="199" class="form-control"></textarea>
		                        </div>                  
		                </div>
	                        
	                        
	                        
	                        <legend>Cliente</legend>
	                        
	                        <div class="form-group">
	                            	<label class="col-sm-2 control-label" for="textinput">Nome</label>
	                            	<div class="col-sm-10">
	                                	<input type="text" name="nomecliente" id="nomecliente" class="form-control" maxlength="99" /> 
	                        	</div>                            
	                        </div>
	                        <div class="form-group">
	                            	<label class="col-sm-2 control-label" for="textinput">Contacto</label>
	                            	<div class="col-sm-3">
	                                	<input type="text" name="contacto" id="contacto" class="form-control" maxlength="9" /> 
	                        	</div> 
	                        	<label class="col-sm-4 control-label" for="textinput">Pretende Receber sms?</label>
		                        <div class="col-sm-1">
		                          <label class="checkbox-inline"><input name="sms" id="sms" type="checkbox" value=""></label>
		                        </div>                           
	                        </div>
	                        
	                    	<div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" ></label>
	                            <div class="col-sm-2">
	                                <input type="button" onclick="addEncomenda()" class="btn btn-primary" value="Inserir Encomenda">
	                            </div>
	                        </div> 
	                    
	                </fieldset>
	            </form>
            
        	</div><!-- /.col-lg-12 -->
   	 </div><!-- /.row -->

    <script>
    //aqui é para quando escolha a opção outro nas combobox
    $("#cbcobertura").change(function(){
    		var cbcobertura = $('#cbcobertura').val();
    		if(cbcobertura == 'outro')
    		{
			$('#coberturanova').show();
			//$('#cbcobertura').prop("disabled", true);			
		}else{
			$('#coberturanova').hide();
		}
    	});
    $("#cbrecheio").change(function(){
    		var cbrecheio = $('#cbrecheio').val();
    		if(cbrecheio == 'outro')
    		{
			$('#recheionova').show();
			//$('#cbcobertura').prop("disabled", true);			
		}else{
			$('#recheionova').hide();
		}
    	});
    $("#cbmassa").change(function(){
    		var cbmassa = $('#cbmassa').val();
    		if(cbmassa == 'outro')
    		{
			$('#massanova').show();
			//$('#cbcobertura').prop("disabled", true);			
		}else{
			$('#massanova').hide();
		}
    	});
    
    $(".form_datetime").datetimepicker({
        language: 'pt',
        format: "yyyy-mm-dd hh:ii",
        weekStart: 1,
        autoclose: true,
        todayBtn: false,
        pickerPosition: "bottom-left"
        
    });
    </script>

<?php include 'includes/footer.php';?>