<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Para converter o time da DB em segundos e repor em horas normais
function toSeconds($time) 
{
	if($time == "00:00:00")
	{
		return 0;
	}else{
		$parts = explode(':', $time);
		return 3600*$parts[0] + 60*$parts[1] + $parts[2];	
	}
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
		
		if(strtotime($dia) > strtotime($old_dia) && $old_dia != '' && toSeconds($row->horas) > LAST_TIME_SEC) $newdia = true;
		
		//echo ' av '.var_export($newdia);
		
		if($newdia)
		{
			$tempoinf = 0;
			$temposup = 0;
			$i = true;
			$picagem_number = 0;
			$pausa = 0;
			$newdia = false;
		}
		//echo ' dp '.var_export($newdia);
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

function calculoInventario($arr_inv)
{
	$i = true;
	$hora_inv = 0;
	$tempoinf = 0;
	$temposup = 0;
	$dia = 0;
	$old_dia = 0;
	$tempo_inv = 0;					
	foreach($arr_inv as $row)
	{
		/*$dia = date($row->dia);
		if($temposup > 0 && $dia > $old_dia && ($temposup < LAST_TIME_SEC || $temposup > $tempoinf))
		{
			$tempoinf = 0;
			$temposup = 0;
			$i = true;						
		}*/
		
		$cont_inv = true;
		$split_name = explode("_",$row->Name);
		$hora_inv = toSeconds($split_name[1]);
		
		if($i)
		{
			$tempoinf = toSeconds($row->horas);	
			$i = false;
		}else{
			$temposup = toSeconds($row->horas);
			//$i = true;
		}
		
		if($temposup != 0)
		{
			if($temposup > HOR_INV || $temposup < LAST_TIME_SEC)
			{
				$cont_inv = false;
				if($tempoinf >= $hora_inv)
				{
					if($temposup < LAST_TIME_SEC)	
					{
						$tempo_inv += ($temposup + 86400) - $tempoinf;
						$tempoinf = $temposup;
					}else{
						$tempo_inv += $temposup - $tempoinf;
						$tempoinf = $temposup;
					}
				}else{
					if($temposup < LAST_TIME_SEC)	
					{
						$tempo_inv += ($temposup + 86400) - $hora_inv;
						$tempoinf = $temposup;
					}else{
						$tempo_inv += $temposup - $hora_inv;
						$tempoinf = $temposup;
					}
				}							
			}
			$tempoinf = $temposup;
		}
		/*$old_dia = $dia;*/
	}
	/*return toTime($tempo_inv);*/
	return $tempo_inv;
}

//calculo horas noturnas
function calculNoturnas($noturno,$h_not_noite)
{
	/*$tempo_noturno = 0;
	$temp_old = 0;
	foreach($noturno->result() as $row)
	{
		$continu = true;
		$temp = toSeconds($row->horas);
		
		$dia = date($row->dia);
		
		
		
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
				//se o dia é o mesmo é que faço isso
				if(strtotime($dia) > strtotime($old_dia))
				{
					$tempo_noturno += $temp - $temp_old;
				}else{
					$tempo_noturno += $temp - $temp_old - ($temp_old - $h_not_noite);
				}
				
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
		$old_dia = $dia;					
	}*/
	
	$tempo_noturno = 0;
	$i = true;
	$picagem_number = 0;
	$ar_picnum = array(3,5,7,9,11,13,15,17,19,21,23,25);
	$tempoinf = 0;
	$temposup = 0;
	$newdia = false;
	$old_dia = '';
	
	foreach($noturno->result() as $row)
	{
		//$dia = new DateTime($row->dia);
		$dia = date($row->dia);
		$cont_cal = true;
		
		if(strtotime($dia) > strtotime($old_dia) && $old_dia != '' && toSeconds($row->horas) > LAST_TIME_SEC) $newdia = true;
		
		//echo ' av '.var_export($newdia);
		
		if($newdia)
		{
			//echo ' ENTREI ';
			$tempoinf = 0;
			$temposup = 0;
			$i = true;
			$picagem_number = 0;
			$newdia = false;
		}
		//echo ' dp '.var_export($newdia);
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
			if($temposup > $h_not_noite || $tempoinf > $h_not_noite)
			{
				if(in_array($picagem_number,$ar_picnum))
				{
					//se é uma picagem a verificar	
					if(($tempoinf - $temposup) < PAUSA)
					{
						//$tempo_noturno += $tempoinf - $temposup;
						/*if($tempoinf > $h_not_noite)
						{*/
							if($temposup > $h_not_noite)
							{
								$tempo_noturno += $tempoinf - $temposup;
							}else{
								$tempo_noturno += $tempoinf - $h_not_noite;
							}
						/*}else{
							$tempo_noturno += $temposup - $h_not_noite;	
						}*/					
					}
				}else{
					if($tempoinf > $h_not_noite)
					{
						$tempo_noturno += $temposup - $tempoinf;
					}else{
						$tempo_noturno += $temposup - $h_not_noite;	
					}
				}
			}
		}else{
			//aqui é para contar as horas da manha caso seja o caso
			if($tempoinf < MANHA_NOT && $tempoinf > LAST_TIME_SEC)
			{
				$tempo_noturno += MANHA_NOT - $tempoinf;				
			}	
		}
		$old_dia = $dia;
	}
	
	return toTime($tempo_noturno);
}

function useridTofourdigit($userid)
{
	switch (strlen($userid)) {
	    case 1:
	        return '000'.$userid;
	        break;
	    case 2:
	        return '00'.$userid;
	        break;
	    case 3:
	        return '0'.$userid;
	        break;
	    case 4:
	        return $userid;
	        break;	
	}
}

function dayTotwodigit($numday)
{
	switch (strlen($numday)) {
	    case 1:
	        return '0'.$numday;
	        break;
	    case 2:
	        return $numday;
	        break;	
	}
}

function qtdexportsage($qtd)
{
	if (strpos($qtd, '.') !== false) 
	{
		$new_qtd = round($qtd,2);
		$split_qtd = explode(".",$new_qtd);
		switch (strlen($split_qtd[0])) {
		    case 1:
		        $qtd_int = '0000'.$split_qtd[0];
		        break;
		    case 2:
		        $qtd_int = '000'.$split_qtd[0];
		        break;
		    case 3:
		        $qtd_int = '00'.$split_qtd[0];
		        break;
		    case 4:
		        $qtd_int = '0'.$split_qtd[0];
		        break;
		    case 5:
		        $qtd_int = $split_qtd[0];
		        break;	
		}
		if(count($split_qtd) > 1)
		{
			if(strlen($split_qtd[1]) > 1)
			{
				return $qtd_int.".".$split_qtd[1];	
			}else{
				return $qtd_int.".".$split_qtd[1]."0";
			}
			
		}else{
			return $qtd_int.".00";
		}
	}else{
		$new_qtd = '';
		switch (strlen($qtd)) {
		    case 1:
		        $new_qtd = '0000'.$qtd;
		        break;
		    case 2:
		        $new_qtd = '000'.$qtd;
		        break;
		    case 3:
		        $new_qtd = '00'.$qtd;
		        break;
		    case 4:
		        $new_qtd = '0'.$qtd;
		        break;
		    case 5:
		        $new_qtd = $qtd;
		        break;	
		}
		return $new_qtd.".00";
	}
}

?>