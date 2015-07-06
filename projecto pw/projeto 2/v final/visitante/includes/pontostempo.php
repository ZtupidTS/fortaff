<?php
$fp = fopen('js/pontostempo.js', 'w+');
fwrite($fp, "var pontostempo = ["."\n");

for($i=0;$i<sizeOf($tempo_array);$i++)
{
	fwrite($fp, "{partida_lat:".$tempo_array[$i]['partida_lat'].",partida_lng:".$tempo_array[$i]['partida_lng'].",chegada_lat:".$tempo_array[$i]['chegada_lat'].",chegada_lng:".$tempo_array[$i]['chegada_lng'].",tempo:".$tempo_array[$i]['tempo']."},"."\n");
}
fwrite($fp, "];");
fclose($fp);
?>