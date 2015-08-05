<?php include 'includes/header.php'; ?>
    
    <script>
    function levantamentoBolo()
    {
        var idenc = $('#valorsearch').val();
        
	if(idenc == '')
	{
		alert('Não preencheu o numero da encomenda');
	}else{
		//alert('dddd');
		$.get( "ajax/ajlevantamentobolo.php", { 
			idenc: idenc}, 'text' )
			.done(function( data ) {
		   	    var newdata = data.trim();
		   	    if(newdata == "ok")
			    {
			    	alert('Levantamento registado com sucesso');
			    	window.location = 'levantamentobolo.php';
			    }else{
			    	//$('#suppliertype').hide();
			    	alert(newdata);
			    	window.location = 'levantamentobolo.php';
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
                    <legend>Registar Levantamento Encomenda</legend>
                    
                    <div class="form-group">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="textinput" >Nº da Encomenda</label>
                            <div class="col-sm-2">
                                <input type="text" name="valorsearch" id="valorsearch" class="form-control" onkeyup="if(event.keyCode == 13) verEncomenda('')" />
                            </div>
                            <div class="col-sm-3">
                                <input type="button" onclick="verEncomenda('')" class="btn btn-primary" value="Ver">
                            </div>                            
                        </div>
                        
                        <div name="requestajviewenc" id="requestajviewenc"></div>
                        
                        <div id="suppliertype" hidden>
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" ></label>
	                            <div class="col-sm-3">
	                                <input type="button" onclick="levantamentoBolo()" class="btn btn-primary" value="Registar Levantamento">
	                            </div>
	                        </div>
                        </div>                 
                    </div>                    
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>