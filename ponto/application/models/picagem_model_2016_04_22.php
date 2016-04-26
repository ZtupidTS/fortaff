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
			$sql = "select DISTINCT Userid, Name from ".TBL_VPICAGENS." where Deptid != 23 AND Deptid != 22 AND CheckTime between '".$datefirst."' and DATEADD(DAY,1,'".$datesecond."')";
			$result = $this->db->query($sql);
			if($result->num_rows() >0)
			{
				foreach($result->result() as $row)
				{
					array_push($array_Userid,array(
						'Userid' => $row->Userid,
						'Name' => $row->Name
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
					$sql = "select DISTINCT vr.Userid, vr.Name from ".TBL_VPICAGENS." as vr, ".TBL_DPT." as dp where vr.Deptid = dp.Deptid AND dp.SupDeptid = ".$dpt." AND CheckTime between '".$datefirst."' and DATEADD(DAY,1,'".$datesecond."')";
					$result = $this->db->query($sql);
					if($result->num_rows() >0)
					{
						foreach($result->result() as $row)
						{
							array_push($array_Userid,array(
								'Userid' => $row->Userid,
								'Name' => $row->Name
								));
						}
						return $this->picagem_model->calculoresumo($array_Userid,$datefirst,$datesecond);						
					}else{
						//como não é igual a 4 é ok é só ir somar tudo relativo a essa secção
						$sql = "select DISTINCT Userid, Name from ".TBL_VPICAGENS." where Deptid = ".$dpt." AND CheckTime between '".$datefirst."' and DATEADD(DAY,1,'".$datesecond."')";
						$result = $this->db->query($sql);
						if($result->num_rows() >0)
						{
							foreach($result->result() as $row)
							{
								array_push($array_Userid,array(
									'Userid' => $row->Userid,
									'Name' => $row->Name
									));
							}
							return $this->picagem_model->calculoresumo($array_Userid,$datefirst,$datesecond);						
						}else{
							return array();
						}
					}
				}else{
					//como não é igual a 4 é ok é só ir somar tudo relativo a essa secção
					$sql = "select DISTINCT Userid, Name from ".TBL_VPICAGENS." where Deptid = ".$dpt." AND CheckTime between '".$datefirst."' and DATEADD(DAY,1,'".$datesecond."')";
					$result = $this->db->query($sql);
					if($result->num_rows() >0)
					{
						foreach($result->result() as $row)
						{
							array_push($array_Userid,array(
								'Userid' => $row->Userid,
								'Name' => $row->Name
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
		foreach($array_user as $data)
		{
			$sql = "select count(DISTINCT(day(CheckTime))) from V_Record where Userid = ".$data['Userid']." AND CheckTime between '".$datefirst."' and DATEADD(DAY,1,'".$datesecond."') group by year(CheckTime),month(CheckTime),day(CheckTime)";
			$result_diastrabalhados = $this->db->query($sql);
			//dia trabalhados
			$dias_trabalhados = $result_diastrabalhados->num_rows();
			//nome funcionario
			$nome_us = $data['Name'];
			
			//horas trabalhadas
			$sql = "select FORMAT(CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/mm/yyyy') as dia from V_Record where Userid = ".$data['Userid']." AND CheckTime between '".$datefirst."' and DATEADD(DAY,1,'".$datesecond."') order by CheckTime";
			$tempotrabalhado = '';
			$tempopausas = '';
			$result_tempotrabalhado = $this->db->query($sql);
			if(($result_tempotrabalhado->num_rows()) % 2 == 0)
			{
				//é par logo continuo
				$i = true;
				$picagem_number = 0;
				$ar_picnum = array(3,5,7,9,11,13,15,17,19);
				$tempoinf = 0;
				$temposup = 0;
				//$tempinf_temp = 0;
				//$tempsup_temp = 0;
				//$somar = false;
				foreach($result_tempotrabalhado->result() as $row)
				{
					if($i)
					{
						$tempoinf = toSeconds($row->horas);
						$picagem_number++;
						//$tempoinf += toSeconds($row->horas);	
						$i = false;
					}else{
						$temposup = toSeconds($row->horas);
						$picagem_number++;
						//$temposup += toSeconds($row->horas);	
						$i = true;
					}
					if($temposup != 0)
					{
						if(in_array($picagem_number,$ar_picnum))
						{
								
						}else{
							
						}
						
						if(!$i)
						{
							if(($temposup - $tempoinf) < PAUSA)
							{
								
							}
						}else{
							if(($tempoinf - $temposup) < PAUSA)
							{
								
							}
						}
					}
					
					
					
				}
				$tempotrabalhado = toTime($temposup - $tempoinf);				
			}else{
				// é impar
				$tempotrabalhado = 'Faltam picagens';
				$tempopausas = 'Faltam picagens';
			}
			
			//horas de domingo
			$sql = "SELECT FORMAT(CheckTime, 'HH:mm:ss') as horas FROM V_Record WHERE Userid = ".$data['Userid']." AND CheckTime between '".$datefirst."' and DATEADD(DAY,1,'".$datesecond."') AND DATEPART(dw, CheckTime) IN (1) order by CheckTime";
			
			$tempo_domingo = '';
			$result_domingo = $this->db->query($sql);
			if(($result_domingo->num_rows()) % 2 == 0)
			{
				//é par logo continuo
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
				$tempo_domingo = toTime($temposup - $tempoinf);				
			}else{
				// é impar
				$tempo_domingo = 'Faltam picagens';
			}
			
			//Horas de feriado
			$sql = "SELECT FORMAT(vr.CheckTime, 'HH:mm:ss') as horas FROM V_Record as vr WHERE vr.Userid = ".$data['Userid']." AND vr.CheckTime between '".$datefirst."' and DATEADD(DAY,1,'".$datesecond."') AND EXISTS(SELECT hol.BDate FROM Holiday hol WHERE CONVERT(VARCHAR(10),vr.CheckTime,110) = CONVERT(VARCHAR(10),hol.BDate,110)) order by CheckTime";
			
			$tempo_feriado = '';
			$result_feriado = $this->db->query($sql);
			if(($result_feriado->num_rows()) % 2 == 0)
			{
				//é par logo continuo
				$i = true;
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
				$tempo_feriado = toTime($temposup - $tempoinf);				
			}else{
				// é impar
				$tempo_feriado = 'Faltam picagens';
			}
			
			
			array_push($array_final,array(
				'Userid' => $data['Userid'],
				'Name' => $data['Name'],
				'Dias' => $dias_trabalhados,
				'HTrabalhadas' => $tempotrabalhado,
				'Hdomingo' => $tempo_domingo,
				'Hferiado' => $tempo_feriado
				));
			
			//aqui é para a linha total
			if($tempotrabalhado != 'Faltam picagens') $total_temp_trab = $total_temp_trab + toSeconds($tempotrabalhado);
			if($tempo_domingo != 'Faltam picagens') $total_hdomingo = $total_hdomingo + toSeconds($tempo_domingo);
			if($tempo_feriado != 'Faltam picagens') $total_hferiado = $total_hferiado + toSeconds($tempo_feriado);
		}
		
		array_push($array_final,array(
			'Userid' => '',
			'Name' => 'Total',
			'Dias' => '',
			'HTrabalhadas' => toTime($total_temp_trab),
			'Hdomingo' => toTime($total_hdomingo),
			'Hferiado' => toTime($total_hferiado)
			));
		
		return $array_final;
		
	}
}
?>