<?php
include '../includes/allpageaj.php';

if (strpos($_POST['id_gr'],'-') !== false) 
{
	$data = grepGetByGrNumber($_POST['id_gr']);
}else{
	$data = grepGetById($_POST['id_gr']);
}


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
	//aqui vou inserir o novo tipo de numero de guia
	$lastnumbergr = newnumbergr();
	if($lastnumbergr != "")
	{
		$fields['gr_number'] = dbString($lastnumbergr);
	}
	
	$fields['id'] = grepInsert($fields);

	$_SESSION['lastidinsert'] = $fields['id'];
	$_SESSION['lastgr_number'] = $lastnumbergr;
	
	unset($fields);
	
	//aqui vou atualizar a guia antiga para dizer o que foi feito
	if($_SESSION['lastgr_number'] == "")
	{
		$novoobs = $data['obs'] . " Nova guia aberta com o nº" . $_SESSION['lastidinsert'];
	}else{
		$novoobs = $data['obs'] . " Nova guia aberta com o nº" . $_SESSION['lastgr_number'];	
	}
	
	$fields = array();
	$fields['id'] = $data['id'];
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
