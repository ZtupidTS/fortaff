<?php include 'includes/header.php'; ?>
    
    <script>
    function eliminarGuia()
    {
        var e = document.getElementById('cbfuncionario');
    	var strUser = e.options[e.selectedIndex].value;
        var id_gr = document.getElementById('valorsearch').value;
        if(id_gr == '')
        {
            alert('Tem de inserir o numero da guia');
            document.getElementById('valorsearch').focus();
            return false;
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
                    if(trimStr(xhr.responseText) == 'ok')
                    {
                        //alert(xhr.responseText);
                        alert("Guia eliminada");
                        window.location = "index.php";                        
                    }else{
                        alert(xhr.responseText);
                        //alert('tenta de novo');
                    }                    
                }
        }
        xhr.open("POST","ajax/ajdeletegr.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send('id_gr='+id_gr+'&func='+strUser);        
    }
    
    </script>



    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form name="changegr" class="form-horizontal" onsubmit="return false;">
                <fieldset>

                    <!-- Form Name -->
                    <legend>Eliminar Guia</legend>
                        <div class="form-group">
                        	<label class="col-sm-3 control-label" for="textinput">Funcionário</label>
                        	<div class="col-sm-4 ">
	                            <select id="cbfuncionario" class="form-control">
		                        <option></option>
		                        <?php 
		                        $user = loginGetByEnableAdmin();

		                        while ($us = foreachRow($user)) 
		                        {?>
		                            <option value="<?= $us['us_name'];?>"><?= $us['us_name'];?></option>
		                            <?php
		                        }?>
		                    </select>  
		           	</div>                        
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="textinput" >Nº da Guia</label>
                            <div class="col-sm-3">
                                <input type="text" name="valorsearch" id="valorsearch" class="form-control"/>                            
                            </div>
                            <div class="col-sm-3">
                                <input type="button" onclick="eliminarGuia()" class="btn btn-primary" value="Eliminar">
                            </div>
                        </div>                        
                    
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>