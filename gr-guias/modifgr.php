<?php include 'includes/header.php'; ?>
    
    <script>
    function searchModifGr()
    {
        var idgr = document.getElementById("valorsearch").value;
        if(idgr == '')
        {
            alert('Tem de inserir o numero da guia');
            document.getElementById("valorsearch").focus() ;
        }else
        {
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
                    //aqui preencho o meu div com o conteúdo do pedido ajax
                    document.getElementById("requestajviewgr2").innerHTML=xhr.responseText; 
                    verDataGr('Anexar');                   
                }
            }
            xhr.open("POST","ajax/ajviewmodifgr.php",true);
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send('gr_id='+idgr);
        }                
    }
    </script>




    <div class="row">
        <div class="col-md-9 col-md-offset-2">
            <form name="changegr" class="form-horizontal" onsubmit="return false;">
                <fieldset>

                    <!-- Form Name -->
                    <legend>Visualizar Modificações Guia</legend>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput" >Nº da Guia</label>
                        <div class="col-sm-2">
                            <input type="text" name="valorsearch" id="valorsearch" class="form-control" onkeyup="if(event.keyCode == 13) searchModifGr()"/>                            
                        </div>
                        <div class="col-sm-4">
                            <input type="button" onclick="searchModifGr()" class="btn btn-primary" value="Procurar">
                        </div>
                    </div>
                    
                    <div name="requestajviewgr" id="requestajviewgr"></div>                        
                    <div name="requestajviewgr2" id="requestajviewgr2"></div>
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
    <script>
    	$('#valorsearch').focus();
    </script>
    
<?php include 'includes/footer.php';?>