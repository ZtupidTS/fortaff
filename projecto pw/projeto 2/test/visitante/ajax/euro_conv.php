<?php

#$aContext = array(
#    'http' => array(
#        'proxy' => 'tcp://proxy.uminho.pt:3128',
#        'request_fulluri' => true,
#    ),
#);
#$cxContext = stream_context_create($aContext);
#$url = file_get_contents("http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency=EUR&ToCurrency=".$_GET['moeda'], False, $cxContext);
#$resultado = file_get_contents("http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency=EUR&ToCurrency=USD", False, $cxContext);

$url = "http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency=EUR&ToCurrency=".$_GET['moeda'];
$resultado = file_get_contents($url);

$xml = simplexml_load_string($resultado);
#$xml = simplexml_load_string(utf8_encode($resultado));

echo $xml[0];
?>