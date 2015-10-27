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
$fields['id'] = dbInteger($idguia);
$fields['art_valorcamento'] = dbFloat($_POST['valor']);
grepUpdate($fields);
unset($fields);

insertmodifgr($idguia, "Inserção do valor do orçamento");
echo 'ok';

closeDataBase();
?>