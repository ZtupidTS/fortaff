<?php
include '../includes/allpageaj.php';

require_once 'Egoi/Factory.php';

$data = encomendasGetById(dbInteger($_POST['idenc']));

//require('../sms/bootstrap.php');
$continu = true;
if($data['pp_enc_statussms'] == 1)
{
	$continu = false;
	$texto = "O sms já foi entregue ao cliente";
}

if($data['pp_enc_statussms'] == 0 && strlen($data['pp_enc_datesms']) < 1)
{
	$continu = false;
	$texto = "Ainda não foi enviado sms ao cliente";
}

$lastsmsid = $data['pp_enc_smsid'];//numero da sms id "LastSMSID"
if(strlen($lastsmsid) > 0 && $continu)
{
	$result = getreportegoi($lastsmsid);
	
	$sent = intval($result['SENT']);
	$delivered =  intval($result['DELIVERED']);
	$not_delivered = intval($result['NOT_DELIVERED']);
	$invalid = intval($result['INVALID']);

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
	$fields['pp_enc_datesms'] = dbString(date('Y-m-d H:i:s', time() - 3600));
	$fields['pp_enc_id'] = dbInteger($_POST['idenc']);
	$fields['pp_enc_statussms'] = dbString($status);
	encomendasUpdate($fields);
	unset($fields);
	//agora a tabela modif
	insertmodifencomenda($_POST['idenc'], $texto);
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