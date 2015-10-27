<?php
include '../includes/allpageaj.php';

require_once 'Egoi/Factory.php';

if (strpos($_POST['id_gr'],'-') !== false) 
{
	$data = grepGetByGrNumber($_POST['id_gr']);
}else{
	$data = grepGetById($_POST['id_gr']);	
}

//$data = grepGetById(dbInteger($_POST['id_gr']));

require('../sms/bootstrap.php');
$continu = true;
if($data['status_sms'] == 1)
{
	$continu = false;
	$texto = "O sms já foi entregue ao cliente";
}

if($data['status_sms'] == 0 && strlen($data['date_sms']) < 1)
{
	$continu = false;
	$texto = "Ainda não foi enviado sms ao cliente";
}



$lastsmsid = $data['sms_id'];//numero da sms id "LastSMSID"
if(strlen($lastsmsid) > 0 && $continu)
{
	//$versms = verifysms($lastsmsid);
	//$status = $versms->body->MessageInfo->DeliveryStatus;
	
	$result = getreportegoi($lastsmsid);
	
	$sent = intval($result['SENT']);
	$delivered =  intval($result['DELIVERED']);
	$not_delivered = intval($result['NOT_DELIVERED']);
	$invalid = intval($result['INVALID']);

	//DeliveryStatus
	// 0 - mensagem ainda não procesada
	// 1 - mensagem enviada e recebida
	// 2 - mensagem enviada e em entregue (pendente)
	// 3 - mensagem não entregue
	/*$continu = true;

	while($continu)
	{
		switch($status){
		case 0:
			$versms = verifysms($lastsmsid);
			$status = $versms->body->MessageInfo->DeliveryStatus;
			break;
		case 1:
			$texto = "SMS enviado e recebido pelo cliente";
			$continu = false;
			break;
		case 2:
			$texto = "SMS enviado mas esta pendente";
			$continu = false;
			break;
		case 3:
			$texto = "SMS não entregue";
			$continu = false;
			break;
		default:
			break;
		}
	}*/
	$continu = true;
		
	if(($delivered - $not_delivered - $invalid) > 0)
	{
		$texto = "SMS enviado e recebido pelo cliente";
		$continu = false;
		$status = 1;			
	}
	
	if(($not_delivered - $delivered - $invalid) > 0 && $continu)
	{
		$texto = "SMS enviado mas esta pendente";
		$continu = false;
		$status = 2;
	}
	
	if(($invalid - $delivered - $not_delivered) > 0 && $continu)
	{
		$texto = "SMS não entregue";
		$continu = false;
		$status = 3;
	}
	
	if($continu)
	{
		$texto = "SMS ainda não processado";
		//echo "SMS ainda não processado";
		$continu = false;
		$status = 0;
	}
	//aqui faço o update da tabela grep e faço o registo na tabela modif.
	$fields = array();
	$fields['date_sms'] = dbString(date('Y-m-d H:i:s', time() - 3600));
	$fields['id'] = dbInteger($data['id']);
	$fields['status_sms'] = dbString($status);
	grepUpdate($fields);
	unset($fields);
	//agora a tabela modif
	insertmodifgr($data['id'], $texto);
}else{
	if($continu)
	{
		$texto = "O sms ainda não foi enviado ao cliente";
	}	
}
unset($data);
unset($continu);
echo $texto;	


closeDataBase();

?>