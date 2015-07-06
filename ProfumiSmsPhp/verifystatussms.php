<?php include 'includes/header.php'; ?>
    
    <script>
    function verifySMS()
    {
        var id_sms = document.getElementById('valorsearch').value;
        if(id_sms == '')
        {
            alert('Tem de inserir o ID do sms');
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
                    hideLoading();
                    alert(xhr.responseText);                                        
                }
        }
        xhr.open("POST","ajax/ajverifysms.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send('id_sms='+id_sms); 
        showLoading();       
    }
    
    </script>



    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form name="changegr" class="form-horizontal" onsubmit="return false;" >
                <fieldset>

                    <!-- Form Name -->
                    <legend>Verificar Estado SMS</legend>
                    
                    <div class="form-group">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="textinput" >ID do SMS</label>
                            <div class="col-sm-3">
                                <input type="text" name="valorsearch" id="valorsearch" class="form-control"/>                            
                            </div>
                            <div class="col-sm-3">
                                <input type="button" onclick="verifySMS()" class="btn btn-primary" value="Verificar">
                            </div>
                        </div>                        
                    </div>
                    *A	 verificação pode ser demorada, por isso não refrescar a pagina.
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>