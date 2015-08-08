<?php include 'includes/header.php'; ?>
    
    <script src="js/dataGarantia.js"></script>
    <script>
    	function validateInsert()
	{
	    //combobox section
	    var e = document.getElementById('cbsection');
	    var section = e.options[e.selectedIndex].value;
	    if(section == '')
	    {
	        alert('Tem de seleccionar uma secção');
	        document.insertguia.cbsection.focus() ;
	        return false;
	    }	    
	    //nome
	    if( document.insertguia.cl_name.value == "" )
	    {
	        alert( "Tem de preencher o nome do cliente" );
	        document.insertguia.cl_name.focus() ;
	        return false;
	    }
	    //morada
	    if( document.insertguia.cl_morada.value == "" )
	    {
	        alert( "Tem de preencher a morada do cliente" );
	        document.insertguia.cl_morada.focus() ;
	        return false;
	    }
	    //localidade
	    if( document.insertguia.cl_localidade.value == "" )
	    {
	        alert( "Tem de preencher a localidade do cliente" );
	        document.insertguia.cl_localidade.focus() ;
	        return false;
	    }
	    //codigo postal
	    if( document.insertguia.cl_codpostal.value == "" || document.insertguia.cl_codpostal.value == "0000-000")
	    {
	        alert( "Tem de preencher o codigo postal do cliente" );
	        document.insertguia.cl_codpostal.focus() ;
	        return false;
	    }
	    if( document.insertguia.cl_codpostal.value != "" )
	    {
	        var pattern = /[0-9]{4}\-[0-9]{3}/;
	        if(!pattern.test(document.insertguia.cl_codpostal.value)) {
	            alert("O código Postal é inválido.");
	            document.insertguia.cl_codpostal.focus() ;
	            return false;
	        }
	    }
	    //contacto
	    if( document.insertguia.cl_contacto.value == "")
	    {
	        alert( "Tem de preencher contacto do cliente" );
	        document.insertguia.cl_contacto.focus() ;
	        return false;
	    }
	    if( document.insertguia.cl_contacto.value != "" )
	    {
	        var pattern = /[0-9]{9}/;
	        if(!pattern.test(document.insertguia.cl_contacto.value)) {
	            alert( "Tem de preencher contacto do cliente" );
	            document.insertguia.cl_contacto.focus() ;
	            return false;
	        }
	    }
	    //marca artigo
	    if( document.insertguia.art_marca.value == "" )
	    {
	        alert( "Tem de preencher a marca" );
	        document.insertguia.art_marca.focus() ;
	        return false;
	    }
	    //tipo artigo
	    if( document.insertguia.art_tipo.value == "" || document.insertguia.art_tipo.value == "maquina...")
	    {
	        alert( "Tem de preencher o tipo" );
	        document.insertguia.art_tipo.focus() ;
	        return false;
	    }    
	    //modelo artigo
	    if( document.insertguia.art_modelo.value == "" )
	    {
	        alert( "Tem de preencher o modelo" );
	        document.insertguia.art_modelo.focus() ;
	        return false;
	    }
	    //numero de serie artigo
	    /*if( document.insertguia.art_numserie.value == "" )
	    {
	        alert( "Tem de preencher o numero de serie, caso não tem meter 'N/A'" );
	        document.insertguia.art_numserie.focus() ;
	        return false;
	    }*/
	    //data de garantia
	    if(!document.getElementById("garantia").disabled)
	    {
	        if( document.insertguia.garantia.value == "" || document.insertguia.garantia.value == "00-00-0000")
	        {
	            alert( "Tem de preencher a data como indicado" );
	            document.insertguia.garantia.focus() ;
	            return false;
	        }
	        if( document.insertguia.garantia.value != "" )
	        {
	            var pattern = /[0-9]{2}\-[0-9]{2}\-[0-9]{4}/;
	            if(!pattern.test(document.insertguia.garantia.value)) {
	                alert( "Tem de preencher a data como indicado" );
	                document.insertguia.garantia.focus() ;
	                return false;
	            }
	        }
	    }
	    //faço o ajax da submissão do form
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
	                //se recebo o ok da submissão imprimo o pdf.
	                alert('A guia vai ser aberta num novo separador, cuidado com o bloqueio de popup. A guia foi criada com sucesso, caso não lhe apareça ir a opção de pesquisa de guia e ver a ultima que foi criada.');
	                window.open("pdf/printgr.php", '_blank');
	                //return false;
  			//win.focus();
	                //window.location = "pdf/printgr.php";	                
	                window.location = "index.php";
	            }else{
	                alert(xhr.responseText);
	                //alert('tenta de novo');
	            }            
	        }
	    }
	    //obter todos os valores dos campos.
	    var name = document.insertguia.cl_name.value;
	    var morada = document.insertguia.cl_morada.value;
	    var localidade = document.insertguia.cl_localidade.value;
	    var codpostal = document.insertguia.cl_codpostal.value;
	    var contacto = document.insertguia.cl_contacto.value;
	    var marca = document.insertguia.art_marca.value;
	    var tipo = document.insertguia.art_tipo.value;
	    var modelo = document.insertguia.art_modelo.value;
	    //var numserie = document.insertguia.art_numserie.value;
	    
	    var postajax = "cl_name="+name+"&cl_localidade="+localidade+"&cl_morada="+morada+"&cl_codpostal="+codpostal+"&cl_telefone="+contacto+"&art_type="+tipo+"&art_marca="+marca+"&art_modelo="+modelo+"&id_section="+section;
	    
	    if(document.insertguia.art_anomalia.value != "")
	    {
	        postajax = postajax+"&art_anomalia="+document.insertguia.art_anomalia.value;
	    }
	    if( document.insertguia.art_numserie.value != "" )
	    {
	        postajax = postajax+"&art_numserie="+document.insertguia.art_numserie.value;
	    }
	    if(document.insertguia.art_acessorio.value != "")
	    {
	        postajax = postajax+"&art_acessor="+document.insertguia.art_acessorio.value;
	    }
	    if(document.insertguia.art_estetic.value != "")
	    {
	        postajax = postajax+"&art_estetic="+document.insertguia.art_estetic.value;
	    }
	    if(document.insertguia.obs.value != "")
	    {
	        postajax = postajax+"&obs="+document.insertguia.obs.value;        
	    }
	    if(document.insertguia.art_numtalao.value != "" && document.insertguia.art_numtalao.value != "00/00/00 0 000A 00X00")
	    {
	        postajax = postajax+"&art_numtalao="+document.insertguia.art_numtalao.value;
	    }
	    if(document.insertguia.art_valor.value != "")
	    {
	        postajax = postajax+"&art_valor="+document.insertguia.art_valor.value;
	    }
	    if(!document.getElementById("garantia").disabled)
	    {
	        postajax = postajax+"&art_dategar="+document.insertguia.garantia.value+"&art_garantie="+1;        
	    }else{
	        postajax = postajax+"&art_garantie="+0;        
	    }
	    if(document.getElementById('art_orcamento').checked == true)
	    {
	        postajax = postajax+"&art_orcamento="+1;
	    }else{
	        postajax = postajax+"&art_orcamento="+0;
	    }
	    if(document.insertguia.art_ean.value != "")
	    {
	        postajax = postajax+"&art_ean="+document.insertguia.art_ean.value;
	    }
	    //upload file
	    var myElem = document.getElementById('filename');
	    if(myElem != null)
	    {
		if(document.getElementById('filename').textContent != "")
		{
			//alert(document.getElementById('filename').innerText);
			postajax = postajax+"&tal_filename="+document.getElementById('filename').innerText;
		}
	    }
	    
	    
	    xhr.open("POST","ajax/ajinsertgr.php",true);
	    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	    xhr.send(postajax);
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
            <form name="insertguia" class="form-horizontal" onsubmit="return false;">
                <fieldset>

                    <!-- Form Name -->
                    <legend>Inserir Guia</legend>

                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Utilizador</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?= $_SESSION['username'];?>" disabled/>
                      </div>
                    </div>
                    
                    <legend>Escolher Secção</legend>
                    <div class="form-group">
                    	<div class="col-sm-4 col-sm-offset-2">
		                    <select id="cbsection" class="form-control">
		                        <option></option>
		                        <?php
			                $table = sectionGetByFiltro("sec_enable = 1", "sec_id");
			                while ($sec = foreachRow($table))
			                {?>
		                            <option value="<?= $sec['sec_id'];?>"><?= $sec['sec_name'];?></option>
		                            <?php
		                        }?>	                        
		                    </select>
		                    
		        </div>
		    </div>

                    <legend>Cliente</legend>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput" >Nome do Cliente</label>
                      <div class="col-sm-10">
                        <input type="text" name="cl_name" class="form-control" maxlength="84" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Morada</label>
                      <div class="col-sm-10">
                        <input type="text" name="cl_morada" maxlength="81" class="form-control" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Localidade</label>
                      <div class="col-sm-4">
                        <input type="text" name="cl_localidade" maxlength="30" class="form-control" required>
                      </div>
                      <label class="col-sm-3 control-label" for="textinput">Codigo Postal</label>
                      <div class="col-sm-3">
                        <input type="text" name="cl_codpostal" placeholder="0000-000" maxlength="8" class="form-control" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Contacto</label>
                      <div class="col-sm-4">
                          <input type="text" maxlength="9" name="cl_contacto" class="form-control" required>
                      </div>
                    </div>

                    <!-- artigo -->
                    <legend>Artigo</legend>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Marca</label>
                        <div class="col-sm-3">
                            <input type="text" name="art_marca" maxlength="30" class="form-control" required>
                        </div>
                        <label class="col-sm-1 control-label" for="textinput">Tipo</label>
                        <div class="col-sm-6">
                            <input type="text" name="art_tipo" maxlength="50" placeholder="maquina..." class="form-control" required>
                        </div>                  
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Modelo</label>
                        <div class="col-sm-4">
                          <input type="text" name="art_modelo" maxlength="30" class="form-control" required>
                        </div>
                        <label class="col-sm-2 control-label" for="textinput">Nº Série</label>
                        <div class="col-sm-4">
                          <input type="text" name="art_numserie" maxlength="50" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Cod. Barras</label>
                        <div class="col-sm-4">
                            <input type="text" name="art_ean" maxlength="13" class="form-control">
                        </div>                  
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Anomalia</label>
                        <div class="col-sm-10">
                            <textarea name="art_anomalia" maxlength="100" class="form-control"></textarea>
                        </div>                  
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Acessórios</label>
                        <div class="col-sm-10">
                            <textarea name="art_acessorio" maxlength="100" class="form-control"></textarea>
                        </div>                  
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Estética</label>
                        <div class="col-sm-10">
                            <textarea name="art_estetic" maxlength="100" class="form-control"></textarea>
                        </div>                  
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Observação</label>
                        <div class="col-sm-10">
                            <textarea name="obs" maxlength="150" class="form-control"></textarea>
                        </div>                  
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Talão</label>
                        <div class="col-sm-4">
                          <input type="text" name="art_numtalao" placeholder="00/00/00 0 000A 00X00" maxlength="30" class="form-control">
                        </div>
                        <label class="col-sm-1 control-label" for="textinput">Valor</label>
                        <div class="col-sm-3">
                          <input type="text" name="art_valor" maxlength="8" class="form-control">
                        </div>
                    </div>
                    <!-- upload talão -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Importar Talão</label>
                        <div class="col-sm-10">
                          
                          <div id="fileuploader">Upload</div>
                        </div>
                    </div>
                    

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Garantia</label>
                        <div class="col-sm-1">
                            <input class="checkbox" type="checkbox" class="form-control" onchange="dataGarantia()">
                        </div>
                        <label class="col-sm-1 control-label" for="textinput">Data</label>
                        <div class="col-sm-3">
                            <input name="garantia" id="garantia" type="text" maxlength="10" placeholder="00-00-0000" class="form-control" disabled>
                        </div>
                        
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Orçamento</label>
                        <div class="col-sm-1">
                            <input class="checkbox" name="art_orcamento" id="art_orcamento" type="checkbox" class="form-control" checked>
                        </div>                
                    </div>

                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <div class="pull-right">
                          <input type="button" onclick="validateInsert()" class="btn btn-primary" value="Guardar">
                        </div>
                      </div>
                    </div>

                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
    
    
<?php include 'includes/footer.php';?>