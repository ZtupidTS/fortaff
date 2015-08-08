<?php
include '../includes/allpageaj.php';

$fields = array();


//echo $_GET['campo'];
//$where .= $_POST['campo'] . " = " . $_POST['valor'];
$data = reparadorGetById($_GET['campo']);
?>
<div class="form-group">
	<label class="col-sm-3 control-label" for="textinput" >Nome do reparador</label>
	<div class="col-sm-9">
		<input value="<?= $data['rep_name'];?>" disabled type="text" name="cl_name" class="form-control" maxlength="100" required>
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

closeDataBase();
?>