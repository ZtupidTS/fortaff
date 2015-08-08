<?php
include '../includes/allpageaj.php';


$data = grepGetById($_POST['id_gr']);

if(sizeof($data) > 1)
{
	$fields = array();

	$fields['cl_name'] = dbString($data['cl_name']);
	$fields['cl_localidade'] = dbString($data['cl_localidade']);
	$fields['cl_morada'] = dbString($data['cl_morada']);
	$fields['cl_codpostal'] = $data['cl_codpostal'];
	$fields['cl_telefone'] = dbInteger($data['cl_telefone']);
	$fields['art_marca'] = dbString($data['art_marca']);
	$fields['art_modelo'] = dbString($data['art_modelo']);
	$fields['art_type']= dbString($data['art_type']);
	$fields['art_garantie']= dbInteger($data['art_garantie']);
	$fields['art_orcamento'] = dbInteger($data['art_orcamento']);
	$fields['id_user'] = $_SESSION['iduser'];
	$fields['date_in'] = dbString(date('Y-m-d H:i:s', time() - 3600));
	$fields['gr_enable'] = dbInteger(1);
	$fields['id_section'] = dbInteger($data['id_section']);

	if($data['art_anomalia'] != "")
	{
	    $fields['art_anomalia'] = dbString($data['art_anomalia']);
	}
	if($data['art_numserie'] != "")
	{
	    $fields['art_numserie']= dbString($data['art_numserie']);
	}
	if($data['art_acessor'] != "")
	{
	    $fields['art_acessor'] = dbString($data['art_acessor']);
	}

	$fields['obs'] = dbString($data['obs'] . ' Continuação da guia nº' . $_POST['id_gr']);	

	if($data['art_estetic'] != "")
	{
	    $fields['art_estetic'] = dbString($data['art_estetic']);
	}
	if($data['art_numtalao'] != "")
	{
	    $fields['art_numtalao'] = dbString($data['art_numtalao']);
	}
	if($data['art_valor'] != "")
	{
	    $fields['art_valor'] = $data['art_valor'];
	}
	if($data['art_dategar'] != "")
	{
	    $fields['art_dategar'] = dbString($data['art_dategar']);
	}
	if($data['art_ean'] != "")
	{
	    $fields['art_ean'] = dbInteger($data['art_ean']);
	}
	if($data['url_talao'] != "")
	{
	    $fields['url_talao'] = dbString($data['url_talao']);
	}

	$fields['id'] = grepInsert($fields);

	$_SESSION['lastidinsert'] = $fields['id'];
	
	unset($fields);
	
	//aqui vou atualizar a guia antiga para dizer o que foi feito
	$novoobs = $data['obs'] . " Nova guia aberta com o nº" . $_SESSION['lastidinsert'];
	$fields = array();
	$fields['id'] = $_POST['id_gr'];
	$fields['obs'] = dbString($novoobs);
	grepUpdate($fields);
	unset($fields);

	insertmodifgr($_SESSION['lastidinsert'], "Criação da guia a partir da guia nº". $_POST['id_gr']);

	echo 'ok';
}else{
	echo 'Guia de onde quer copiar não existe';
}

closeDataBase();
?>
