<?php include 'includes/header.php'; ?>
    
    <script>
    //variáveis globais que uso aqui
    var cbcobertura = '';
    var cbrecheio = '';
    var cbmassa = '';
    function addBolo()
    {
        //nome do bolo
        var nomebolo = $('#valorsearch').val();
        var continu = true;
        if(nomebolo == '')
	{
		alert('Tem de escrever um nome para o bolo');
		continu = false;
	}
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
		if(cbcobertura == '')
		{
			alert('Tem que seleccionar uma cobertura');
			continu = false;
		}else{
			idcobertura = cbcobertura;
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
		if(cbrecheio == '')
		{
			alert('Tem que seleccionar um recheio');
			continu = false;
		}else{
			idrecheio = cbrecheio;
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
		if(cbmassa == '')
		{
			alert('Tem que seleccionar uma massa');
			continu = false;
		}else{
			idmassa = cbmassa;
		}
	}
	
	//upload file
	var myElem = document.getElementById('filename');
	var filename = '';
	if(myElem != null)
	{
		if(document.getElementById('filename').textContent != "")
		{
			//alert(document.getElementById('filename').innerText);
			filename = document.getElementById('filename').innerText;
		}else{
			alert('Tem que inserir a foto do bolo para poder inserir o bolo');
			continu = false;
		}
	}
	if(continu)
	{
		$.get( "ajax/ajinsert_bolo.php", { 
			coberturanova: coberturanova,
			idcobertura: idcobertura,
			recheionova: recheionova,
			idrecheio: idrecheio,
			massanova: massanova,
			idmassa: idmassa,
			filename: filename,
			nomebolo: nomebolo}, 'text' )
			.done(function( data ) {
		   	    var newdata = data.trim();
			    if(newdata == "ok")
			    {
			    	alert('Bolo inserido com sucesso');
			    	window.location = "insert_bolonosso.php";			    	
			    }else{
			    	//$('#suppliertype').hide();
			    	alert(newdata);
			    }
			});
	}
    }
    </script>
    <script>
	$(document).ready(function()
	{
		$("#fileuploader").uploadFile({
		url:"includes/upload.php",
		maxFileCount: 1,
		showDone: false,
		fileName:"myfile"
		});
	}); 	
    </script>



    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <form name="changegr" class="form-horizontal" >
                <fieldset>

                    <!-- Form Name -->
                    <legend>Adicionar Bolo Dos Nossos</legend>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" >Nome</label>
                            <div class="col-sm-10">
                                <input type="text" name="valorsearch" id="valorsearch" class="form-control" maxlength="79"/>                            
                            </div>                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" >Cobertura</label>
                            <div class="col-sm-10">
                            	<select id="cbcobertura" class="form-control">
		                        <option></option>
		                        <?php 
		                        $cobertura = coberturaGetAll();

		                        while ($cb = foreachRow($cobertura)) 
		                        {?>
		                            <option value="<?= $cb['pp_cobertura_id'];?>"><?= $cb['pp_cobertura_designacao'];?></option>
		                            <?php
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
		                        {?>
		                            <option value="<?= $re['pp_recheio_id'];?>"><?= $re['pp_recheio_designacao'];?></option>
		                            <?php
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
		                        {?>
		                            <option value="<?= $ma['pp_massa_id'];?>"><?= $ma['pp_massa_designacao'];?></option>
		                            <?php
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
                        <!-- upload talão -->
                    	<div class="form-group">
                        	<label class="col-sm-2 control-label" for="textinput">Importar Foto</label>
                        	<div class="col-sm-10">
        		                  <div id="fileuploader">Upload</div>
	                        </div>
                    	</div>
                    	<div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" ></label>
                            <div class="col-sm-10">
                                <label class="col-sm-6 control-label" for="textinput" >A foto tem de ser do tipo 'jpeg'</label>
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