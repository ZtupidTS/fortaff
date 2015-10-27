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
$fields['date_torep'] = dbString(date('Y-m-d H:i:s', time() - 3600));

grepUpdate($fields);

unset($fields);

insertmodifgr($idguia, "Artigo Levantado pelo reparador");

echo 'ok';

closeDataBase();
?>