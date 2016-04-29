<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Picagem_model extends CI_Model {
	
	private $salt = 'r4nd0m';	
	//level 1: utilizador Normal da loja
	//level 2: utilizador admin
	
	//TBL_PICAGENS
	
	/*
	* Devolve um array vazio se não tem resultado
	* Vais buscar todas as picagens
	*/
	public function getpicagens($sql_query)
	{
		$result = $this->db->query($sql_query);
		if($result->num_rows() >0)
		{
			return $result->result_array();
		}else{
			return array();
		}
	}
	
	/*
	* Devolve as picagens do dia o intervalo de dias de um user
	*/
	public function picagensbyuser($iduser,$datafirst, $datasecond = false)
	{
		$date1 = explode('-',$datafirst);
		
		if($datasecond)
		{
			//se existe uma segunda data
			$date2 = explode('-',$datasecond);
			/*$this->db->where('Userid', $iduser);
			$this->db->where('datepart(day,CheckTime)', $date1[2]);
			$this->db->where('datepart(month,CheckTime)', $date1[1]);
			$this->db->where('datepart(year,CheckTime)', $date1[0]);*/
			$sql = "select * from V_Record where Userid= ".$iduser." AND CheckTime between '".$datafirst."' and DATEADD(DAY,1,'".$datasecond."')";
			return getpicagens($sql);
		}else{
			$this->db->where('Userid', $iduser);
			$this->db->where('datepart(day,CheckTime)', $date1[2]);
			$this->db->where('datepart(month,CheckTime)', $date1[1]);
			$this->db->where('datepart(year,CheckTime)', $date1[0]);
		}
		
		$get = $this->db->get(TBL_VPICAGENS);
	    	//aqui vou ver se o user ja entrou uma vez
	    	if($get->num_rows() > 0)
	    	{
	    		return $get->result_array();	
	    	} 
	    	return array();
	}
	
	/*
	* Atualizar hora de picagem 
	*/
	public function updatepicagem($logid,$data)
	{
		$this->db->where('Logid', $logid);
	        $update = $this->db->update(TBL_PICAGENS, $data);
	        return $update;
	}
	
	/*
	* Eliminar uma picagem
	*/
	public function deletepicagem($logid)
	{
		$this->db->where('Logid', $logid);
		$delete = $this->db->delete(TBL_PICAGENS);
		return $delete;
	}
	
	/*
	* Insere uma picagem
	*/
	public function addpicagem($data)
	{
		return $this->db->insert(TBL_PICAGENS,$data);
	}
	
	/*
	* Otenho os departamentos todos criados
	*/
	public function getDpt($id = false)
	{
		if(!$id)
		{
			$this->db->order_by("SupDeptid","ASC");
			$get = $this->db->get(TBL_DPT);
			if($get->num_rows() > 0)
		    	{
		    		return $get->result_array();	
		    	} 
		    	return array();	
		}else{
			
		}
	}
	
	/*
	*
	*/
	public function getresumopicagem($dpt,$datefirst,$datesecond)
	{
		if($dpt == VAL_LOJA)//loja quer dizer all
		{
			//como é tudo tenho que devolver tudo
			//vou devolver tudo menos chefia e repositores externos
			//como não é igual a 4 é ok é só ir somar tudo relativo a essa secção
			$array_Userid = array();
			$sql = "select DISTINCT Userid, Name, Duty from ".TBL_VPICAGENS." where Deptid != 23 AND Deptid != 22 AND CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."')";
			$result = $this->db->query($sql);
			if($result->num_rows() >0)
			{
				foreach($result->result() as $row)
				{
					array_push($array_Userid,array(
						'Userid' => $row->Userid,
						'Name' => $row->Name,
						'Hnoturnas' => $row->Duty,
						));
				}
				return $this->picagem_model->calculoresumo($array_Userid,$datefirst,$datesecond);						
			}else{
				return array();
			}
		}else{
			//aqui tenho que ver se o numero é de um dpt ou de uma secção
			$this->db->where('Deptid',$dpt);
			$get = $this->db->get(TBL_DPT);
			$supdeptid = 0;
			$array_Userid = array();
			if($get->num_rows() > 0)
		    	{
		    		foreach ($get->result() as $row)
				{
					$supdeptid = $row->SupDeptid;
				}
				if($supdeptid == VAL_LOJA)
				{
					//ok igual a 4 logo tenho que ir buscar os numeros das secção para ser a 
					//soma ao departamento	
					// tenho que ir buscar os user que tem o departamento seleccionado
					$sql = "select DISTINCT vr.Userid, vr.Name, vr.Duty from ".TBL_VPICAGENS." as vr, ".TBL_DPT." as dp where vr.Deptid = dp.Deptid AND dp.SupDeptid = ".$dpt." AND CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."')";
					$result = $this->db->query($sql);
					if($result->num_rows() >0)
					{
						foreach($result->result() as $row)
						{
							array_push($array_Userid,array(
								'Userid' => $row->Userid,
								'Name' => $row->Name,
								'Hnoturnas' => $row->Duty,
							));
						}
						return $this->picagem_model->calculoresumo($array_Userid,$datefirst,$datesecond);						
					}else{
						//como não é igual a 4 é ok é só ir somar tudo relativo a essa secção
						$sql = "select DISTINCT Userid, Name, Duty from ".TBL_VPICAGENS." where Deptid = ".$dpt." AND CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."')";
						$result = $this->db->query($sql);
						if($result->num_rows() >0)
						{
							foreach($result->result() as $row)
							{
								array_push($array_Userid,array(
									'Userid' => $row->Userid,
									'Name' => $row->Name,
									'Hnoturnas' => $row->Duty,
								));
							}
							return $this->picagem_model->calculoresumo($array_Userid,$datefirst,$datesecond);						
						}else{
							return array();
						}
					}
				}else{
					//como não é igual a 4 é ok é só ir somar tudo relativo a essa secção
					$sql = "select DISTINCT Userid, Name, Duty from ".TBL_VPICAGENS." where Deptid = ".$dpt." AND CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."')";
					$result = $this->db->query($sql);
					if($result->num_rows() >0)
					{
						foreach($result->result() as $row)
						{
							array_push($array_Userid,array(
								'Userid' => $row->Userid,
								'Name' => $row->Name,
								'Hnoturnas' => $row->Duty,
							));
						}
						return $this->picagem_model->calculoresumo($array_Userid,$datefirst,$datesecond);						
					}else{
						return array();
					}					
				}
		    	}else{
				return array();
			} 
			
		}
	}
	
	/*
	* Desde que tenho o meu array id vou criar outros para mandar para a pagina
	*/
	public function calculoresumo($array_user,$datefirst,$datesecond)
	{
		$this->load->helper('myfunction_helper');
		
		$array_final = array();
		//variaveis totais
		$total_temp_trab = 0;
		$total_hdomingo = 0;
		$total_hferiado = 0;
		$total_hnoturnas = 0;
		foreach($array_user as $data)
		{
			//dias trabalhados
			$sql = "select count(DISTINCT(day(CheckTime))) from V_Record where Userid = ".$data['Userid']." AND CheckTime between '".$datefirst."' and DATEADD(DAY,1,'".$datesecond."') group by year(CheckTime),month(CheckTime),day(CheckTime)";
			$result_diastrabalhados = $this->db->query($sql);
			//dia trabalhados
			$dias_trabalhados = $result_diastrabalhados->num_rows();
			//nome funcionario
			$nome_us = $data['Name'];
			
			//horas trabalhadas
			$sql = "select FORMAT(CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/MM/yyyy') as dia from V_Record where Userid = ".$data['Userid']." AND CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."') order by CheckTime";
			$tempotrabalhado = 0;
			$tempopausas = 0;
			$result_tempotrabalhado = $this->db->query($sql);
			if(($result_tempotrabalhado->num_rows()) % 2 == 0)
			{
				//é par logo continuo
				/*$i = true;
				$picagem_number = 0;
				$ar_picnum = array(3,5,7,9,11,13,15,17,19,21,23,25);
				$tempoinf = 0;
				$temposup = 0;
				$newdia = false;
				foreach($result_tempotrabalhado->result() as $row)
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
								$tempotrabalhado += $tempoinf - $temposup;
							}else{
								$tempopausas += $tempoinf - $temposup;
							}
						}else{
							//aqui é só somar
							if(($temposup - $tempoinf) > PAUSA)
							{
								$tempotrabalhado += $temposup - $tempoinf;
							}else{
								$tempopausas += ($temposup - $tempoinf);
							}
						}
					}
				}*/
				$ret_array = calculohoras($result_tempotrabalhado->result());
				//print_r($ret_array);
				/*$tempotrabalhado = toTime($tempotrabalhado);				
				$tempopausas = toTime($tempopausas);*/	
				$tempotrabalhado = toTime($ret_array['horas']);			
				$tempopausas = toTime($ret_array['pausas']);			
			}else{
				// é impar
				$tempotrabalhado = 'Faltam picagens';
				$tempopausas = 'Faltam picagens';
			}
			
			//horas de domingo
			$sql = "SELECT FORMAT(CheckTime, 'HH:mm:ss') as horas FROM V_Record WHERE Userid = ".$data['Userid']." AND CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."') AND DATEPART(dw, CheckTime) IN (1) order by CheckTime";
			
			$tempo_domingo = 0;
			$tempopausas_dom = 0;
			$result_domingo = $this->db->query($sql);
			if(($result_domingo->num_rows()) % 2 == 0)
			{
				$ret_array = calculohoras($result_domingo->result());
				
				/*//é par logo continuo
				$i = true;
				$tempoinf = 0;
				$temposup = 0;
				foreach($result_domingo->result() as $row)
				{
					if($i)
					{
						$tempoinf += toSeconds($row->horas);	
						$i = false;
					}else{
						$temposup += toSeconds($row->horas);	
						$i = true;
					}
				}
				$tempo_domingo = toTime($temposup - $tempoinf);	*/
				$tempo_domingo = toTime($ret_array['horas']);			
				$tempopausas_dom = toTime($ret_array['pausas']);			
			}else{
				// é impar
				$tempo_domingo = 'Faltam picagens';
				$tempopausas_dom = 'Faltam picagens';
			}
			
			//Horas de feriado
			$sql = "SELECT FORMAT(vr.CheckTime, 'HH:mm:ss') as horas FROM V_Record as vr WHERE vr.Userid = ".$data['Userid']." AND vr.CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."') AND EXISTS(SELECT hol.BDate FROM Holiday hol WHERE CONVERT(VARCHAR(10),vr.CheckTime,110) = CONVERT(VARCHAR(10),hol.BDate,110) AND hol.Name NOT LIKE '%INVENTARIO%') order by CheckTime";
			
			$tempo_feriado = 0;
			$tempopausas_feriado = 0;
			$result_feriado = $this->db->query($sql);
			if(($result_feriado->num_rows()) % 2 == 0)
			{
				//é par logo continuo
				/*$i = true;
				$tempoinf = 0;
				$temposup = 0;
				foreach($result_feriado->result() as $row)
				{
					if($i)
					{
						$tempoinf += toSeconds($row->horas);	
						$i = false;
					}else{
						$temposup += toSeconds($row->horas);	
						$i = true;
					}
				}
				$tempo_feriado = toTime($temposup - $tempoinf);	*/
				$ret_array = calculohoras($result_feriado->result());
				$tempo_feriado = toTime($ret_array['horas']);			
				$tempopausas_feriado = toTime($ret_array['pausas']);		
			}else{
				// é impar
				$tempo_feriado = 'Faltam picagens';
				$tempopausas_feriado = 'Faltam picagens';
			}
			
			//horas inventario
			/*$sql = "SELECT FORMAT(vr.CheckTime, 'HH:mm:ss') as horas FROM V_Record as vr WHERE vr.Userid = ".$data['Userid']." AND vr.CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."') AND EXISTS(SELECT hol.BDate FROM Holiday hol WHERE CONVERT(VARCHAR(10),vr.CheckTime,110) = CONVERT(VARCHAR(10),hol.BDate,110) AND hol.Name LIKE '%INVENTARIO%') order by CheckTime";
			
			$tempo_inv = 0;
			$result_inv = $this->db->query($sql);
			if(($result_inv->num_rows()) % 2 == 0)
			{
				//é par logo continuo
				/*$i = true;
				$tempoinf = 0;
				$temposup = 0;
				foreach($result_feriado->result() as $row)
				{
					if($i)
					{
						$tempoinf += toSeconds($row->horas);	
						$i = false;
					}else{
						$temposup += toSeconds($row->horas);	
						$i = true;
					}
				}
				$ret_array = calculohoras($result_feriado->result());
				$tempo_inv = toTime($ret_array['horas']);							
			}else{
				// é impar
				$tempo_inv = 'Faltam picagens';				
			}*/
			
			//horas noturnas
			$sql = "select FORMAT(CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/MM/yyyy') as dia from V_Record where Userid = ".$data['Userid']." AND CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."') order by CheckTime";
			
			$tempo_noturno = 0;
			$result_noturno = $this->db->query($sql);
			if(($result_noturno->num_rows()) % 2 == 0)
			{
				//é par logo continuo
				$h_not_noite = intval($data['Hnoturnas']) * 3600;
				$temp_old = 0;
				foreach($result_noturno->result() as $row)
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
				}
				$tempo_noturno = toTime($tempo_noturno);							
			}else{
				// é impar
				$tempo_noturno = 'Faltam picagens';				
			}
			
			//array final das somas
			array_push($array_final,array(
				'Userid' => $data['Userid'],
				'Name' => $data['Name'],
				'Dias' => $dias_trabalhados,
				'HTrabalhadas' => $tempotrabalhado,
				'HPTrab' => $tempopausas,
				'Hdomingo' => $tempo_domingo,
				'HPdomingo' => $tempopausas_dom,
				'Hferiado' => $tempo_feriado,
				'HPferiado' => $tempopausas_feriado,
				'HNoturnas' => $tempo_noturno
				));
			
			//aqui é para a linha total
			if($tempotrabalhado != 'Faltam picagens') $total_temp_trab += toSeconds($tempotrabalhado);
			if($tempo_domingo != 'Faltam picagens') $total_hdomingo += toSeconds($tempo_domingo);
			if($tempo_feriado != 'Faltam picagens') $total_hferiado += toSeconds($tempo_feriado);
			if($tempo_noturno != 'Faltam picagens') $total_hnoturnas += toSeconds($tempo_noturno);
		}
		
		array_push($array_final,array(
			'Userid' => '',
			'Name' => 'Total',
			'Dias' => '',
			'HTrabalhadas' => toTime($total_temp_trab),
			'HPTrab' => '',
			'Hdomingo' => toTime($total_hdomingo),
			'HPdomingo' => '',
			'Hferiado' => toTime($total_hferiado),
			'HPferiado' => '',
			'HNoturnas' => toTime($total_hnoturnas)
			));
		
		return $array_final;
		
	}
}
?>