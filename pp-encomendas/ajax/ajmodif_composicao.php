<?php
include '../includes/allpageaj.php';

$id = control_post($_GET['id']);
$enable = control_post($_GET['ativar']);

//vou inserir na DB
$fields = array();
$fields['pp_bolo_id'] = dbInteger($id);
$fields['pp_bolo_enable'] = dbInteger($enable);
boloUpdate($fields);
unset($fields);

if($enable == '0')
{
	insertmodifbolonosso($id, "Bolo desativado");
}else{
	insertmodifbolonosso($id, "Bolo activado");	
}

echo 'ok';

closeDataBase();
?>