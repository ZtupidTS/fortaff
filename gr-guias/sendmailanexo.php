<?php include 'includes/header.php'; ?>
    
    <script>
    function sendmailToRep()
    {
        var e = document.getElementById('cbsearchreparador');
        var rep_id = e.options[e.selectedIndex].value;
        if(rep_id == '')
        {
            alert('Tem de seleccionar um reparador');
            document.getElementById('cbsearchreparador').focus();
            return false;
        }
        var e = document.getElementById('cbtipo');
        var tipo_id = e.options[e.selectedIndex].value;
        if(tipo_id == '')
        {
            alert('Tem de seleccionar um tipo');
            document.getElementById('cbtipo').focus();
            return false;
        }
        
        var id_gr = document.getElementById('valorsearch').value;
        if(id_gr == '')
        {
            alert('Tem de inserir o numero da guia');
            document.getElementById('valorsearch').focus();
            return false;
        }
        if(id_gr != '')
        {
            var pattern = /[0-9]/;
            if(!pattern.test(id_gr)) {
                alert( "O numero da guia esta mal preenchido" );
                document.getElementById('valorsearch').focus();
                return false;
            }
        }
        
        //para o anexo
        var myElem = document.getElementById('filename');
        var anex = '';
    	if(myElem != null)
    	{
		if(document.getElementById('filename').textContent != "")
		{
			//alert(document.getElementById('filename').innerText);
			anex = document.getElementById('filename').innerText;
		}
		if(anex == '') return false;
			
    	}
        
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
                    hideLoading();
                    if(trimStr(xhr.responseText) == 'ok')
                    {
                        //alert(xhr.responseText);
                        alert("Mail enviado com sucesso");
                        window.location = "index.php";                        
                    }else{
                        alert(xhr.responseText);
                        //alert('tenta de novo');
                    }                    
                }
        }
        xhr.open("POST","ajax/ajsendmail.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        if(anex != '')
        {
		xhr.send('id_gr='+id_gr+"&rep_id="+rep_id+"&tipo_id="+tipo_id+"&anexo="+anex); 
	}else{
		xhr.send('id_gr='+id_gr+"&rep_id="+rep_id+"&tipo_id="+tipo_id);
	}
        
        showLoading();       
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
            <form name="changegr" class="form-horizontal" onsubmit="return false;">
                <fieldset>

                    <!-- Form Name -->
                    <legend>Enviar Mail Com Anexo Ao Reparador</legend>
                    
                    <div class="form-group">
                    	<div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" >Nº da Guia</label>
                            <div class="col-sm-2">
                                <input type="text" name="valorsearch" id="valorsearch" class="form-control" onkeyup="if(event.keyCode == 13) verDataGr('Anexar')" />
                            </div>
                            <div class="col-sm-3">
                                <input type="button" onclick="verDataGr('Anexar')" class="btn btn-primary" value="Ver">
                            </div>                            
                        </div>
                        
                        <div name="requestajviewgr" id="requestajviewgr"></div>
                        
                        <div id="suppliertype" hidden>
	                        <!-- combobox dos TIPOS -->
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" >Tipo</label>
	                            <div class="col-sm-6">
	                                <select id="cbtipo" class="form-control">
	                                    <option></option>
	                                    <option value="1">Levantamento na Loja</option>
	                                    <option value="2">Reparação na casa do cliente</option>
	                                </select>                            
	                            </div>
	                        </div>
	                        <!-- upload talão -->
	                    	<div class="form-group">
	                        	<label class="col-sm-2 control-label" for="textinput">Importar Talão</label>
	                        	<div class="col-sm-3">
	                          		<div id="fileuploader">Upload</div>
	                        	</div>
	                    	</div>
	                        <!-- combobox dos reparadores -->
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" >Reparador</label>
	                            <div class="col-sm-6">
	                                <select id="cbsearchreparador" class="form-control">
	                                    <option></option>
	                                    <?php
	                                    $table = reparadorGetByFiltro("rep_enable = 1","rep_name");
	                                    while($data = mysql_fetch_array($table))
	                                    {?>
	                                        <option value="<?= $data['rep_id'];?>"><?= $data['rep_name'];?></option>
	                                        <?php
	                                    }?>
	                                </select>                            
	                            </div>	                            
	                        </div>
	                        <div class="form-group">
	                        	<label class="col-sm-2 control-label" for="textinput" ></label>
	                        	<div class="col-sm-3">
	                                	<input type="button" onclick="sendmailToRep()" class="btn btn-primary" value="Enviar">
	                           	</div>
	                        </div>
                        </div>
                    </div>
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>