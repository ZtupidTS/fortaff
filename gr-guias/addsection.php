<?php include 'includes/header.php'; ?>
    
    <script>
    function addSection()
    {
        var section = document.getElementById('valorsearch').value;
        if(section == '')
        {
            alert('Tem de escrever o nome da secçao');
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
                        alert("Secção criada");
                        window.location = "index.php";                        
                    }else{
                        alert(xhr.responseText);
                        //alert('tenta de novo');
                    }                    
                }
        }
        xhr.open("POST","ajax/ajaddsection.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send('section='+section);        
    }
    
    </script>



    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form name="changegr" class="form-horizontal" >
                <fieldset>

                    <!-- Form Name -->
                    <legend>Adicionar Secção</legend>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="textinput" >Nome</label>
                            <div class="col-sm-3">
                                <input type="text" name="valorsearch" id="valorsearch" class="form-control"/>                            
                            </div>
                            <div class="col-sm-3">
                                <input type="button" onclick="addSection()" class="btn btn-primary" value="Adicionar">
                            </div>
                        </div>                        
                    
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>