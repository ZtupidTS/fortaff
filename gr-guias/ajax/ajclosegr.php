<?php
include '../includes/allpageaj.php';

$data = grepGetById($_POST['id_gr']);

if(strlen($data['date_tocliente']))
{
	echo 'A guia já foi fechada ou entregue ao cliente';
}else{
	$fields = array();
	$fields['id'] = $_POST['id_gr'];
	$fields['date_tocliente'] = dbString(date('Y-m-d H:i:s', time() - 3600));
	grepUpdate($fields);
	unset($fields);

	insertmodifgr($_POST['id_gr'], $_POST['comment']);

	echo 'ok';	
}

closeDataBase();
?>