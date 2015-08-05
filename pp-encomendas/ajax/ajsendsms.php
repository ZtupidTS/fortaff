<?php
include '../includes/allpageaj.php';

//ez4u antigo gajo das sms
//require('../sms/bootstrap.php');

require_once 'Egoi/Factory.php';

//configuração
$apikey = $_SESSION['apikey_sms'];
$list = $_SESSION['list_sms'];
$user = $_SESSION['user_sms'] ;
$pass = $_SESSION['pass_user_sms'];
$message = $_SESSION['message_sms'];

//com o 3z4u eu usava o smsid, neste caso vou meter o hash da campaign no smsid 
//$campaign = "41442e668e695065749c855de6404d9a";

$data = encomendasGetById(dbInteger($_GET['idenc']));
$continu = true;

if(strlen($data['pp_enc_datesms']) > 0)
{
	echo 'O sms já foi enviado para essa encomenda, verificar o estado da sms';
	$continu = false;
}

$number = $data['pp_enc_clientcontact'];

if($number[0] == "9" && $continu)
{
	//antes de enviar tenho que verificar se já existe na lista
	//$exist_number = getnumberexist($number);	
	
	//enviar
	/*$defined = '';
	$reference = '';
	if(strlen($exist_number) > 0)
	{
		//'uid' => $exist_number
		$defined = 'uid';
		$reference = $exist_number;
	}else{
		//'cellphone' => $number,
		$defined = 'cellphone';
		$reference = $number;
	}*/
	
	
	
	
	/*$url = 'https://www51.e-goi.com/api/public/sms/send';
	
	$params = array(
	'apikey'    => $apikey,
	'group' => 'default',
	'senderHash' => 'c2d2abcf1074b37fe4095594a9eb7347',
	'message'   => $message,
	
	'mobile' => '351-962411301'
	);
	
	$options = array(
	    'http' => array(
	        'method' => 'POST',
	        'header' => 'Content-type: application/json',
	        'ignore_errors' => true,
	        'content' => json_encode($params)
	    )
	);
	
	$response = file_get_contents($url, false, stream_context_create($options));
	
	$json = json_decode($response, true);

	print_r($json);
	
	$int = $json;*/
	
	$url = 'https://www51.e-goi.com/api/public/stats/sms/sends';
	
	$params = array(
	
	  'apikey'    => $apikey,
	  'limit' => 1,
  	  'start' => 0
	);
	
	$options = array(
	    'http' => array(
	        'method' => 'POST',
	        'header' => 'Content-type: application/json',
	        'ignore_errors' => true,
	        'content' => json_encode($params)
	    )
	);
	
	$response = file_get_contents($url, false, stream_context_create($options));
	
	$json = json_decode($response, true);

	print_r($json);
	
	
/*	// using Soap with SoapClient
$client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
$result = $client->getSenders($params);
print_r($result);
	*/
	
	/*$client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
	$result = $client->sendSMS($params);
	
	
	$lastsmsid = $result['CAMPAIGN'];
	unset($result);
	unset($params);*/
	
	//print_r($result);
	
	

	

	
	
	
	
	
	
	
	
	
	
	
	//aqui um if porque a partir daqui se der erro é só
	// verificar porque a sms pode ter sida enviada
	/*if(strlen($lastsmsid) > 0)
	{
		//aqui faço o update da tabela grep e faço o registo na tabela modif.
		$fields = array();
		$fields['date_sms'] = dbString(date('Y-m-d H:i:s', time() - 3600));
		$fields['id'] = dbInteger($_POST['id_gr']);
		$fields['status_sms'] = dbString('0');
		$fields['sms_id'] = dbString($lastsmsid);
		grepUpdate($fields);
		unset($fields);
		
		//agora a tabela modif
		insertmodifgr($_POST['id_gr'], 'Mensagem processada, verificar dentro de 5 min o estado dela');
		
		echo "Mensagem processada, verificar dentro de 25 min o estado dela";
		//depois de enviar vou aguardar um pouco para eles atualizar o mesmo
		
	}else{
		echo "Mensagem não foi enviada, tente novamente";
	}*/
}else{
	/*if($continu)
	{
		//agora a tabela modif
		insertmodifgr($_POST['id_gr'], "O numero do cliente não é um telemóvel");
		echo "O contacto do cliente não é um numero de telemóvel viável";
	}*/	
}

closeDataBase();
?>