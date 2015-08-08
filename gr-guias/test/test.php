<?php
include '../includes/allpageaj.php';
include '../includes/conf.php';
include '../fonction/function.php';

require_once '../ajax/Egoi/Factory.php';

$params = array(
	'apikey'    => $_SESSION['apikey_sms'],
	'listID'    => '25',
	'cellphone'    => '962411301',
	'message'   => 'test',
	'subject'   => 'Bazar SAV',
	'from'    	=> 'E.Leclerc');

	$client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
	$result = $client->sendSMS($params);
	
	print_r($result);
?>