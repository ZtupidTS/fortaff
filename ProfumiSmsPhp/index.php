<?php include 'includes/header.php'; ?>
                
    <?php if($login == "Entrar"){ ?>
      <div class="row">
        <div class="col-md-7 col-md-offset-3"">
            <form name="changegr" class="form-horizontal" onsubmit="return false;">
              <fieldset>
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="textinput" >Login</label>
                    <div class="col-sm-4">
	                    <select id="cblogin" class="form-control">
	                        <option></option>
	                        <?php 
	                        $user = loginGetAllWithoutAdmin();

	                        while ($us = foreachRow($user)) 
	                        {?>
	                            <option value="<?= $us['id'];?>"><?= $us['name'];?></option>
	                            <?php
	                        }?>
	                    </select>
	            </div>                           
                </div>
                <div class="form-group">
                        <label class="col-sm-4 control-label" for="textinput">Password</label>
                        <div class="col-sm-4">
                          <input type="password" name="password" id="password" maxlength="30" class="form-control" onkeyup="if(event.keyCode == 13) Login()">
                        </div>
                        <div class="col-sm-3">
	                    <input type="button" onclick="Login()" class="btn btn-primary" value="Entrar">
	                </div>
                </div>
            </fieldset>
          </form>
    	</div><!-- /.col-lg-12 -->
    </div><!-- /.row -->    
   <?php } ?>
        

  
<?php include 'includes/footer.php';?>