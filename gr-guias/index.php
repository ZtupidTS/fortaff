<?php include 'includes/header.php'; ?>
                
        <?php if($login == "Entrar"){ ?>
            <div class="form-group">
                <div class="col-sm-2 col-md-offset-4">
                    <select id="cblogin" class="form-control">
                        <option></option>
                        <?php 
                        $user = loginGetByEnableAdmin();

                        while ($us = foreachRow($user)) 
                        {?>
                            <option value="<?= $us['us_id'];?>"><?= $us['us_name'];?></option>
                            <?php
                        }?>
                    </select>
                </div>
                <div class="col-sm-4">
                    <input type="button" onclick="Login()" class="btn btn-primary" value="Entrar">
                </div>
            </div>
        <?php } ?>

  
<?php include 'includes/footer.php';?>