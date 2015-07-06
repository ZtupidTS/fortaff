<?php
# vou buscar o ficheir xml

#$aContext = array(
#		'http' => array(
#        'proxy' => 'tcp://proxy.uminho.pt:3128',
#        'request_fulluri' => true,
#    ),
#);
#$cxContext = stream_context_create($aContext);
#$resultado = file_get_contents("http://www.google.com/ig/api?weather=London&hl=pt-pt", False, $cxContext);

$resultado = file_get_contents('xml/weather.xml');
#$resultado = file_get_contents('http://www.google.com/ig/api?weather=London&hl=pt-pt');

#$xml = simplexml_load_string(utf8_encode($resultado));
$xml = simplexml_load_string($resultado);

#lê o ficheiro xml e guarda nessas variáveis os dados necessários
$dados['info'] = $xml->xpath('/xml_api_reply/weather/forecast_information');
$dados['atual'] = $xml->xpath('/xml_api_reply/weather/current_conditions');
$dados['proximos'] = $xml->xpath('/xml_api_reply/weather/forecast_conditions');

#aqui vou ao meu array $dados['info'] onde recupero a posição 0 porque não há nós depois
#e onde pego a informação que quero
?>
<div class="pre_tempo">
	
			<?php
			#zé aqui esta o codigo do tempo o "marquee" é que faz aquilo mexer mas o que precisas esta aqui.
			#tempo de hoje 
			?>
			<table class="bordertabela">
				<tr>
					<td>
						<?php echo 'Atual ';?>
					</td>
					<td>	
						<img src="http://www.google.com<?= $dados['atual'][0]->icon['data'];?>" alt="Previsão" title="Previsão"/>
					</td>
					<td colspan="2">
						<?php echo " ".$dados['atual'][0]->temp_c['data']."ºC"."<br>"; ?>
					</td>
				</tr>
				<?php
				#os dias a seguir
				for($i=1;$i<sizeOf($dados['proximos']);$i++)
				{
				?>
				<tr>
					<td>
						<?php
							echo utf8_decode($dados['proximos'][$i]->day_of_week['data']).' ';
						?>
					</td>
					<td>
						<img src="http://www.google.com<?= $dados['proximos'][$i]->icon['data'];?>" alt="Previsão" title="Previsão"/>
					</td>
					<td>
						<?php echo $dados['proximos'][$i]->low['data']."ºC"; ?>
					</td>	
					<td>	
						<?php echo $dados['proximos'][$i]->high['data']."ºC"; ?>
					</td>
					<?php } ?>		
				</tr>
			</table>
</div>
	
	