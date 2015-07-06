<?php
//iconv
$client = new SoapClient(null, array(
						'location' => "http://localhost/pw606/webservice/currencyconverter.php",
						'uri' => "http://localhost/pw606/webservice/",
						'trace' => 1));

$result = $client->helloWorld("Tiago");

if (is_soap_fault($result)){
	trigger_error("SOAP Fault: (faultcode: {$result->faultcode}, faultstring: {$result->faulstring})", E_ERROR);
} else {
	print_r($result);
}
?>