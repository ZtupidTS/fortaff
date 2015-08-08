<?php include 'includes/header.php'; ?>

    <script src="js/validateInsertRep.js"></script>
    <script>
    	function changeReparador(id)
    	{
		var butval = document.getElementById("modificar").value;
		if(butval == "Modificar")
		{
			document.getElementById("modificar").value = "Gravar";
			document.getElementById("rep_email").disabled = false;
			document.getElementById("rep_email2").disabled = false;
                        document.getElementById("rep_morada").disabled = false;
                        document.getElementById("rep_telefone1").disabled = false;
                        document.getElementById("rep_telefone2").disabled = false;
                        document.getElementById("rep_nome1").disabled = false;
                        document.getElementById("rep_nome2").disabled = false;
		}else{
			//aqui tenho de gravar os dados do telefone
			var telefone1 = document.getElementById("rep_telefone1").value;
			if(telefone1 != "" )
			{
				var pattern = /[0-9]{9}/;
				if(!pattern.test(telefone1))
				{
			    		alert( "Verificar contacto1" );
			    		document.getElementById("rep_telefone1").focus() ;
			   		return false;
				}
			}
                        var telefone2 = document.getElementById("rep_telefone2").value;
			if(telefone2 != "" )
			{
				var pattern = /[0-9]{9}/;
				if(!pattern.test(telefone2))
				{
			    		alert( "Verificar contacto2" );
			    		document.getElementById("rep_telefone2").focus() ;
			   		return false;
				}
			}
                        var email = document.getElementById("rep_email").value;
                        if( email != "" )
                        {
                            var atpos = email.indexOf("@");
                            var dotpos = email.lastIndexOf(".");
                            if (atpos<1 || dotpos < atpos+2 || dotpos+2 >= email.length)
                            {
                                    alert("Verificar o email introduzido");
                                    return false;
                            }
                        }
                        var email2 = document.getElementById("rep_email2").value;
                        if( email2 != "" )
                        {
                            var atpos = email2.indexOf("@");
                            var dotpos = email2.lastIndexOf(".");
                            if (atpos<1 || dotpos < atpos+2 || dotpos+2 >= email2.length)
                            {
                                    alert("Verificar o email2 introduzido");
                                    return false;
                            }
                        }
			//com o ajax se dá ok volto a por tudo como esta.
			//aqui faço o ajax
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
				    if(trimStr(xhr.responseText) == 'ok')
				    {
				        //se recebo o ok
				        alert('Alteração guardada com sucesso');
				        document.getElementById("modificar").value = "Modificar";
                                        document.getElementById("rep_email").disabled = true;
                                        document.getElementById("rep_email2").disabled = true;
                                        document.getElementById("rep_morada").disabled = true;
                                        document.getElementById("rep_telefone1").disabled = true;
                                        document.getElementById("rep_telefone2").disabled = true;
                                        document.getElementById("rep_nome1").disabled = true;
                                        document.getElementById("rep_nome2").disabled = true;
				    }else{
				        //alert(xhr.responseText);
				        alert('tenta de novo');
				    }            
				}
			}
                        
                        var postajax = "rep_id="+id;
                        
                        if(telefone1 != "" )
                        {
                            postajax = postajax+"&rep_telefone1="+telefone1;
                        }
                        if(telefone2 != "" )
                        {
                            postajax = postajax+"&rep_telefone2="+telefone2;
                        }
                        if(email != "" )
                        {
                            postajax = postajax+"&rep_email="+email;
                        }
                        if(email2 != "" )
                        {
                            postajax = postajax+"&rep_email2="+email2;
                        }
                        if(document.getElementById("rep_morada").value != "")
                        {
                            postajax = postajax+"&rep_morada="+document.getElementById("rep_morada").value;
                        }
                        if(document.getElementById("rep_nome2").value != "")
                        {
                            postajax = postajax+"&rep_nome2="+document.getElementById("rep_nome2").value;
                        }
                        if(document.getElementById("rep_nome1").value != "")
                        {
                            postajax = postajax+"&rep_nome1="+document.getElementById("rep_nome1").value;
                        }
                        
                        postajax = postajax+"&why=Alterou o reparador"
                        
			xhr.open("POST","ajax/ajupdatereparador.php",true);
    			xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    			xhr.send(postajax);
		}
	}
    </script>
    
    <?php
    $data = reparadorGetById(dbInteger($_GET['id']));    
    ?>

    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <form name="viewreparador" class="form-horizontal" >
                <fieldset>

                    <!-- Form Name -->
                    <legend>Visualização Reparador</legend>

                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput" >Nome</label>
                      <div class="col-sm-10">
                        <input type="text" value="<?= $data['rep_name'];?>" disabled name="rep_name" id="rep_name" class="form-control" maxlength="100" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Morada</label>
                      <div class="col-sm-10">
                        <input type="text" value="<?= $data['rep_morada'];?>" disabled name="rep_morada" id="rep_morada" maxlength="100" class="form-control">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Email</label>
                      <div class="col-sm-4">
                          <input type="text" value="<?= $data['rep_email'];?>" disabled maxlength="50" name="rep_email" id="rep_email" class="form-control" >
                      </div>
                      <label class="col-sm-2 control-label" for="textinput">Email2</label>
                      <div class="col-sm-4">
                          <input type="text" value="<?= $data['rep_email2'];?>" disabled maxlength="50" name="rep_email2" id="rep_email2" class="form-control" >
                      </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Contacto 1</label>
                        <div class="col-sm-3">
                            <input type="text" value="<?= $data['rep_telefone1'];?>" disabled name="rep_telefone1" id="rep_telefone1" maxlength="9" class="form-control">
                        </div>
                        <label class="col-sm-1 control-label" for="textinput">Nome</label>
                        <div class="col-sm-6">
                            <input type="text" value="<?= $data['rep_nome1'];?>" disabled name="rep_nome1" id="rep_nome1" maxlength="30" class="form-control">
                        </div>                  
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Contacto 2</label>
                        <div class="col-sm-3">
                            <input type="text" value="<?= $data['rep_telefone2'];?>" disabled name="rep_telefone2" id="rep_telefone2" maxlength="9" class="form-control">
                        </div>
                        <label class="col-sm-1 control-label" for="textinput">Nome</label>
                        <div class="col-sm-6">
                            <input type="text" value="<?= $data['rep_nome2'];?>" disabled name="rep_nome2" id="rep_nome2" maxlength="30" class="form-control">
                        </div>                  
                    </div>

                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <div class="pull-right">
                          <input type="button" onclick="changeReparador('<?= $data['rep_id'];?>')" name="modificar" id="modificar" class="btn btn-primary" value="Modificar">
                        </div>
                      </div>
                    </div>

                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->


<?php include 'includes/footer.php';?>