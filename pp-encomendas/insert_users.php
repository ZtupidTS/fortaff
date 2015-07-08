<?php include 'includes/header.php'; ?>
    
    <script>
    function addUser()
    {
        var continu = true;
        var login = $('#login').val();
        if(login == '')
        {
		alert('Tem que preencher o campo do nome');
		continu = false;
		$('#login').focus();
	}
        var password = $('#password').val();
        if(password == '' && continu)
        {
		alert('Tem que preencher o campo da palavra passe');
		continu = false;
		$('#password').focus();
	}
        if(continu)
	{
		$.get( "ajax/ajinsert_users.php", { 
			login: login,
			password: password}, 'text' )
			.done(function( data ) {
		   	    var newdata = data.trim();
			    if(newdata == "ok")
			    {
			    	alert('Utilizador inserido com sucesso');
			    	$('#login').val('');
			    	$('#password').val('');
			    }else{
			    	//$('#suppliertype').hide();
			    	alert(newdata);
			    }
			});
	}        
    }
    
    </script>



    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form name="changegr" class="form-horizontal" >
                <fieldset>

                    <!-- Form Name -->
                    <legend>Adicionar Funcionário</legend>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="textinput" >Nome</label>
                            <div class="col-sm-5">
                                <input type="text" name="login" id="login" class="form-control"/>                            
                            </div>
                        </div>
                        <div class="form-group"> 
	                        <label class="col-sm-3 control-label" for="textinput">Palavra Passe</label>
	                        <div class="col-sm-5">
	                          <input type="password" name="password" id="password" maxlength="30" class="form-control">
	                        </div>
                        </div>
                        <div class="form-group">                        
                        	<label class="col-sm-3 control-label" for="textinput" ></label>
                    		<div class="col-sm-3">
                                	<input type="button" onclick="addUser()" class="btn btn-primary" value="Criar">
                            	</div>
                    	</div>
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>