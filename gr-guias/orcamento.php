<?php include 'includes/header.php'; ?>
    
    <script>
    function insertOrcamento()
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
        var val = document.getElementById('art_valor').value;
        if(val == '')
        {
		alert('Tem de inserir o valor');
           	document.getElementById('art_valor').focus();
           	return false;
	}
        if(val != '')
	{
		var pattern = /[0-9]/;
		if(!pattern.test(val)) 
		{
			alert( "Verifica o valor introduzido" );
			document.getElementById('art_valor').focus() ;
			return false;
		}
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
                        alert("Valor inserido");
                        window.location = "index.php";                        
                    }else{
                        alert(xhr.responseText);
                        alert('tenta de novo');
                    }                    
                }
        }
        xhr.open("POST","ajax/ajinsertorcamento.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send('id_gr='+id_gr+"&valor="+val); 
        showLoading();       
    }
    
    </script>



    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <form name="changegr" class="form-horizontal" onsubmit="return false;">
                <fieldset>

                    <!-- Form Name -->
                    <legend>Inserir Valor Orçamento</legend>
                    
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
	                        <div class="form-group">
		                        <label class="col-sm-2 control-label" for="textinput">Valor</label>
		                        <div class="col-sm-3">
		                          <input type="text" name="art_valor" id="art_valor" maxlength="8" class="form-control">
		                        </div>
		                        
	                        </div>
	                        <div class="form-group">
	                        	<label class="col-sm-2 control-label" for="textinput"></label>
	                        	<div class="col-sm-3">
	                               		<input type="button" onclick="insertOrcamento()" class="btn btn-primary" value="Inserir">
	                           	</div>
	                        </div>
                        </div>
                    </div>
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
    <script>
    	$('#valorsearch').focus();    
    </script>
    
<?php include 'includes/footer.php';?>