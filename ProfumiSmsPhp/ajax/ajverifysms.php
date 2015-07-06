<?php
include '../includes/allpage.php';

require_once 'Egoi/Factory.php';

$data = smsGetById(dbInteger($_POST['id_sms']));

$continu = true;

if(count($data) < 2)
{
	$continu = false;
	$texto = "Esse ID não existe";
}

if($data['state'] == "OK" && $continu)
{
	$continu = false;
	$texto = "O sms já foi entregue ao cliente";
}

$lastsmsid = $data['smsid'];//numero da sms id "LastSMSID"
if(strlen($lastsmsid) > 0 && $continu)
{
	$result = getreportegoi($lastsmsid);
	
	$sent = intval($result['SENT']);
	$delivered =  intval($result['DELIVERED']);
	$not_delivered = intval($result['NOT_DELIVERED']);
	$invalid = intval($result['INVALID']);

	if(($delivered - $not_delivered - $invalid) > 0)
	{
		$texto = "SMS enviado e recebido pelo cliente";
		$continu = false;
		$status = "OK";			
	}
	
	if(($not_delivered - $delivered - $invalid) > 0 && $continu)
	{
		$texto = "SMS enviado mas esta pendente";
		$continu = false;
		$status = "2";
	}
	
	if(($invalid - $delivered - $not_delivered) > 0 && $continu)
	{
		$texto = "SMS não entregue";
		$continu = false;
		$status = "3";
	}
	
	if($continu)
	{
		$texto = "SMS ainda não processado";
		//echo "SMS ainda não processado";
		$continu = false;
		$status = "0";
	}
	//aqui faço o update da tabela grep e faço o registo na tabela modif.
	$fields = array();
	$fields['id'] = dbInteger($_POST['id_sms']);
	$fields['state'] = dbString($status);
	smsUpdate($fields);
	unset($fields);	
}
unset($data);
unset($continu);
echo $texto;	

closeDataBase();
?>