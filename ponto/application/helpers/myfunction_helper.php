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
function calculohoras($ar_picagens, $ar_dia_inv = false)
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
			/*echo ' '.$row->horas.' ';*/
			$tempoinf = toSeconds($row->horas);
			$picagem_number++;
			$i = false;
			if($tempoinf > $temposup && $temposup != 0 && $dia > $old_dia)
			{
				$temposup = 0;
				$picagem_number = 1;
				$cont_cal = false;
			}
			/*echo ' dia '.$dia.' ';
			echo ' old '.$old_dia.' ';
			if(strtotime($dia) > strtotime($old_dia)) echo ' supppppppppppp ';*/
			if($cont_cal && $tempoinf < $temposup && strtotime($dia) > strtotime($old_dia) && $old_dia != '')
			{
				//echo ' '.$picagem_number.' ';
				/*echo ' '.$row->horas.' ';
				echo $tempoinf.' ';*/
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
				/*if(($temposup - $tempoinf) > PAUSA)
				{
					$tmptrabalhado += $temposup - $tempoinf;
				}else{
					
					//$tmppausas += ($temposup - $tempoinf);
					$tmptrabalhado += $temposup - $tempoinf;
					$pausa++;
				}*/
				
				if(($temposup - $tempoinf) > PAUSA)
				{
					//se dia de inventario
					//echo $temposup.' antes ';
					//print_r($ar_dia_inv);
					if($temposup > HOR_INV && $ar_dia_inv)
					{
						//echo $temposup;
						//echo 'entrou';
						$cont_inv = false;
						$hora_inv = 0;
						foreach ($ar_dia_inv as $row_inv)
						{
							/*echo $row_inv->dia.' ';
							echo ' '.$dia.' F ';*/
							if($row_inv->dia == $dia || ($temposup > 86400 && date('d-m-Y', strtotime($row_inv->dia . ' +1 day')) == $dia))								{
								$cont_inv = true;
								$hora_inv = toSeconds($row_inv->hora);	
								/*echo $hora_inv.' I ';
								echo $temposup.' TS ';*/							
							}
							if($cont_inv) break;
						}
						/*echo ' TS '.$temposup.' ';
						echo ' hv '.$hora_inv.' ';
						echo ' TI '.$tempoinf.' ';*/
						if($cont_inv)
						{
							if($hora_inv > $tempoinf && ($hora_inv - $tempoinf) < PAUSA)
							{
								$tmptrabalhado += $temposup - $hora_inv;
							}else{
								$tmptrabalhado += $temposup - $tempoinf;
							}							
						}else{
							$tmptrabalhado += $temposup - $tempoinf;
						}
						/*echo ' TT '.$tmptrabalhado;*/
					}else{
						$tmptrabalhado += $temposup - $tempoinf;
					}
					
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

//para a tabela de vizualização de picagens
function viewPicagens($firstdate,$seconddate,$result)
{
	$message = '';
	$olddate = '';
	$firstdate = date_create($firstdate . '00:00:00.000');
	$seconddate = date_create($seconddate . '00:00:00.000');
	
	foreach($result as $row)
	{
		$newdate = date_create($row['CheckTime']);
		$hora = toSeconds(date_format($newdate,'H:i:s'));
		
		while(date_format($firstdate,'y-m-d') < date_format($newdate,'y-m-d'))
		{
			$message .= '<tr onclick="corrigirPicagens('.date_format($firstdate,'Ymd').')"><td>'.date_format($firstdate,'d-m-y').'</td><td></td></tr>';
			$firstdate->add(new DateInterval('P1D'));
		}
		
		if($olddate == '' && date_format($firstdate,'y-m-d') == date_format($newdate,'y-m-d'))
		{
			$message .= '<tr onclick="corrigirPicagens('.date_format($newdate,'Ymd').')"><td>'.date_format($newdate,'d-m-y').'</td>';
			$firstdate->add(new DateInterval('P1D'));
		}
		
		if($olddate != '' && date_format($newdate,'y-m-d') > date_format($olddate,'y-m-d') && date_format($firstdate,'y-m-d') == date_format($newdate,'y-m-d'))
		{
			if($hora < LAST_TIME_SEC)
			{
				$message .= '<td>'.date_format($newdate,'H:i:s').'</td>';	
				$message .= '</tr><tr onclick="corrigirPicagens('.date_format($newdate,'Ymd').')"><td>'.date_format($newdate,'d-m-y').'</td>';
			}else{
				$message .= '</tr><tr onclick="corrigirPicagens('.date_format($newdate,'Ymd').')"><td>'.date_format($newdate,'d-m-y').'</td>';
				$message .= '<td>'.date_format($newdate,'H:i:s').'</td>';
			}
			$firstdate->add(new DateInterval('P1D'));
		}else{
			/*if($olddate != '')
			{*/
				$message .= '<td>'.date_format($newdate,'H:i:s').'</td>';	
			/*}else{
				$message .= date_format($newdate,'H:i:s'); 
			}*/
		}
		$olddate = $newdate;
	}
	while(date_format($firstdate,'y-m-d') <= date_format($seconddate,'y-m-d'))
	{
		$message .= '<tr onclick="corrigirPicagens('.date_format($firstdate,'Ymd').')"><td>'.date_format($firstdate,'d-m-y').'</td><td></td></tr>';
		$firstdate->add(new DateInterval('P1D'));
	}
	return $message;
}

?>