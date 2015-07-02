<?php include 'includes/header.php'; ?>
    
    <script>
    function addCobertura()
    {
        //alert('dd');
        var cobertura = $('#valorsearch').val();
        //alert(recheio);
	if(cobertura == '')
	{
		alert('Tem de escrever uma cobertura');
	}else{
		//alert('dddd');
		$.get( "ajax/ajinsert_cobertura.php", { 
			cobertura: cobertura}, 'text' )
			.done(function( data ) {
		   	    var newdata = data.trim();
			    if(newdata == "ok")
			    {
			    	alert('Cobertura inserido com sucesso');
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
            <form name="changegr" class="form-horizontal" >
                <fieldset>

                    <!-- Form Name -->
                    <legend>Adicionar Cobertura</legend>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" >Cobertura</label>
                            <div class="col-sm-10">
                                <input type="text" name="valorsearch" id="valorsearch" class="form-control" maxlength="79"/>                            
                            </div>                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" ></label>
                            <div class="col-sm-2">
                                <input type="button" onclick="addCobertura()" class="btn btn-primary" value="Adicionar">
                            </div>
                        </div>                        
                    
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>