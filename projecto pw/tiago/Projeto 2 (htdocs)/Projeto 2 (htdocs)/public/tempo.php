<?php

//Identificação da Cidade e Idioma
$cidade = 'London'; // Cidade
$idioma = 'pt-pt'; // Idioma de resposta (pt-pt)

// URL principal da API
$googleWeather = 'http://www.google.com/ig/api';

// Criar URL com parametros de entrada (Cidade e Idioma)
$apiUrl = $googleWeather . '?weather=' . urlencode($cidade) . '&hl=' . $idioma;

// Obter resultado
$resultado = file_get_contents($apiUrl);

// O SimpleXML precisa receber valores em UTF-8, então usamos o uft8_encode()
$xml = simplexml_load_string(utf8_encode($resultado));

// Separar informações obtidas
$info = $xml->xpath('/xml_api_reply/weather/forecast_information');
$atual = $xml->xpath('/xml_api_reply/weather/current_conditions');
$proximos = $xml->xpath('/xml_api_reply/weather/forecast_conditions');

?>
<html>
<head>
<meta http-equiv="Content-Type"content="text/html; charset=UTF-8" />
</head>
<h3>Hoje - <?php echo date('d/m/Y', strtotime($info[0]->forecast_date['data'])); ?></h3>
<table>
	<tr>
		<td><img src="http://www.google.com<?php echo $atual[0]->icon['data']; ?>" alt="weather" /></td>
		<td><?php echo $atual[0]->temp_c['data']; ?>&deg; C<br /><?php echo $atual[0]->condition['data']; ?></td>
	</tr>
</table>
<?php echo utf8_encode("<h3>Próximos dias</h3>") ?>
<table>
	<?php foreach ($proximos AS $item) { ?>
	<tr>
		<td><?php echo $item->day_of_week['data'];?></td>
		<td><img src="http://www.google.com<?php echo $item->icon['data']; ?>" alt="weather" /></td>
		<td><?php echo $item->low['data']; ?>/<?php echo $item->high['data']; ?>&deg; C<br /><?php echo $item->condition['data']; ?></td>
	</tr>
	<?php } ?>
</table>
<p>Cidade: <?php echo $info[0]->city['data']; ?></p>
</html>
