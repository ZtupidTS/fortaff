<?php
#vai calcular os dias que falta atщ o inicio da prova e retorna o valor
function diff_data($data_recebida)
{
	#dс me a data atual em timestamp php (segundos)
	$data_atual = time();
	$diff = $data_recebida - $data_atual;
	#os 86400 corresponde ao numero de segundos num dia pq o timestamp dс me em segundos
	$numdias = floor($diff/86400);
	return $numdias;
}
function diff_data_ano($data_recebida)
{
	#dс me a data atual em timestamp php (segundos)
	$data_atual = time();
	$diff = $data_atual- $data_recebida;
	#os 86400 corresponde ao numero de segundos num dia pq o timestamp dс me em segundos
	$numdias = floor($diff/86400);
	$ano = floor($numdias/365);
	return $ano;
}
function adicionar_duas_horas($hora1,$hora2)
{
	list($h,$m,$s) = explode(':',$hora1);
	list($h2,$m2,$s2) = explode(':',$hora2);
	$array_time = array($h+$h2,$m+$m2,$s+$s2);
	$hora_em_timestamp = mktime($array_time[0],$array_time[1],$array_time[2]);
	#crio um array onde a posiчуo 0: horas H:M:S e a posiчуo 1: hora em timestamp
	$horas = array();
	$horas[] = date('H:i:s',$hora_em_timestamp);
	$horas[] = $hora_em_timestamp;
	return $horas;
}
function convert_to_timestamp($hora)
{
	list($h,$m,$s) = explode(':',$hora);
	$hora_em_timestamp = mktime($h,$m,$s);
	return $hora_em_timestamp;
}
function diferenca_duas_horas($hora1,$hora2)
{
	list($h,$m,$s) = explode(':',$hora1);
	$hora2 = date('H:i:s',$hora2);
	list($h2,$m2,$s2) = explode(':',$hora2);
	$array_time = array($h-$h2,$m-$m2,$s-$s2);
	$hora_em_timestamp = mktime($array_time[0],$array_time[1],$array_time[2]);
	#return date('H:i:s',$test);
	return $hora_em_timestamp;
}
?>