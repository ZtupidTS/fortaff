<?php include 'includes/header.php'; ?>
    
    <script>
    function sendSms()
    {
        var id_gr = document.getElementById('valorsearch').value;
        if(id_gr == '')
        {
            alert('Tem de inserir o numero da guia');
            document.getElementById('valorsearch').focus();
            return false;
        }
        if(id_gr != '')
        {
            var pattern = /[0-9]/;
            if(!pattern.test(id_gr)) {
                alert( "O numero da guia esta mal preenchido" );
                document.getElementById('valorsearch').focus();
                return false;
            }
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
                    window.location = "verifystatussms.php";                                        
                }
        }
        xhr.open("POST","ajax/ajverifysms.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send('id_gr='+id_gr); 
        showLoading();       
    }
    
    </script>



    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <form name="changegr" class="form-horizontal" onsubmit="return false;" >
                <fieldset>

                    <!-- Form Name -->
                    <legend>Verificar Estado SMS</legend>
                    
                    <div class="form-group">
                    
                    	<div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" >Nº da Guia</label>
                            <div class="col-sm-2">
                                <input type="text" name="valorsearch" id="valorsearch" class="form-control" onkeyup="if(event.keyCode == 13) verDataGr('Anexar')" />
                            </div>
                            <div class="col-sm-3">
                                <input type="button" onclick="verDataGr('Anexar')" class="btn btn-primary" value="Ver">
                            </div>                            
                        </div>
                    	
                    	<div name="requestajviewgr" id="requestajviewgr"></div> 
                    
                        <div id="suppliertype" hidden>
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label" for="textinput" ></label>
	                            <div class="col-sm-3">
	                                <input type="button" onclick="sendSms()" class="btn btn-primary" value="Verificar">
	                            </div>
	                        </div>                        
                        </div>
                    </div>
                    *a verificação pode ser demorada, por isso não refrescar a pagina.
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
    <script>
    	$('#valorsearch').focus();    
    </script>
    
<?php include 'includes/footer.php';?>