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

$data = grepGetById(dbInteger($_POST['id_gr']));
$continu = true;

if(strlen($data['date_sms']) > 0)
{
	echo 'O sms já foi enviado para essa guia, verificar o esta da sms';
	$continu = false;
}

$number = $data['cl_telefone'];

if($number[0] == "9" && $continu)
{
	//antes de enviar tenho que verificar se já existe na lista
	$exist_number = getnumberexist($number);	
	
	//enviar
	$defined = '';
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
	}
	$params = array(
	'apikey'    => $apikey,
	'listID'    => $list,
	$defined    => $reference,
	'message'   => $message,
	'subject'   => 'Bazar SAV',
	'from'    	=> 'E.Leclerc');

	$client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
	$result = $client->sendSMS($params);
	
	
	$lastsmsid = $result['CAMPAIGN'];
	unset($result);
	unset($params);
	
	//print_r($result);
	
	//aqui um if porque a partir daqui se der erro é só
	// verificar porque a sms pode ter sida enviada
	if(strlen($lastsmsid) > 0)
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
		//sleep(90);
		
		//agora tenho que pegar no resultado de verificar a sms
		//ini_set('max_execution_time', 90);
		/*$result = getreportegoi($lastsmsid);
		
		$sent = intval($result['SENT']);
		$delivered =  intval($result['DELIVERED']);
		$not_delivered = intval($result['NOT_DELIVERED']);
		$invalid = intval($result['INVALID']);*/
		
		//print_r($result);
		//echo ' ds ' .$result['SENT'];
		//echo ' se ' .$sent;
		//aqui vou ver se foi enviado e se foi entregue
		/*if($sent == 1)
		{
			//DeliveryStatus
			// 0 - mensagem ainda não procesada
			// 1 - mensagem enviada e recebida
			// 2 - mensagem enviada e em entregue (pendente)
			// 3 - mensagem não entregue
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
				echo "SMS ainda não processado";
				$continu = false;
				$status = 0;
			}
			
			
			//aqui faço o update da tabela grep e faço o registo na tabela modif.
			$fields = array();
			$fields['date_sms'] = dbString(date("Y-m-d H-i-s"));
			$fields['id'] = dbInteger($_POST['id_gr']);
			$fields['status_sms'] = dbString($status);
			$fields['sms_id'] = dbString($lastsmsid);
			grepUpdate($fields);
			unset($fields);
			//agora a tabela modif
			insertmodifgr($_POST['id_gr'], $texto);
			if($continu)
			{
				echo 'ok';	
			}
		}else{
			echo "Mensagem foi enviada mas existe um problema, verifique mais tarde!!";
		}*/
	}else{
		echo "Mensagem não foi enviada, tente novamente";
	}
}else{
	if($continu)
	{
		//agora a tabela modif
		insertmodifgr($_POST['id_gr'], "O numero do cliente não é um telemóvel");
		echo "O contacto do cliente não é um numero de telemóvel viável";
	}	
}





//ez4u
/*


$number = $data['cl_telefone'];

if($number[0] == "9" && $continu)
{
	//aqui é para mandar
	$message = urlencode("Estimado cliente, O seu aparelho já se encontra reparado, queira logo que possivel deslocar-se a nossa loja para proceder ao seu levantamento. Obrigado.");
	$login = "FafeDis";
	$password = "34BB8CA7";
	$phonenumber = $data['cl_telefone'];
	$alfaSender = "E.Leclerc";

	$uri = "https://ziegen.dyndns.org/ez4usms/API/sendSMS.php?account=" . $login . "&licensekey=" . $password . "&phoneNumber=" . $phonenumber . "&messageText=" . $message . "&TTL=30&alfaSender=" . $alfaSender;

	$response = \Httpful\Request::get($uri)
	    ->expectsJson()
	    ->sendIt();  

	$result = $response->body->Result;//OK
	$lastsmsid = $response->body->LastSMSID;//numero da sms id "LastSMSID"
	//$lastsmsid = "14311545";

	sleep(15);

	//aqui vou ver se foi enviado e se foi entregue
	if($result == "OK")
	{
		/*$uri = "https://ziegen.dyndns.org/ez4usms/API/getSMSStatus.php?account=" . $login . "&licensekey=" . $password . "&smsID=" . $lastsmsid;

		$response = \Httpful\Request::get($uri)
		    ->expectsJson()
		    ->sendIt();*/
/*		
		$versms = verifysms($lastsmsid);

		$status = $versms->body->MessageInfo->DeliveryStatus;

		//DeliveryStatus
		// 0 - mensagem ainda não procesada
		// 1 - mensagem enviada e recebida
		// 2 - mensagem enviada e em entregue (pendente)
		// 3 - mensagem não entregue
		$continu = true;
		
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
		}
		//aqui faço o update da tabela grep e faço o registo na tabela modif.
		$fields = array();
		$fields['date_sms'] = dbString(date("Y-m-d H-i-s"));
		$fields['id'] = dbInteger($_POST['id_gr']);
		$fields['status_sms'] = dbString($status);
		$fields['sms_id'] = dbInteger($lastsmsid);
		grepUpdate($fields);
		unset($fields);
		//agora a tabela modif
		insertmodifgr($_POST['id_gr'], $texto);
		echo 'ok';	
		
	}else{
		echo "Mensagem não foi enviada, tente novamente";
	}
	
		
}else{
	if($continu)
	{
		//agora a tabela modif
		insertmodifgr($_POST['id_gr'], "O numero do cliente não é um telemóvel");
		echo "O contacto do cliente não é um numero de telemóvel viável";
	}	
}

*/

closeDataBase();


?>