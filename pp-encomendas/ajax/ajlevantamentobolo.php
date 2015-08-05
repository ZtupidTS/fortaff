<?php
include '../includes/allpageaj.php';

$idenc = control_post($_GET['idenc']);

$data = encomendasGetById($idenc);

if(strlen($data['pp_enc_datalevantamento']) > 2)
{
	echo 'Levantamento já registado para essa encomenda';	
	insertmodifencomenda($idenc, "Tentativa de registo de levantamento pelo cliente");
}else{
	//vou inserir na DB
	$fields = array();
	$fields['pp_enc_datalevantamento'] = dbString(date('Y-m-d H:i:s', time() - 3600));
	$fields['pp_enc_id'] = dbInteger($idenc);
	encomendasUpdate($fields);
	unset($fields);

	insertmodifencomenda($idenc, "Levantamento pelo cliente");

	echo 'ok';
}

closeDataBase();
?>