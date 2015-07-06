<?php
#vai calcular os dias que falta até o inicio da prova e retorna o valor
function diff_data($data_recebida)
{
	#dá me a data atual em timestamp php (segundos)
	$data_atual = time();
	$diff = $data_recebida - $data_atual;
	#os 86400 corresponde ao numero de segundos num dia pq o timestamp dá me em segundos
	$numdias = floor($diff/86400);
	return $numdias;
}
?>