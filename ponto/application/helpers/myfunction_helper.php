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
	$old_dia = '';
	$pausa = 0;
	foreach($ar_picagens as $row)
	{
		//$dia = new DateTime($row->dia);
		$dia = date($row->dia);
		$cont_cal = true;
		
		if($newdia)
		{
			$tempoinf = 0;
			$temposup = 0;
			$i = true;
			$picagem_number = 0;
			$pausa = 0;
			$newdia = false;
		}
		if($i)
		{
			$tempoinf = toSeconds($row->horas);
			$picagem_number++;
			$i = false;
			if($tempoinf > $temposup && $temposup != 0 && $dia > $old_dia)
			{
				$temposup = 0;
				$picagem_number = 1;
				$cont_cal = false;
			}
			if($cont_cal && $tempoinf < $temposup && $dia > $old_dia)
			{
				$temposup = 0;
				$picagem_number = 1;
				$cont_cal = false;
			}
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
					if($pausa == 2)
					{
						//$tmppausas += $tempoinf - $temposup;
						$pausa = 0;
					}else{
						$tmptrabalhado += $tempoinf - $temposup;	
						$pausa++;
					}
					
				}else{
					$tmppausas += $tempoinf - $temposup;
				}
			}else{
				//aqui é só somar
				if(($temposup - $tempoinf) > PAUSA)
				{
					$tmptrabalhado += $temposup - $tempoinf;
				}else{
					
					//$tmppausas += ($temposup - $tempoinf);
					$tmptrabalhado += $temposup - $tempoinf;
					$pausa++;
				}
			}
		}
		$old_dia = $dia;
	}
	return array('horas' => $tmptrabalhado, 'pausas' => $tmppausas);
}
//calculo horas noturnas
function calculNoturnas($noturno,$h_not_noite)
{
	$tempo_noturno = 0;
	$temp_old = 0;
	foreach($noturno->result() as $row)
	{
		$continu = true;
		$temp = toSeconds($row->horas);
		if($temp < MANHA_NOT && $temp > LAST_TIME_SEC)
		{
			$tempo_noturno += MANHA_NOT - $temp;
			$temp_old = 0;
			$continu = false;
		}
		if($h_not_noite < $temp  && $temp < (LAST_TIME_SEC + 86400) && $continu)
		{
			if($temp_old != 0)
			{
				$tempo_noturno += $temp - $temp_old;
				$temp_old = $temp;
				$continu = false;	
			}else{
				$tempo_noturno += $temp - $h_not_noite;	
				$temp_old = $temp;
				$continu = false;
			}						
		}
		if($temp < LAST_TIME_SEC && $temp_old != 0 && $continu)
		{
			$tempo_noturno += ($temp + 86400) - $temp_old;	
			$temp_old = $temp + 86400;
			$continu = false;
		}
		if($continu)
		{
			$temp_old = 0;
		}					
	}
	return toTime($tempo_noturno);
}

?>