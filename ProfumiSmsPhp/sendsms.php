<?php include 'includes/header.php'; ?>
    
    <script>
    function sendSms()
    {
        var contacto = document.getElementById('valorsearch').value;
        if(contacto == '')
        {
            alert('Tem que inserir um numero de Telemóvel');
            document.getElementById('valorsearch').focus();
            return false;
        }
        if(contacto != '')
        {
            var pattern = /[0-9]{9}/;
            if(!pattern.test(contacto)) {
                alert( "O numero do telemóvel não esta completo ou errado" );
                document.getElementById('valorsearch').focus();
                return false;
            }
        }
        
        var textosms = document.getElementById('texto_sms').value;
        if(textosms == '')
        {
            alert('Tem que preencher o campo da sms');
            document.getElementById('texto_sms').focus();
            return false;
        }
        if(textosms.length < 30)
        {
            alert('Verifique o conteúdo da sms');
            document.getElementById('texto_sms').focus();
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
                    if(trimStr(xhr.responseText) == 'ok')
                    {
                        //alert(xhr.responseText);
                        alert("Mensagem processada, verificar dentro de 5 min o estado dela.");
                        window.location = "index.php";                        
                    }else{
                        alert(xhr.responseText);
                        //alert('tenta de novo');
                    }                    
                }
        }
        xhr.open("POST","ajax/ajsendsms.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send('contacto='+contacto+'&sms='+textosms); 
        showLoading();       
    }
    
    function countcharacter()
    {
    	var textosms = document.getElementById('texto_sms').value;
    	//aqui tenho que retirar os acentos
    	var newsms = removerAcentos(textosms);
    	
    	document.getElementById('texto_sms').value=newsms;
    	var length = newsms.length + '/160';
    	document.getElementById("countcharater").innerHTML=length;
    }
    </script>
    <script src="js/removeaccent.js"></script>


    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form name="changegr" class="form-horizontal" onsubmit="return false;" >
                <fieldset>

                    <!-- Form Name -->
                    <legend>Enviar SMS ao Cliente</legend>
                    
                    <div class="form-group">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" >Contacto</label>
                            <div class="col-sm-3">
                                <input type="text" name="valorsearch" id="valorsearch" maxlength="9" class="form-control"/>
                            </div>
                        </div>  
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" >Texto</label>
                            <div class="col-sm-8">
	                            <textarea name="texto_sms" id="texto_sms" maxlength="160" rows="5" class="form-control"  onkeyup="countcharacter()" ></textarea>
	                    </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" ></label>
                            <div class="col-sm-3" name="countcharater" id="countcharater">
                                0/160
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput" ></label>
                            <div class="col-sm-3">
                                <input type="button" onclick="sendSms()" class="btn btn-primary" value="Enviar">
                            </div>
                        </div>                       
                    </div>
                    *O envio de sms é um processo demorado, por isso não refrescar a pagina.<br/>
                    *No minimo demora 20 segundos, paciência.
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>