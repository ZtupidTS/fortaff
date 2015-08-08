<?php
include '../includes/allpageaj.php';

$fields = array();

switch ($_POST['campo']) {
  case "id":
    $field['id'] = dbInteger($_POST['valor']);
    break;
  case "cl_name":
    $field['cl_name'] = dbString($_POST['valor']);
    break;
  case "cl_contacto":
    $field['cl_contacto'] = dbInteger($_POST['valor']);
    break;
}



?>
<!-- Text input-->
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Utilizador</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?= $_SESSION['username'];?>" disabled/>
                      </div>
                    </div>

                    <legend>Cliente</legend>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput" >Nome do Cliente</label>
                      <div class="col-sm-10">
                        <input type="text" name="cl_name" class="form-control" maxlength="100" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Morada</label>
                      <div class="col-sm-10">
                        <input type="text" name="cl_morada" maxlength="100" class="form-control" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Localidade</label>
                      <div class="col-sm-4">
                        <input type="text" name="cl_localidade" maxlength="100" class="form-control" required>
                      </div>
                      <label class="col-sm-3 control-label" for="textinput">Codigo Postal</label>
                      <div class="col-sm-3">
                        <input type="text" name="cl_codpostal" placeholder="0000-000" maxlength="8" class="form-control" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Contacto</label>
                      <div class="col-sm-4">
                          <input type="text" maxlength="9" name="cl_contacto" class="form-control" required>
                      </div>
                    </div>

                    <!--artigo--> 
                    <legend>Artigo</legend>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Marca</label>
                        <div class="col-sm-3">
                            <input type="text" name="art_marca" maxlength="30" class="form-control" required>
                        </div>
                        <label class="col-sm-1 control-label" for="textinput">Tipo</label>
                        <div class="col-sm-6">
                            <input type="text" name="art_tipo" maxlength="50" placeholder="maquina..." class="form-control" required>
                        </div>                  
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Modelo</label>
                        <div class="col-sm-4">
                          <input type="text" name="art_modelo" maxlength="30" class="form-control" required>
                        </div>
                        <label class="col-sm-2 control-label" for="textinput">Nº Série</label>
                        <div class="col-sm-4">
                          <input type="text" name="art_numserie" maxlength="50" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Cod. Barras</label>
                        <div class="col-sm-4">
                            <input type="text" name="art_ean" maxlength="13" class="form-control">
                        </div>                  
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Acessórios</label>
                        <div class="col-sm-10">
                            <textarea name="art_acessorio" maxlength="100" class="form-control"></textarea>
                        </div>                  
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Estética</label>
                        <div class="col-sm-10">
                            <textarea name="art_estetic" maxlength="100" class="form-control"> </textarea>
                        </div>                  
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Talão</label>
                        <div class="col-sm-4">
                          <input type="text" name="art_numtalao" placeholder="00/00/00 0 000A 00X00" maxlength="30" class="form-control">
                        </div>
                        <label class="col-sm-1 control-label" for="textinput">Valor</label>
                        <div class="col-sm-3">
                          <input type="text" name="art_valor" maxlength="8" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Garantia</label>
                        <div class="col-sm-1">
                            <input class="checkbox" type="checkbox" class="form-control" onchange="dataGarantia()">
                        </div>
                        <label class="col-sm-1 control-label" for="textinput">Data</label>
                        <div class="col-sm-3">
                            <input name="garantia" id="garantia" type="text" maxlength="10" placeholder="00-00-0000" class="form-control" disabled>
                        </div>
                        
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Orçamento</label>
                        <div class="col-sm-1">
                            <input class="checkbox" name="art_orcamento" type="checkbox" class="form-control">
                        </div>                
                    </div>

                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <div class="pull-right">
                          <input type="button" onclick="validateInsert()" class="btn btn-primary" value="Guardar">
                        </div>
                      </div>
                    </div>

<?php
closeDataBase();
?>
                    