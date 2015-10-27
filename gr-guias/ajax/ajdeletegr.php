<?php
include '../includes/allpageaj.php';

if (strpos($_POST['id_gr'],'-') !== false) 
{
	$data = grepGetByGrNumber($_POST['id_gr']);
	$idguia = $data['id'];
}else{
	$data = grepGetById($_POST['id_gr']);	
	$idguia = $data['id'];
}

$fields = array();
$fields['id'] = $idguia;
$fields['gr_enable'] = 0;
grepUpdate($fields);
unset($fields);

insertmodifgr($idguia, "Guia eliminada ao pedido do funcionario: " . $_POST['func']);

echo 'ok';

closeDataBase();
?>