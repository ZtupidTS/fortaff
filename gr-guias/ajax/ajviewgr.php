<?php
include '../includes/allpageaj.php';

if (strpos($_GET['campo'],'-') !== false) 
{
	$data = grepGetByGrNumber($_GET['campo']);
}else{
	$data = grepGetById($_GET['campo']);	
}
//echo $_GET['campo'];
//$where .= $_POST['campo'] . " = " . $_POST['valor'];
//$data = grepGetById($_GET['campo']);
if(strlen($data['cl_name']) > 0)
{
	?>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="textinput" >Nome do Cliente</label>
		<div class="col-sm-10">
			<input value="<?= $data['cl_name'];?>" disabled type="text" name="cl_name" class="form-control" maxlength="100" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="textinput">Contacto</label>
		<div class="col-sm-4">
	  		<input type="text" value="<?= $data['cl_telefone'];?>" disabled maxlength="9" name="cl_telefone" id="cl_telefone" class="form-control" required>
		</div>                                            
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label" for="textinput">Marca</label>
		<div class="col-sm-3">
	    		<input type="text" value="<?= $data['art_marca'];?>" disabled name="art_marca" maxlength="30" class="form-control" required>
		</div>
		<label class="col-sm-1 control-label" for="textinput">Tipo</label>
		<div class="col-sm-6">
	    		<input type="text" value="<?= $data['art_type'];?>" disabled name="art_tipo" maxlength="50" class="form-control" required>
		</div>                  
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label" for="textinput">Modelo</label>
		<div class="col-sm-4">
	  		<input type="text" value="<?= $data['art_modelo'];?>" disabled name="art_modelo" maxlength="30" class="form-control" required>
		</div>
		<label class="col-sm-2 control-label" for="textinput">Nº Série</label>
		<div class="col-sm-4">
	  		<input type="text" value="<?= $data['art_numserie'];?>" disabled name="art_numserie" id="art_numserie" maxlength="50" class="form-control" required>
		</div>
	</div>
	<?php
	if($_GET['buttonname'] != "Anexar")
	{?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="textinput" ></label>
			<div class="col-sm-10">
				<input type="button" id="botaochangename" name="botaochangename" onclick="copyGr()" class="btn btn-primary" value="<?= $_GET['buttonname'];?>">
			</div>	
		</div>
		<?php 
	}
}
closeDataBase();
?>
                    