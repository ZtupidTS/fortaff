<?php include 'includes/header.php'; ?>
    
    <script>
    function addRecheio()
    {
        //alert('dd');
        var recheio = $('#valorsearch').val();
        //alert(recheio);
	if(recheio == '')
	{
		alert('Tem de escrever um recheio');
	}else{
		//alert('dddd');
		$.get( "ajax/ajinsert_recheio.php", { 
			recheio: recheio}, 'text' )
			.done(function( data ) {
		   	    var newdata = data.trim();
			    if(newdata == "ok")
			    {
			    	alert('Recheio inserido com sucesso');
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
                    <legend>Adicionar Recheio</legend>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" >Recheio</label>
                            <div class="col-sm-10">
                                <input type="text" name="valorsearch" id="valorsearch" class="form-control" maxlength="79"/>                            
                            </div>                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" ></label>
                            <div class="col-sm-2">
                                <input type="button" onclick="addRecheio()" class="btn btn-primary" value="Adicionar">
                            </div>
                        </div>                        
                    
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>