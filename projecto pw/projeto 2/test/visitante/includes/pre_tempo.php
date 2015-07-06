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

#l� o ficheiro xml e guarda nessas vari�veis os dados necess�rios
$dados['info'] = $xml->xpath('/xml_api_reply/weather/forecast_information');
$dados['atual'] = $xml->xpath('/xml_api_reply/weather/current_conditions');
$dados['proximos'] = $xml->xpath('/xml_api_reply/weather/forecast_conditions');

#aqui vou ao meu array $dados['info'] onde recupero a posi��o 0 porque n�o h� n�s depois
#e onde pego a informa��o que quero
?>
<div class="pre_tempo">
	
			<?php
			#z� aqui esta o codigo do tempo o "marquee" � que faz aquilo mexer mas o que precisas esta aqui.
			#tempo de hoje 
			?>
			<table class="bordertabela">
				<tr>
					<td>
						<?php echo 'Atual ';?>
					</td>
					<td>	
						<img src="http://www.google.com<?= $dados['atual'][0]->icon['data'];?>" alt="Previs�o" title="Previs�o"/>
					</td>
					<td colspan="2">
						<?php echo " ".$dados['atual'][0]->temp_c['data']."�C"."<br>"; ?>
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
						<img src="http://www.google.com<?= $dados['proximos'][$i]->icon['data'];?>" alt="Previs�o" title="Previs�o"/>
					</td>
					<td>
						<?php echo $dados['proximos'][$i]->low['data']."�C"; ?>
					</td>	
					<td>	
						<?php echo $dados['proximos'][$i]->high['data']."�C"; ?>
					</td>
					<?php } ?>		
				</tr>
			</table>
</div>
	
	