<?php include 'includes/header.php'; ?>
    
    <script>
    function anexGuia()
    {
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
                        alert("Guia anexada com sucesso");
                        window.location = "index.php";                        
                    }else{
                        alert(xhr.responseText);
                        //alert('tenta de novo');
                    }                    
                }
        }
        xhr.open("POST","ajax/ajanexguia.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send('id_gr='+id_gr+"&tal_filename="+anex); 
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
                    <legend>Anexar Guia de Entregue a Guia</legend>
                    
                    	<div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" >Nº da Guia</label>
                            <div class="col-sm-3">
                                <input type="text" name="valorsearch" id="valorsearch" class="form-control" onkeyup="if(event.keyCode == 13) verDataGr('Anexar')"/>                            
                            </div>
                            <div class="col-sm-3">
                                <input type="button" onclick="verDataGr('Anexar')" class="btn btn-primary" value="Ver">
                            </div>                            
                        </div>
                        
                        <div name="requestajviewgr" id="requestajviewgr"></div>
                        
                        <!-- upload talão -->
                    	<div class="form-group" id="importtalao">
                        	<label class="col-sm-2 control-label" for="textinput">Importar Guia de Entregue</label>
                        	<div class="col-sm-3">
                          		<div id="fileuploader">Upload</div>
                        	</div>
                    	</div>
                        <!-- combobox dos reparadores -->
                        <div class="form-group" id="importtalao2">
                        	<label class="col-sm-2 control-label" for="textinput"></label>
                            	<div class="col-sm-3">
                                	<input type="button" onclick="anexGuia()" class="btn btn-primary" value="Anexar">
                            	</div>
                        </div>                    
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
    <script>
    	$(document).ready(function()
	{
		$('#importtalao').hide();
		$('#importtalao2').hide();
	});
    </script>
    
<?php include 'includes/footer.php';?>