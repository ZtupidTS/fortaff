<?php include 'includes/header.php'; ?>
    
    <script>
    function activeUser()
    {
        var e = document.getElementById('cbfuncionario');
    	var strUser = e.options[e.selectedIndex].value;
        
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
                        alert("Funcionário activado");
                        window.location = "index.php";                        
                    }else{
                        alert(xhr.responseText);
                        //alert('tenta de novo');
                    }                    
                }
        }
        xhr.open("POST","ajax/ajactiveuser.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send('id_user='+strUser);        
    }
    
    </script>



    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form name="changegr" class="form-horizontal" >
                <fieldset>

                    <!-- Form Name -->
                    <legend>Ativar Funcionário</legend>
                        
                        <div class="form-group">
                        	<label class="col-sm-3 control-label" for="textinput">Funcionário</label>
                        	<div class="col-sm-4 ">
	                            <select id="cbfuncionario" class="form-control">
		                        <option></option>
		                        <?php 
		                        $user = loginGetDisable();

		                        while ($us = foreachRow($user)) 
		                        {?>
		                            <option value="<?= $us['us_id'];?>"><?= $us['us_name'];?></option>
		                            <?php
		                        }?>
		                    </select>  
		           	</div> 
		           	<div class="col-sm-3">
	                                <input type="button" onclick="activeUser()" class="btn btn-primary" value="Ativar">
	                        </div>                       
                        </div>
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>