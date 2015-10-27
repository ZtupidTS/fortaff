<?php include 'includes/header.php'; ?>
    
    <script src="js/dataGarantia.js"></script>
    <script src="js/validateUpdate.js"></script>
    <script src="js/printgr.js"></script>
    <script>
    	/*var telefonechange = "";
    	var acessoriochange = "";
    	var numseriechange = "";*/
    	function changeGR(id)
    	{
		var butval = document.getElementById("modificar").value;
		if(butval == "Modificar")
		{
			document.getElementById("modificar").value = "Gravar";
			document.getElementById("cl_telefone").disabled = false;
			document.getElementById("art_acessorio").disabled = false;
			document.getElementById("art_numserie").disabled = false;
			document.getElementById("obs").disabled = false;
			document.getElementById("art_ean").disabled = false;	
			document.getElementById("art_anomalia").disabled = false;
			document.getElementById("cl_morada").disabled = false;
			/*telefonechange = document.getElementById("cl_telefone").value;
			acessoriochange = document.getElementById("art_acessorio").value;
			numseriechange = document.getElementById("art_numserie").value;*/
		}else{
			//aqui tenho de gravar os dados do telefone
			var telefone = document.getElementById("cl_telefone").value;
			if(telefone != "")
			{
				var pattern = /[0-9]{9}/;
				if(!pattern.test(telefone))
				{
			    		alert( "Tem de preencher contacto do cliente" );
			    		document.getElementById("cl_telefone").focus() ;
			   		return false;
				}
			}
			var acessorio = document.getElementById("art_acessorio").value;
			var numserie = document.getElementById("art_numserie").value;
			var obs = document.getElementById("obs").value;
			var art_ean = document.getElementById("art_ean").value;
			var art_anomalia = document.getElementById("art_anomalia").value;
			var cl_morada = document.getElementById("cl_morada").value;
			//com o ajax se dá ok volto a por tudo como esta.
			//aqui faço o ajax
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				var xhr=new XMLHttpRequest();
			}else{// code for IE6, IE5
				var xhr=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xhr.onreadystatechange=function()
			{
				if (xhr.readyState==4 && xhr.status==200)
				{
				    if(trimStr(xhr.responseText) == 'ok')
				    {
				        //se recebo o ok
				        alert('Alteração guardada com sucesso');
				        document.getElementById("modificar").value = "Modificar";
					document.getElementById("cl_telefone").disabled = true;
					document.getElementById("art_acessorio").disabled = true;
					document.getElementById("art_numserie").disabled = true;
					document.getElementById("obs").disabled = true;
					document.getElementById("art_ean").disabled = true;
					document.getElementById("art_anomalia").disabled = true;
					document.getElementById("cl_morada").disabled = true;
				    }else{
				        alert(xhr.responseText);
				        //alert('tenta de novo');
				    }            
				}
			}
			
			xhr.open("POST","ajax/ajupdategr.php",true);
    			xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    			xhr.send("id="+id+"&art_ean="+art_ean+"&obs="+obs+"&cl_morada="+cl_morada+"&art_anomalia="+art_anomalia+"&cl_telefone="+telefone+"&art_acessor="+acessorio+"&art_numserie="+numserie+"&why=Alterou a guia");
		}
	}
	function viewTalao(url)
	{
		window.open(url, '_blank', 'fullscreen=no'); 
		return false;
	}
    </script>
    
    <?php
    $data = grepGetById(dbInteger($_GET['id']));    
    ?>

    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <form name="insertguia" class="form-horizontal" >
                <fieldset>

                    <!-- Form Name -->
                    <legend>Visualização Guia</legend>

                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Nº Guia</label>
                      <div class="col-sm-4">
                      	<?php
                      	if($data['gr_number'] == "")
                      	{
				$idguia = $data['id'];
			}else{
				$idguia = $data['gr_number'];
			}
                      	?>
                        <input type="text" class="form-control" value="<?= $idguia;?>" disabled readonly/>
                      </div>
                      <label class="col-sm-3 control-label" for="textinput">Data guia</label>
                      <div class="col-sm-3">
                          <input type="text" value="<?= invertedatasemhora($data['date_in']);?>" disabled class="form-control" readonly>
                      </div>
                    </div>
                    
                    <legend>Secção</legend>
                    <div class="form-group">
                    	<div class="col-sm-4 col-sm-offset-2">
	                    	<?php
	                    	$sectiongr = sectionGetById($data['id_section']);
	                    	?>
				<input type="text" class="form-control" value="<?= $sectiongr['sec_name'];?>" disabled readonly/>
	            	</div>
	            </div>

                    <legend>Cliente</legend>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput" >Nome do Cliente</label>
                      <div class="col-sm-10">
                        <input value="<?= $data['cl_name'];?>" disabled type="text" name="cl_name" class="form-control" maxlength="100" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Morada</label>
                      <div class="col-sm-10">
                        <input type="text" value="<?= $data['cl_morada'];?>" disabled name="cl_morada" id="cl_morada" maxlength="100" class="form-control" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Localidade</label>
                      <div class="col-sm-4">
                        <input type="text" value="<?= $data['cl_localidade'];?>" disabled name="cl_localidade" maxlength="100" class="form-control" required>
                      </div>
                      <label class="col-sm-3 control-label" for="textinput">Codigo Postal</label>
                      <div class="col-sm-3">
                        <input type="text" value="<?= codpostalToForm($data['cl_codpostal']);?>" disabled name="cl_codpostal" maxlength="8" class="form-control" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Contacto</label>
                      <div class="col-sm-4">
                          <input type="text" value="<?= $data['cl_telefone'];?>" disabled maxlength="9" name="cl_telefone" id="cl_telefone" class="form-control" required>
                      </div>                                            
                    </div>

                    <!-- artigo -->
                    <legend>Artigo</legend>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Marca</label>
                        <div class="col-sm-3">
                            <input type="text" value="<?= $data['art_marca'];?>" disabled name="art_marca" maxlength="30" class="form-control" required>
                        </div>
                        <label class="col-sm-1 control-label" for="textinput">Tipo</label>
                        <div class="col-sm-6">
                            <input type="text" value="<?= $data['art_type'];?>" disabled name="art_tipo" maxlength="50" class="form-control" required>
                        </div>                  
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Modelo</label>
                        <div class="col-sm-4">
                          <input type="text" value="<?= $data['art_modelo'];?>" disabled name="art_modelo" maxlength="30" class="form-control" required>
                        </div>
                        <label class="col-sm-2 control-label" for="textinput">Nº Série</label>
                        <div class="col-sm-4">
                          <input type="text" value="<?= $data['art_numserie'];?>" disabled name="art_numserie" id="art_numserie" maxlength="50" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Cod. Barras</label>
                        <div class="col-sm-4">
                            <input type="text" value="<?= $data['art_ean'];?>" disabled name="art_ean" id="art_ean" maxlength="13" class="form-control">
                        </div>                  
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Anomalia</label>
                        <div class="col-sm-10">
                            <textarea disabled name="art_anomalia" id="art_anomalia" maxlength="100" class="form-control"><?= $data['art_anomalia'];?></textarea>
                        </div>                  
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Acessórios</label>
                        <div class="col-sm-10">
                            <textarea disabled name="art_acessorio" id="art_acessorio" maxlength="100" class="form-control"><?= $data['art_acessor'];?></textarea>
                        </div>                  
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Estética</label>
                        <div class="col-sm-10">
                            <textarea disabled name="art_estetic" maxlength="100" class="form-control"><?= $data['art_estetic'];?></textarea>
                        </div>                  
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Observação</label>
                        <div class="col-sm-10">
                            <textarea disabled name="obs" id="obs" maxlength="100" class="form-control"><?= $data['obs'];?></textarea>
                        </div>                  
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Talão</label>
                        <div class="col-sm-4">
                          <input type="text" value="<?= $data['art_numtalao'];?>" disabled name="art_numtalao" maxlength="30" class="form-control">
                        </div>
                        <label class="col-sm-1 control-label" for="textinput">Valor</label>
                        <div class="col-sm-3">
                          <input type="text" value="<?= $data['art_valor'];?>" disabled name="art_valor" maxlength="8" class="form-control">
                        </div>
                    </div>
                    
                   	<?php                    
                    	//caso o ficheiro do talão existe é mandado em anexo
			if($data['url_talao'] != "")
			{?>
				<div class="form-group">
	                        	<label class="col-sm-2 control-label" for="textinput"></label>
	                        	<div class="col-sm-10">
	                          		<input type="button" onclick="viewTalao('<?= $data['url_talao'];?>')" class="btn btn-primary" value="Ver Talão">
	               			</div>
	               		</div>
	               		<?php
			}?>
			
			<?php                    
                    	//caso o ficheiro do talão existe é mandado em anexo
			if($data['url_guia'] != "")
			{?>
				<div class="form-group">
	                        	<label class="col-sm-2 control-label" for="textinput"></label>
	                        	<div class="col-sm-10">
	                          		<input type="button" onclick="viewTalao('<?= $data['url_guia'];?>')" class="btn btn-primary" value="Ver Guia">
	               			</div>
	               		</div>
	               		<?php
			}?>
                     
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Garantia</label>
                        <div class="col-sm-1">
                            <?php
                            if($data['art_garantie'] == 1)
                            {?>
                                <input class="checkbox" checked type="checkbox" disabled class="form-control" onchange="dataGarantia()">
                                <?php
                            }else{?>
                                <input class="checkbox" type="checkbox" class="form-control" disabled onchange="dataGarantia()">
                                <?php
                            }
                            ?>
                        </div>
                        <label class="col-sm-4 control-label" for="textinput">Data</label>
                        <div class="col-sm-3">
                            <?php
                            if($data['art_garantie'] == 1)
                            {?>
                                <input name="garantia" id="garantia" type="text" value="<?= invertedatasemhora($data['art_dategar']);?>" disabled maxlength="10" class="form-control">
                                <?php
                            }else{?>
                                <input name="garantia" id="garantia" type="text"  maxlength="10" class="form-control" disabled>
                                <?php
                            }
                            ?>  
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Orçamento</label>
                        <div class="col-sm-1">
                            <?php
                            if($data['art_orcamento'] == 1)
                            {?>
                                <input class="checkbox" name="art_orcamento" id="art_orcamento" type="checkbox" class="form-control" checked disabled>
                                <?php
                            }else{?>
                                <input class="checkbox" name="art_orcamento" id="art_orcamento" type="checkbox" class="form-control" disabled>
                                <?php
                            }
                            ?>
                        </div>
                        <label class="col-sm-4 control-label" for="textinput">Valor Orçamento</label>
                        <div class="col-sm-3">
                          <input type="text" value="<?= $data['art_valorcamento'];?>" disabled name="art_valorcamento" maxlength="8" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Data Rep.</label>
                        <div class="col-sm-4">
                          <input type="text" value="<?= invertedatasemhora($data['date_torep']);?>" disabled name="date_torep" maxlength="10" class="form-control">
                        </div>
                        <label class="col-sm-2 control-label" for="textinput">Data SMS</label>
                        <div class="col-sm-4">
                          <input type="text" value="<?= invertedatasemhora($data['date_sms']);?>" disabled name="date_sms" maxlength="10" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="textinput">Data Levantamento</label>
                      <div class="col-sm-3">
                          <input type="text" value="<?= invertedatasemhora($data['date_tocliente']);?>" disabled maxlength="10" name="date_tocliente" class="form-control" required>
                      </div>
                      <label class="col-sm-2 control-label" for="textinput">Estado SMS</label>
                        <div class="col-sm-4">
                        	<?php
                        	switch($data['status_sms']){
					case 1:?>
						<input type="text" value="Entregue" disabled name="date_sms" maxlength="1" class="form-control">
						<?php
						break;
					case 2:?>
						<input type="text" value="Pendente" disabled name="date_sms" maxlength="1" class="form-control">
						<?php
						break;
					case 3:?>
						<input type="text" value="Não entregue" disabled name="date_sms" maxlength="1" class="form-control">
						<?php
						break;
					default:?>
						<input type="text" value="" disabled name="date_sms" maxlength="1" class="form-control">
						<?php
						break;
				}
                        	?>                          
                        </div>
                    </div>
                    
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <div class="pull-right">
                          <input type="button" name="modificar" id="modificar" onclick="changeGR('<?= $data['id'];?>')" class="btn btn-primary" value="Modificar">
                          <input type="button" onclick="printGr('<?= $data['id'];?>')" class="btn btn-primary" value="Imprimir">
                        </div>
                      </div>
                    </div>

                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>