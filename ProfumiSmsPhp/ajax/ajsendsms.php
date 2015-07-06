<?php
include '../includes/allpage.php';

//ez4u antigo gajo das sms
//require('../sms/bootstrap.php');

require_once 'Egoi/Factory.php';

//configuração
$apikey = $_SESSION['apikey_sms'];
$list = $_SESSION['list_sms'];
$user = $_SESSION['user_sms'] ;
$pass = $_SESSION['pass_user_sms'];

//com o 3z4u eu usava o smsid, neste caso vou meter o hash da campaign no smsid 
//$campaign = "41442e668e695065749c855de6404d9a";

$message = $_POST['sms'];
$number = $_POST['contacto'];
$continu = true;

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
	'subject'   => 'Profumi',
	'from'    	=> 'Profumi');

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
		$fields['sms_date'] = dbString(date('Y-m-d H:i:s', time() - 3600));
		//$fields['id'] = dbInteger($_POST['id_gr']);
		$fields['state'] = dbString('0');
		$fields['smsid'] = dbString($lastsmsid);
		$fields['user_name'] = dbString($_SESSION['username']);
		$fields['sms_contact'] = dbInteger($number);
		$fields['sms_text'] = dbString($message);
		smsInsert($fields);
		unset($fields);
		
		//agora a tabela modif
		//insertmodifgr($_POST['id_gr'], 'Mensagem processada, verificar dentro de 5 min o estado dela');
		/*if(strlen($error) > 0 )
		{
			echo $error;	
		}else{*/
		echo "ok";	
		//}
	}else{
		echo "Mensagem não foi enviada, tente novamente";
	}
}else{
	echo "O contacto do cliente não é um numero de telemóvel viável";		
}

closeDataBase();
?>