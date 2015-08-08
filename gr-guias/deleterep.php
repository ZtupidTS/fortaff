<?php include 'includes/header.php'; ?>
    
    <script>
    function eliminarReparador()
    {
        var e = document.getElementById('cbsearchreparador');
        var rep_id = e.options[e.selectedIndex].value;
        if(rep_id == '')
        {
            alert('Tem de seleccionar um reparador');
            document.getElementById('cbsearchreparador').focus();
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
                        alert("Reparador Eliminado");
                        window.location = "index.php";                        
                    }else{
                        alert(xhr.responseText);
                        //alert('tenta de novo');
                    }                    
                }
        }
        xhr.open("POST","ajax/ajdeleterep.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send('id_rep='+rep_id);        
    }
    
    </script>



    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form name="changegr" class="form-horizontal" >
                <fieldset>

                    <!-- Form Name -->
                    <legend>Eliminar Reparador</legend>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="textinput" >Reparador</label>
                            <div class="col-sm-6">
                                <select id="cbsearchreparador" class="form-control">
                                    <option></option>
                                    <?php
                                    $table = reparadorGetAll();
                                    while($data = mysql_fetch_array($table))
                                    {?>
                                        <option value="<?= $data['rep_id'];?>"><?= $data['rep_name'];?></option>
                                        <?php
                                    }?>
                                </select>                            
                            </div>
                            <div class="col-sm-3">
                                <input type="button" onclick="eliminarReparador()" class="btn btn-primary" value="Eliminar">
                            </div>
                        </div>                      
                    
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>