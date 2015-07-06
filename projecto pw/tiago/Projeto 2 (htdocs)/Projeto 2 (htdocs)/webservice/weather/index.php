<?php

function  iconv_utf2iso($string)
{
	return iconv("UTF-8", "ISO-8859-1//IGNORE", $string);
}


//Identificação da Cidade e Idioma
//$local = 'Fafe'; // Cidade
$idioma = 'pt-pt'; // Idioma de resposta (pt-pt)

// URL principal da API
$googleWeather = 'http://www.google.com/ig/api';

// Criar URL com parametros de entrada (Cidade e Idioma)
$apiUrl = $googleWeather . '?weather=' . urlencode($local) . '&hl=' . $idioma;

//com proxy
// $opts = array('http' => array('proxy' => 'tcp://proxy.uminho.pt:3128', 'request_fulluri' => true)); //'tcp://127.0.0.1:8080'
// $context = stream_context_create($opts);
// $data = file_get_contents($apiUrl, false, $context);
//$xml = simplexml_load_string(utf8_encode($data));

//sem proxy
// Obter resultado
$resultado = file_get_contents($apiUrl);

// O SimpleXML precisa receber valores em UTF-8, então usamos o uft8_encode()
$xml = simplexml_load_string(utf8_encode($resultado));

// Separar informações obtidas
$info = $xml->xpath('/xml_api_reply/weather/forecast_information');
$atual = $xml->xpath('/xml_api_reply/weather/current_conditions');
$proximos = $xml->xpath('/xml_api_reply/weather/forecast_conditions');

setlocale(LC_ALL, 'pt_PT.ISO8859-1');

?>
<html>
<head>
<meta http-equiv="Content-Type"content="text/html; charset=UTF-8" />
</head>
<h3 id="tempo_h3">Hoje (<?php echo date('d/m/Y', strtotime($info[0]->forecast_date['data'])); ?>)</h3>
<table>
	<tr>
		<td><img src="http://www.google.com<?php echo $atual[0]->icon['data']; ?>" alt="weather" /></td>
		<td><?php echo $atual[0]->temp_c['data']; ?>&deg; C
		<br /><?php echo $atual[0]->condition['data']; ?></td>
	</tr>
</table>
<h3 id="tempo_h3_1">Próximos dias</h3>
<table>
	<?php foreach ($proximos AS $item) { ?>
	<tr>
		<td><img src="http://www.google.com<?php echo $item->icon['data']; ?>" alt="weather" /></td>
		<td><?= utf8_decode($item->day_of_week['data']);?><br/><?php echo $item->low['data']; ?>/<?php echo $item->high['data']; ?>&deg; C<br /><?php echo utf8_decode($item->condition['data']); ?></td>
	</tr>
	<?php } ?>
</table>
<p>Cidade:<br/> <?php echo $info[0]->city['data']; ?></p>
</html>