<?php include 'includes/header.php'; ?>


    <script src="js/validateInsertRep.js"></script>

    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <form name="insertreparador" class="form-horizontal" onsubmit="return false;" >
                <fieldset>

                    <!-- Form Name -->
                    <legend>Inserir Reparador</legend>

                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Utilizador</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?= $_SESSION['username'];?>" disabled/>
                      </div>
                    </div>

                    <legend>Reparador</legend>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput" >Nome</label>
                      <div class="col-sm-10">
                        <input type="text" name="rep_name" class="form-control" maxlength="100" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Morada</label>
                      <div class="col-sm-10">
                        <input type="text" name="rep_morada" maxlength="100" class="form-control">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="textinput">Email</label>
                      <div class="col-sm-4">
                          <input type="text" maxlength="50" name="rep_email" class="form-control" >
                      </div>
                      <label class="col-sm-2 control-label" for="textinput">Email2</label>
                      <div class="col-sm-4">
                          <input type="text" maxlength="50" name="rep_email2" class="form-control" >
                      </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Contacto 1</label>
                        <div class="col-sm-3">
                            <input type="text" name="rep_telefone1" maxlength="9" class="form-control">
                        </div>
                        <label class="col-sm-1 control-label" for="textinput">Nome</label>
                        <div class="col-sm-6">
                            <input type="text" name="rep_nome1" maxlength="30" class="form-control">
                        </div>                  
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Contacto 2</label>
                        <div class="col-sm-3">
                            <input type="text" name="rep_telefone2" maxlength="9" class="form-control">
                        </div>
                        <label class="col-sm-1 control-label" for="textinput">Nome</label>
                        <div class="col-sm-6">
                            <input type="text" name="rep_nome2" maxlength="30" class="form-control">
                        </div>                  
                    </div>

                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <div class="pull-right">
                          <input type="button" onclick="validateInsertRep()" class="btn btn-primary" value="Guardar">
                        </div>
                      </div>
                    </div>

                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->


<?php include 'includes/footer.php';?>