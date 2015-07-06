<?php
# vou buscar o ficheir xml

#$aContext = array(
#    'http' => array(
#        'proxy' => 'tcp://proxy.uminho.pt:3128',
#        'request_fulluri' => true,
#    ),
#);
#$cxContext = stream_context_create($aContext);
#$resultado = file_get_contents("http://www.tvi24.iol.pt/rss.html", False, $cxContext);

# vou buscar o ficheir xml
$resultado = file_get_contents('xml/tvi.xml');
#$resultado = file_get_contents('http://www.tvi24.iol.pt/rss.html');

$xml = simplexml_load_string(utf8_encode($resultado));
#$xml = simplexml_load_string($resultado);

#lê o ficheiro xml e guarda nessas variáveis os dados necessários
$dados['info'] = $xml->xpath('/rss/channel/item');

?>
<div class="feed_noticias">
	<marquee Class="Scroller" behavior="scroll" direction="left"  scrollamount="2" scrolldelay="0" onmouseover="this.stop()" onmouseout="this.start()">
			<?php
			foreach ($dados['info'] as $item) 
			{
				?>
				<a href="<?=$item->link;?>" title="Informação TVI24" alt="Informação TVI24"><?=utf8_decode($item->title);?> | </a>
				<?php
			}?>
	</marquee>
</div>
