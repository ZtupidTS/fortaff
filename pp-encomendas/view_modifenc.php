<?php include 'includes/header.php'; ?>
    
    <script>
    function searchModifGr()
    {
        var idenc = $('#valorsearch').val();
        
	if(idenc == '')
	{
		alert('Não preencheu o numero da encomenda');
	}else{
		//alert('dddd');
		$.get( "ajax/ajmodifenc.php", { 
			idenc: idenc}, 'text' )
			.done(function( data ) {
		   	    //var newdata = data.trim();
		   	    if(data.length > 40)
			    {
			    	verEncomenda();
			    	$("#requestajviewenc2").html( data );
			    	//window.location = 'levantamentobolo.php';
			    }else{
			    	//$('#suppliertype').hide();
			    	alert(newdata);			    	
			    }
			});

	}             
    }
    </script>




    <div class="row">
        <div class="col-md-9 col-md-offset-2">
            <form name="changegr" class="form-horizontal" onsubmit="return false;">
                <fieldset>

                    <!-- Form Name -->
                    <legend>Visualizar Modificações Encomendas</legend>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="textinput" >Nº da Encomenda</label>
                        <div class="col-sm-2">
                            <input type="text" name="valorsearch" id="valorsearch" class="form-control" onkeyup="if(event.keyCode == 13) searchModifGr()"/>                            
                        </div>
                        <div class="col-sm-4">
                            <input type="button" onclick="searchModifGr()" class="btn btn-primary" value="Procurar">
                        </div>
                    </div>
                    
                    <div name="requestajviewenc" id="requestajviewenc"></div>                        
                    <div name="requestajviewenc2" id="requestajviewenc2"></div>
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>