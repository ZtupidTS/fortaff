<?php include 'includes/header.php'; ?>
    
    <script>
    function addUser()
    {
        var user = document.getElementById('valorsearch').value;
        if(user == '')
        {
            alert('Tem de inserir o numero do funcionario');
            document.getElementById('valorsearch').focus();
            return false;
        }
        var pass = document.getElementById('password').value;
        if(user == '')
        {
            alert('Tem de inserir a password do funcionario');
            document.getElementById('password').focus();
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
                        alert("Funcionário criado");
                        window.location = "index.php";                        
                    }else{
                        alert(xhr.responseText);
                        //alert('tenta de novo');
                    }                    
                }
        }
        xhr.open("POST","ajax/ajadduser.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send('user='+user+'&pass='+pass);        
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
                            <div class="col-sm-6">
                                <input type="text" name="valorsearch" id="valorsearch" class="form-control"/>                            
                            </div>
                        </div> 
                         <div class="form-group">
                            <label class="col-sm-3 control-label" for="textinput" >Password</label>
                            <div class="col-sm-6">
                                <input type="password" name="password" id="password" class="form-control"/>                            
                            </div>
                        </div>   
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="textinput" ></label>
                            <div class="col-sm-3">
                                <input type="button" onclick="addUser()" class="btn btn-primary" value="Adicionar">
                            </div>
                        </div>                      
                    	
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>