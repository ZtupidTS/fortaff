<?php
include '../includes/allpageaj.php';

$fields = array();

if($_GET['coberturanova'] != '')
{
	$fields2 = array();
	$fields2['pp_cobertura_designacao'] = dbString(control_post($_GET['coberturanova']));
	$idcobertura = coberturaInsert($fields2);
	unset($fields2);
	$fields['pp_bolo_coberturaid'] = dbInteger($idcobertura);
}else{
	$fields['pp_bolo_coberturaid'] = dbInteger(control_post($_GET['idcobertura']));
}

if($_GET['recheionova'] != '')
{
	$fields2 = array();
	$fields2['pp_recheio_designacao'] = dbString(control_post($_GET['recheionova']));
	$idrecheio = recheioInsert($fields2);
	unset($fields2);
	$fields['pp_bolo_recheioid'] = dbInteger($idrecheio);
}else{
	$fields['pp_bolo_recheioid'] = dbInteger(control_post($_GET['idrecheio']));
}

if($_GET['massanova'] != '')
{
	$fields2 = array();
	$fields2['pp_massa_designacao'] = dbString(control_post($_GET['massanova']));
	$idmassa = massaInsert($fields2);
	unset($fields2);
	$fields['pp_bolo_massaid'] = dbInteger($idmassa);
}else{
	$fields['pp_bolo_massaid'] = dbInteger(control_post($_GET['idmassa']));
}

$fields['pp_bolo_nome'] = dbString(control_post($_GET['nomebolo']));

$idbolonosso = boloInsert($fields);
unset($fields);

$postfilename = $_GET['filename'];
$postfilename = str_ireplace("\\", "/", $postfilename);
$file_new = explode("/", $postfilename);
foreach ($file_new as $v)
{
	//print_r($file_new);
	//echo ' s ';
	if(strpos($v, ".") !== false)
	{
		$filefinal = explode(".", $v);
		//print_r($filefinal);
		rename('../bolos/' . $filefinal[0] . "." . $filefinal[1], '../bolos/' . $idbolonosso . '.' . $filefinal[1]);
		//agora vou guardar isso na DB			
		$fields = array();
		$fields['pp_bolo_id'] = dbInteger($idbolonosso);
		$fields['pp_bolo_urlimage'] = dbString('bolos/' . $idbolonosso . '.' . $filefinal[1]);
		boloUpdate($fields);
		unset($fields);
	}
}   

echo 'ok';

insertmodifbolonosso($idbolonosso, "Criação do bolo");

closeDataBase();
?>