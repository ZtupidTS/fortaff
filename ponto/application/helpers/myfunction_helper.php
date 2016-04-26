<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Para converter o time da DB em segundos e repor em horas normais
function toSeconds($time) 
{
	$parts = explode(':', $time);
	return 3600*$parts[0] + 60*$parts[1] + $parts[2];
}

function toTime($seconds) {
	$hours = floor($seconds/3600);
	$seconds -= $hours * 3600;
	$minutes = floor($seconds/60);
	$seconds -= $minutes * 60;
	if($hours == 0 && $seconds == 0 && $minutes == 0)
	{
		return '00:00:00';	
	}else{
		
		return twoDigit($hours) . ':' . twoDigit($minutes) . ':' . twoDigit($seconds);	
	}
}

//se as horas só tem um digito
function twoDigit($time)
{
	if(strlen($time) < 2)
	{
		return '0'.$time;
	}else{
		return $time;
	}
}

//calculo das horas
function calculohoras($ar_picagens)
{
	$tmptrabalhado = 0;
	$tmppausas = 0;
	$i = true;
	$picagem_number = 0;
	$ar_picnum = array(3,5,7,9,11,13,15,17,19,21,23,25);
	$tempoinf = 0;
	$temposup = 0;
	$newdia = false;
	foreach($ar_picagens as $row)
	{
		if($newdia)
		{
			$tempoinf = 0;
			$temposup = 0;
			$i = true;
			$picagem_number = 0;
			$newdia = false;
		}
		if($i)
		{
			$tempoinf = toSeconds($row->horas);
			$picagem_number++;
			$i = false;
			
		}else{
			$temposup = toSeconds($row->horas);
			$picagem_number++;
			$i = true;
			//aqui vou fazer como se fosse para mudar de dia
			if($temposup < $tempoinf && $temposup < LAST_TIME_SEC)
			{
				//aqui acrescento 24h
				$temposup = $temposup + 86400;
				$newdia = true;
			}
		}
		if($temposup != 0)
		{
			if(in_array($picagem_number,$ar_picnum))
			{
				//se é uma picagem a verificar	
				if(($tempoinf - $temposup) < PAUSA)
				{
					$tmptrabalhado += $tempoinf - $temposup;
				}else{
					$tmppausas += $tempoinf - $temposup;
				}
			}else{
				//aqui é só somar
				if(($temposup - $tempoinf) > PAUSA)
				{
					$tmptrabalhado += $temposup - $tempoinf;
				}else{
					$tmppausas += ($temposup - $tempoinf);
				}
			}
		}
	}
	return array('horas' => $tmptrabalhado, 'pausas' => $tmppausas);
}


?>