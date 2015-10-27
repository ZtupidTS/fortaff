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

//$data = grepGetById($_POST['id_gr']);

if(strlen($data['date_tocliente']))
{
	echo 'A guia já foi fechada ou entregue ao cliente';
}else{
	$fields = array();
	$fields['id'] = $idguia;
	$fields['date_tocliente'] = dbString(date('Y-m-d H:i:s', time() - 3600));
	grepUpdate($fields);
	unset($fields);

	insertmodifgr($idguia, $_POST['comment']);

	echo 'ok';	
}

closeDataBase();
?>