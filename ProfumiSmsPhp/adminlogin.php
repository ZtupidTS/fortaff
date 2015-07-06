<?php include 'includes/header.php'; ?>
    
    <script>
    function loginAdmin()
    {
        var pass = document.getElementById('pwd').value;
        if(pass == '')
        {
            alert('Não preencheu o campo password');
            document.getElementById('pwd').focus();
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
                        window.location = "index.php";                        
                    }else{
                        //alert('palavra passe errada');
                        alert(xhr.responseText);
                    }                                        
                }
        }
        xhr.open("POST","ajax/ajverifyadmin.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send('pass='+pass);        
    }
    
    </script>



    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form name="changegr" class="form-horizontal" onsubmit="return false;">
                <fieldset>

                    <!-- Form Name -->
                    <legend>Admin</legend>
                    
                    <div class="form-group">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="textinput" >Password</label>
                            <div class="col-sm-3">
                                <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password" onkeyup="if(event.keyCode == 13) loginAdmin()">
                            </div>
                            <div class="col-sm-3">
                                <input type="button" onclick="loginAdmin()" class="btn btn-primary" value="Entrar">
                            </div>
                        </div>                        
                    </div>
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>