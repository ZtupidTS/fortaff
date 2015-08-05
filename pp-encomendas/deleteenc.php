<?php include 'includes/header.php'; ?>
    
    <script>
    function deleteEnc()
    {
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
		//alert('dddd');
		$.get( "ajax/ajdelenc.php", { 
			idenc: idenc}, 'text' )
			.done(function( data ) {
		   	    var newdata = data.trim();
		   	    if(newdata == "ok")
			    {
			    	alert('Encomenda eliminada com sucesso');
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
                    <legend>Eliminar Encomenda</legend>
                    
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
                        
                        <div id="suppliertype" hidden>
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" ></label>
	                            <div class="col-sm-3">
	                                <input type="button" onclick="deleteEnc()" class="btn btn-primary" value="Eliminar Encomenda">
	                            </div>
	                        </div>
                        </div>                 
                    </div>                    
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>