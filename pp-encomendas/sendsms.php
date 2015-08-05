<?php include 'includes/header.php'; ?>
    
    <script>
    function sendSms()
    {
        /*var id_gr = document.getElementById('valorsearch').value;
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
                        alert("Mensagem enviada e entregue.");
                        window.location = "index.php";                        
                    }else{
                        alert(xhr.responseText);
                        //alert('tenta de novo');
                    }                    
                }
        }
        xhr.open("POST","ajax/ajsendsms.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send('id_gr='+id_gr); 
        showLoading();    
        */
        //alert('dd');
        var cont = true;
        var idenc = $('#valorsearch').val();
        
        if(idenc != '')
        {
            	var pattern = /[0-9]/;
            	if(!pattern.test(idenc)) {
                	alert( "O numero da guia esta mal preenchido" );
                	document.getElementById('valorsearch').focus();
                	cont = false;
                	return false;
            	}
        }else{
		alert('Não preencheu o numero da encomenda');
		cont = false;
	}
        
	if(cont)
	{
		showLoading();
		//alert('dddd');
		$.get( "ajax/ajsendsms.php", { 
			idenc: idenc}, 'text' )
			.done(function( data ) {
		   	    var newdata = data.trim();
		   	    hideLoading();
			    if(newdata == "ok")
			    {
			    	alert('Sms enviado com sucesso');
			    	$('#valorsearch').val('');
			    	$('#valorsearch').focus();
			    }else{
			    	//$('#suppliertype').hide();
			    	alert(newdata);
			    }
			});

	}  
    }    
    </script>



    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <form name="changegr" class="form-horizontal" onsubmit="return false;" >
                <fieldset>

                    <!-- Form Name -->
                    <legend>Enviar SMS ao Cliente</legend>
                    
                    <div class="form-group">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="textinput" >Nº da Encomenda</label>
                            <div class="col-sm-2">
                                <input type="text" name="valorsearch" id="valorsearch" class="form-control" onkeyup="if(event.keyCode == 13) verEncomenda('sms')" />
                            </div>
                            <div class="col-sm-3">
                                <input type="button" onclick="verEncomenda('sms')" class="btn btn-primary" value="Ver">
                            </div>                            
                        </div>
                        
                        <div name="requestajviewenc" id="requestajviewenc"></div>
                        
                        <!--<div id="suppliertype" hidden>
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" ></label>
	                            <div class="col-sm-3">
	                                <input type="button" onclick="sendSms()" class="btn btn-primary" value="Enviar">
	                            </div>
	                        </div>
                        </div> -->                
                    </div>                    
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>