<?php include 'includes/header.php'; ?>
    
    <script>
    function delSection()
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
                        alert("Secção Desativada");
                        window.location = "index.php";                        
                    }else{
                        alert(xhr.responseText);
                        //alert('tenta de novo');
                    }                    
                }
        }
        xhr.open("POST","ajax/ajdelsection.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send('section='+strUser);        
    }
    
    </script>



    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form name="changegr" class="form-horizontal" >
                <fieldset>

                    <!-- Form Name -->
                    <legend>Desactivar Secção</legend>
                        
                        <div class="form-group">
                        	<label class="col-sm-3 control-label" for="textinput">Secção</label>
                        	<div class="col-sm-4 ">
	                            <select id="cbfuncionario" class="form-control">
		                        <option></option>
		                        <?php 
		                        $table = sectionGetByFiltro("sec_enable = 1", "sec_id");

		                        while ($us = foreachRow($table)) 
		                        {?>
		                            <option value="<?= $us['sec_id'];?>"><?= $us['sec_name'];?></option>
		                            <?php
		                        }?>
		                    </select>  
		           	</div> 
		           	<div class="col-sm-3">
	                                <input type="button" onclick="delSection()" class="btn btn-primary" value="Desativar">
	                        </div>                       
                        </div>
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>