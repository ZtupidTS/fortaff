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
		//$date1 = explode('-',$datafirst);
		
		if($datasecond)
		{
			//se existe uma segunda data
			$date2 = explode('-',$datasecond);
			$sql = "select * from V_Record where Userid= ".$iduser." AND CheckTime between '".$datafirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datasecond." ".LAST_TIME."') order by CheckTime";
			return $this->picagem_model->getpicagens($sql);
		}else{
			$sql = "select * from V_Record where Userid= ".$iduser." AND CheckTime between '".$datafirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datafirst." ".LAST_TIME."')";
			return $this->picagem_model->getpicagens($sql);
		}
		/*$get = $this->db->get(TBL_VPICAGENS);
	    	//aqui vou ver se o user ja entrou uma vez
	    	if($get->num_rows() > 0)
	    	{
	    		return $get->result_array();	
	    	} 
	    	return array();*/
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
			$sql = "select DISTINCT Userid, Name, Duty from ".TBL_VPICAGENS." where Deptid != 23 AND Deptid != 22 AND Deptid != 24 AND CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."')";
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
	public function calculoresumo($array_user,$datefirst,$datesecond, $total = true)
	{
		$this->load->helper('myfunction_helper');
		
		$array_final = array();
		//variaveis totais
		$total_temp_trab = 0;
		$total_hdomingo = 0;
		$total_hferiado = 0;
		$total_hnoturnas = 0;
		$total_hinv = 0;
		foreach($array_user as $data)
		{
			//** ** ** dias trabalhados
			
			$sql = "select day(CheckTime), month(CheckTime), count(CheckTime) as qtd from V_Record where Userid = ".$data['Userid']." AND CheckTime between '".$datefirst."' and DATEADD(DAY,1,'".$datesecond."') group by day(CheckTime), MONTH(CheckTime)";
			
			$result_diastrabalhados = $this->db->query($sql);
			$dias_trabalhados = 0;
			
			if($result_diastrabalhados->num_rows() > 0)
			{
				foreach ($result_diastrabalhados->result() as $row)
				{
					$num = intval($row->qtd);
					if($num > 1) $dias_trabalhados++;
				}
			}
			
			//** ** ** horas trabalhadas
			
			$ret_array = $this->picagem_model->calculoHorasTrabalhadas($data['Userid'],$datefirst,$datesecond);
			
			$tempotrabalhado = $ret_array['horas'];			
			$tempopausas = $ret_array['pausas'];
			
			/*$sql = "select FORMAT(CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd-MM-yyyy') as dia from V_Record where Userid = ".$data['Userid']." AND CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."') order by CheckTime";
			$tempotrabalhado = 0;
			$tempopausas = 0;
			$result_tempotrabalhado = $this->db->query($sql);
			if(($result_tempotrabalhado->num_rows()) % 2 == 0)
			{
				$sql = "select Format(BDate, 'dd-MM-yyyy') as dia, SUBSTRING(Name,5,8) as hora from holiday where Name LIKE '%INV%' AND BDate between '".$datefirst."' and DATEADD(DAY,1,'".$datesecond."')";
				$result_diainv = $this->db->query($sql);
				if($result_diainv->num_rows() > 0)
				{
					$ret_array = calculohoras($result_tempotrabalhado->result(),$result_diainv->result());					
				}else{
					$ret_array = calculohoras($result_tempotrabalhado->result());
				}
				$tempotrabalhado = toTime($ret_array['horas']);			
				$tempopausas = toTime($ret_array['pausas']);			
			}else{
				// é impar
				$tempotrabalhado = 'Faltam picagens';
				$tempopausas = 'Faltam picagens';
			}*/
			
			//horas de domingo
			$sql = "select FORMAT(CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd-MM-yyyy') as dia from V_Record WHERE Userid = ".$data['Userid']." AND CAST(DATEPART(dw, checktime) AS VARCHAR) + FORMAT(checktime, 'HHmm') between 10330 and 20330 AND CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."') order by CheckTime";
			
			$tempo_domingo = 0;
			$tempopausas_dom = 0;
			$result_domingo = $this->db->query($sql);
			if(($result_domingo->num_rows()) % 2 == 0)
			{
				//esse sql serve para ver se ta a trabalhar num dia de inventario ou não
				$sql = "select Format(BDate, 'dd-MM-yyyy') as dia, SUBSTRING(Name,5,8) as hora from holiday where Name LIKE '%INV%' AND BDate between '".$datefirst."' and DATEADD(DAY,1,'".$datesecond."')";
				$result_diainv = $this->db->query($sql);
				if($result_diainv->num_rows() > 0)
				{
					$ret_array = calculohoras($result_domingo->result(),$result_diainv->result());
				}else{
					$ret_array = calculohoras($result_domingo->result());
				}
				$tempo_domingo = toTime($ret_array['horas']);			
				$tempopausas_dom = toTime($ret_array['pausas']);
			}else{
				// é impar
				$tempo_domingo = 'Faltam picagens';
				$tempopausas_dom = 'Faltam picagens';
			}
			
			//Horas de feriado
			$sql = "select CONVERT(VARCHAR(10),format(BDate, 'yyyy-MM-dd'),110) as datestart, CONVERT(VARCHAR(10),format(DATEADD(DAY,1,BDate), 'yyyy-MM-dd'),110) as dateend from Holiday where BDate between '".$datefirst."' and '".$datesecond."' AND Name NOT LIKE '%INV%' order by BDate";
			
			$result_feriado = $this->db->query($sql);
			if($result_feriado->num_rows() > 0)
			{
				$sql = "SELECT FORMAT(vr.CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'yyyy/MM/dd') as dia, hol.Name as Name FROM V_Record as vr, Holiday as hol WHERE vr.Userid =".$data['Userid']." AND (";
								
				$i = 0;
				foreach($result_feriado->result() as $row)
				{
					if($i > 0) $sql.= " or ";
					$sql .= "vr.CheckTime between '".$row->datestart." ".FIRST_TIME."' and '".$row->dateend." ".LAST_TIME."'";							
					$i++;
				}
				$sql .= ") AND hol.Name NOT LIKE '%INV%' AND (Format(vr.CheckTime, 'dd/MM/yyyy') = Format(hol.BDate, 'dd/MM/yyyy') or Format(vr.CheckTime, 'dd/MM/yyyy') = format(DATEADD(DAY,1,hol.BDate),'dd/MM/yyyy'))";
				
				//echo $sql;
				
				$tempo_feriado = 0;
				$tempopausas_feriado = 0;
				$result_feriado = $this->db->query($sql);
				
				if(($result_feriado->num_rows()) % 2 == 0)
				{
					//print_r($result_feriado->result());
					$ret_array = calculohoras($result_feriado->result());
					$tempo_feriado = toTime($ret_array['horas']);			
					$tempopausas_feriado = toTime($ret_array['pausas']);
				}else{
					// é impar
					$tempo_feriado = 'Faltam picagens';
					$tempopausas_feriado = 'Faltam picagens';				
				}
				
			}else{
				$tempo_feriado = 'Não Há Fer.';
				$tempopausas_feriado = 'Não há Fer.';
			}
			
			//horas inventario
			$tempo_inv = $this->picagem_model->calculoHorasInventario($data['Userid'],$datefirst,$datesecond);
			
			/*$sql = "select CONVERT(VARCHAR(10),format(BDate, 'yyyy-MM-dd'),110) as datestart, CONVERT(VARCHAR(10),format(DATEADD(DAY,1,BDate), 'yyyy-MM-dd'),110) as dateend from Holiday where BDate between '".$datefirst."' and '".$datesecond."' AND Name LIKE '%INV%' order by BDate";
			
			$result_inv = $this->db->query($sql);
			if($result_inv->num_rows() > 0)
			{
				$sql = "SELECT FORMAT(vr.CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/MM/yyyy') as dia, hol.Name as Name FROM V_Record as vr, Holiday as hol WHERE vr.Userid =".$data['Userid']." AND (";
				
				$i = 0;
				foreach($result_inv->result() as $row)
				{
					if($i > 0) $sql.= " or ";
					$sql .= "vr.CheckTime between '".$row->datestart." ".FIRST_TIME."' and '".$row->dateend." ".LAST_TIME."'";							$i++;
				}
				$sql .= ") AND hol.Name LIKE '%INV%' AND (Format(vr.CheckTime, 'dd/MM/yyyy') = Format(hol.BDate, 'dd/MM/yyyy') or Format(vr.CheckTime, 'dd/MM/yyyy') = format(DATEADD(DAY,1,hol.BDate),'dd/MM/yyyy'))";
				
				$tempo_inv = 0;
				$result_inv = $this->db->query($sql);
				if(($result_inv->num_rows()) % 2 == 0)
				{
					$tempo_inv = calculoInventario($result_inv->result());	
				}else{
					// é impar
					$tempo_inv = 'Faltam picagens';				
				}	
			}else{
				$tempo_inv = 'Não Há Inv.';
			}*/
			
			//horas noturnas
			$sql = "select FORMAT(CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'yyyy/MM/dd') as dia from V_Record where Userid = ".$data['Userid']." AND CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."') order by CheckTime";
			
			$tempo_noturno = 0;
			$result_noturno = $this->db->query($sql);
			if(($result_noturno->num_rows()) % 2 == 0)
			{
				//é par logo continuo
				if(strlen($data['Hnoturnas']) > 1)
				{
					$hora_not = intval($data['Hnoturnas']) * 3600;
					$tempo_noturno = calculNoturnas($result_noturno,$hora_not);
				}else{
					$tempo_noturno = 'Falta H.Not.';
				}							
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
				'HNoturnas' => $tempo_noturno,
				'HInv' => $tempo_inv
				));
			
			//aqui é para a linha total
			if($tempotrabalhado != 'Faltam picagens') $total_temp_trab += toSeconds($tempotrabalhado);
			if($tempo_domingo != 'Faltam picagens') $total_hdomingo += toSeconds($tempo_domingo);
			if(strlen($tempo_feriado) < 11) $total_hferiado += toSeconds($tempo_feriado);
			if(strlen($tempo_noturno) < 10 ) $total_hnoturnas += toSeconds($tempo_noturno);
			if(strlen($tempo_inv) < 11) $total_hinv += toSeconds($tempo_inv);
		}
		if($total)
		{
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
				'HNoturnas' => toTime($total_hnoturnas),
				'HInv' => toTime($total_hinv)
			));
		}
		return $array_final;
		
	}
	
	public function createexportsage($userid,$datefirst,$datesecond)
	{
		$this->load->helper('myfunction_helper');
		$this->load->helper('file');
		
		//como posso seleccionar o mes que quero tenho que ir pela data do segundo
		$month_number =  date("m", strtotime($datesecond));
		$year_number =  date("Y", strtotime($datesecond));
		$day_number =  cal_days_in_month(CAL_GREGORIAN,$month_number,$year_number);
		
		//texto do File
		$myfile = '';
		
		//valor do file é sempre o mesmo
		$valor = "00000000000.00";
		
		//todos menos reposição externa e administração
		//são os numero acima de 999
		$cod200_chefes = cal_days_in_month(CAL_GREGORIAN,$month_number,$year_number) - 26;
		
		//patrão e patroa
		$myfile .= "      0001".$day_number.".".$month_number.".".$year_number."       2000000".$cod200_chefes.".00".$valor."\r\n";
		
		$myfile .= "      0002".$day_number.".".$month_number.".".$year_number."       2000000".$cod200_chefes.".00".$valor."\r\n";
		
		//selecionar os chefes
		$sql = "select Userid from ".TBL_USERS." where Deptid = 23";
		
		$result = $this->db->query($sql);
		if($result->num_rows() >0)
		{
			foreach($result->result() as $row)
			{
				//base_url("home/exporttosage")
				$myfile .= "      ".useridTofourdigit($row->Userid).$day_number.".".$month_number.".".$year_number."       2000000".$cod200_chefes.".00".$valor."\r\n";
				//write_file('path', $data)
				
			}
		}else{
			return false;
		}
		
		//Agora os funcionarios
		$sql = "select Userid, Duty from Userinfo where Deptid NOT IN (1,4,22,23,24)";
		
		$result = $this->db->query($sql);
		if($result->num_rows() >0)
		{
			foreach($result->result() as $row)
			{
				//cod200
				$sql = "select day(CheckTime), month(CheckTime), count(CheckTime) as qtd from V_Record where Userid = ".$row->Userid." AND CheckTime between '".$datefirst."' and DATEADD(DAY,1,'".$datesecond."') group by day(CheckTime), MONTH(CheckTime)";
		
				$result_diastrabalhados = $this->db->query($sql);
				$dias_trabalhados = 0;
				
				if($result_diastrabalhados->num_rows() > 0)
				{
					foreach ($result_diastrabalhados->result() as $row2)
					{
						$num = intval($row2->qtd);
						if($num > 1) $dias_trabalhados++;
					}
				}
				$cod200_func = dayTotwodigit(cal_days_in_month(CAL_GREGORIAN,$month_number,$year_number) - $dias_trabalhados);
				
				$myfile .= "      ".useridTofourdigit($row->Userid).$day_number.".".$month_number.".".$year_number."       200000".$cod200_func.".00".$valor."\r\n";
				
				//cod A030 inventario
				
				
				$sql = "select CONVERT(VARCHAR(10),format(BDate, 'yyyy-MM-dd'),110) as datestart, CONVERT(VARCHAR(10),format(DATEADD(DAY,1,BDate), 'yyyy-MM-dd'),110) as dateend from Holiday where BDate between '".$datefirst."' and '".$datesecond."' AND Name LIKE '%INV%' order by BDate";
		
				$result_inv = $this->db->query($sql);
				if($result_inv->num_rows() > 0)
				{
					$sql = "SELECT DISTINCT vr.CheckTime, FORMAT(vr.CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/MM/yyyy') as dia, hol.Name as Name FROM V_Record as vr, Holiday as hol WHERE vr.Userid =".$row->Userid." AND (";
					
					$i = 0;
					foreach($result_inv->result() as $row2)
					{
						if($i > 0) $sql.= " or ";
						$sql .= "vr.CheckTime between '".$row2->datestart." ".FIRST_TIME."' and '".$row2->dateend." ".LAST_TIME."'";					$i++;
					}
					$sql .= ") AND hol.Name LIKE '%INV%' AND (Format(vr.CheckTime, 'dd/MM/yyyy') = Format(hol.BDate, 'dd/MM/yyyy') or Format(vr.CheckTime, 'dd/MM/yyyy') = format(DATEADD(DAY,1,hol.BDate),'dd/MM/yyyy'))";
					
					$tempo_inv = 0;
					$result_inv = $this->db->query($sql);
					if(($result_inv->num_rows()) % 2 == 0)
					{
						$tempo_inv = calculoInventario($result_inv->result());
						$tempo_inv = toSeconds($tempo_inv)/3600;
						$tempo_inv = qtdexportsage($tempo_inv);
					}else{
						// é impar
						$tempo_inv = "00000.00";				
					}	
				}else{
					$tempo_inv = "00000.00";
				}
				$cod_A030 = $tempo_inv;
				
				if($cod_A030 != '00000.00') $myfile .= "      ".useridTofourdigit($row->Userid).$day_number.".".$month_number.".".$year_number."      A030".$cod_A030.$valor."\r\n";
				
				//cod A5002 horas de domingo
				$sql = "select FORMAT(CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd-MM-yyyy') as dia from V_Record WHERE Userid = ".$row->Userid." AND CAST(DATEPART(dw, checktime) AS VARCHAR) + FORMAT(checktime, 'HHmm') between 10330 and 20330 AND CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."') order by CheckTime";
		
				$tempo_domingo = 0;
				$result_domingo = $this->db->query($sql);
				if(($result_domingo->num_rows()) % 2 == 0)
				{
					//esse sql serve para ver se ta a trabalhar num dia de inventario ou não
					$sql = "select Format(BDate, 'dd-MM-yyyy') as dia, SUBSTRING(Name,5,8) as hora from holiday where Name LIKE '%INV%' AND BDate between '".$datefirst."' and DATEADD(DAY,1,'".$datesecond."')";
					$result_diainv = $this->db->query($sql);
					if($result_diainv->num_rows() > 0)
					{
						$ret_array = calculohoras($result_domingo->result(),$result_diainv->result());
					}else{
						$ret_array = calculohoras($result_domingo->result());
					}
					$tempo_domingo = $ret_array['horas']/3600;
					$tempo_domingo = qtdexportsage($tempo_domingo);
				}else{
					$tempo_domingo = "00000.00";						
				}
				$cod_A5002 = $tempo_domingo;
				
				if($cod_A5002 != '00000.00') $myfile .= "      ".useridTofourdigit($row->Userid).$day_number.".".$month_number.".".$year_number."     A5002".$cod_A5002.$valor."\r\n";
				
				//cod A5003 horas de feriado
				$sql = "select CONVERT(VARCHAR(10),format(BDate, 'yyyy-MM-dd'),110) as datestart, CONVERT(VARCHAR(10),format(DATEADD(DAY,1,BDate), 'yyyy-MM-dd'),110) as dateend from Holiday where BDate between '".$datefirst."' and '".$datesecond."' AND Name NOT LIKE '%INV%' order by BDate";
		
				$result_feriado = $this->db->query($sql);
				if($result_feriado->num_rows() > 0)
				{
					$sql = "SELECT FORMAT(vr.CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'yyyy/MM/dd') as dia, hol.Name as Name FROM V_Record as vr, Holiday as hol WHERE vr.Userid =".$row->Userid." AND (";
									
					$i = 0;
					foreach($result_feriado->result() as $row2)
					{
						if($i > 0) $sql.= " or ";
						$sql .= "vr.CheckTime between '".$row2->datestart." ".FIRST_TIME."' and '".$row2->dateend." ".LAST_TIME."'";							
						$i++;
					}
					$sql .= ") AND hol.Name NOT LIKE '%INV%' AND (Format(vr.CheckTime, 'dd/MM/yyyy') = Format(hol.BDate, 'dd/MM/yyyy') or Format(vr.CheckTime, 'dd/MM/yyyy') = format(DATEADD(DAY,1,hol.BDate),'dd/MM/yyyy'))";
					
					//echo $sql;
					
					$tempo_feriado = 0;
					$result_feriado = $this->db->query($sql);
					
					if(($result_feriado->num_rows()) % 2 == 0)
					{
						//print_r($result_feriado->result());
						$ret_array = calculohoras($result_feriado->result());
						$tempo_feriado = $ret_array['horas']/3600;
						$tempo_feriado = qtdexportsage($tempo_feriado);
					}else{
						// é impar
						$tempo_feriado = "00000.00";
					}
				}else{
					$tempo_feriado = "00000.00";
				}
				$cod_A5003 = $tempo_feriado;
				
				if($cod_A5003 != '00000.00') $myfile .= "      ".useridTofourdigit($row->Userid).$day_number.".".$month_number.".".$year_number."     A5003".$cod_A5003.$valor."\r\n";
				
				//cod A5023 horas noturnas
				$sql = "select FORMAT(CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'yyyy/MM/dd') as dia from V_Record where Userid = ".$row->Userid." AND CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."') order by CheckTime";
				
				$tempo_noturno = 0;
				$result_noturno = $this->db->query($sql);
				if(($result_noturno->num_rows()) % 2 == 0)
				{
					//é par logo continuo
					if(strlen($row->Duty) > 1)
					{
						$hora_not = intval($row->Duty) * 3600;
						$tempo_noturno = calculNoturnas($result_noturno,$hora_not);
						$tempo_noturno = toSeconds($tempo_noturno)/3600;
						$tempo_noturno = qtdexportsage($tempo_noturno);
					}else{
						$tempo_noturno = "00000.00";
					}							
				}else{
					// é impar
					$tempo_noturno = "00000.00";				
				}
				$cod_A5023 = $tempo_noturno;
				
				if($cod_A5023 != '00000.00') $myfile .= "      ".useridTofourdigit($row->Userid).$day_number.".".$month_number.".".$year_number."     A5023".$cod_A5023.$valor."\r\n";
				
			}
			write_file('./export/sage.txt', $myfile);	
		}else{
			return false;
		}
		return true;
	}

	/*
	* Horas trabalhas
	*/
	public function calculoHorasTrabalhadas($userid,$datefirst,$datesecond)
	{
		$sql = "select FORMAT(CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd-MM-yyyy') as dia from V_Record where Userid = ".$userid." AND CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."') order by CheckTime";
		
		$tempotrabalhado = 0;
		$tempopausas = 0;
		$result_tempotrabalhado = $this->db->query($sql);
		if(($result_tempotrabalhado->num_rows()) % 2 == 0)
		{
			$sql = "select Format(BDate, 'dd-MM-yyyy') as dia, SUBSTRING(Name,5,8) as hora from holiday where Name LIKE '%INV%' AND BDate between '".$datefirst."' and DATEADD(DAY,1,'".$datesecond."')";
			$result_diainv = $this->db->query($sql);
			if($result_diainv->num_rows() > 0)
			{
				$ret_array = calculohoras($result_tempotrabalhado->result(),$result_diainv->result());					
			}else{
				$ret_array = calculohoras($result_tempotrabalhado->result());
			}
			$tempotrabalhado = toTime($ret_array['horas']);			
			$tempopausas = toTime($ret_array['pausas']);			
		}else{
			// é impar
			$tempotrabalhado = 'Faltam picagens';
			$tempopausas = 'Faltam picagens';
		}
		return array('horas' => $tempotrabalhado, 'pausas' => $tempopausas);
	}
	
	/*
	* Horas de inventario
	*/
	public function calculoHorasInventario($userid,$datefirst,$datesecond)
	{
		$sql = "select CONVERT(VARCHAR(10),format(BDate, 'yyyy-MM-dd'),110) as datestart, CONVERT(VARCHAR(10),format(DATEADD(DAY,1,BDate), 'yyyy-MM-dd'),110) as dateend from Holiday where BDate between '".$datefirst."' and '".$datesecond."' AND Name LIKE '%INV%' order by BDate";
			
		$result_inv = $this->db->query($sql);
		if($result_inv->num_rows() > 0)
		{
			$sql = "SELECT DISTINCT vr.CheckTime, FORMAT(vr.CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/MM/yyyy') as dia, hol.Name as Name FROM V_Record as vr, Holiday as hol WHERE vr.Userid =".$userid." AND (";
			
			$i = 0;
			foreach($result_inv->result() as $row)
			{
				if($i > 0) $sql.= " or ";
				$sql .= "vr.CheckTime between '".$row->datestart." ".FIRST_TIME."' and '".$row->dateend." ".LAST_TIME."'";							$i++;
			}
			$sql .= ") AND hol.Name LIKE '%INV%' AND (Format(vr.CheckTime, 'dd/MM/yyyy') = Format(hol.BDate, 'dd/MM/yyyy') or Format(vr.CheckTime, 'dd/MM/yyyy') = format(DATEADD(DAY,1,hol.BDate),'dd/MM/yyyy'))";
			
			$tempo_inv = 0;
			$result_inv = $this->db->query($sql);
			if(($result_inv->num_rows()) % 2 == 0)
			{
				$tempo_inv = calculoInventario($result_inv->result());	
			}else{
				// é impar
				$tempo_inv = 'Faltam picagens';				
			}	
		}else{
			$tempo_inv = 'Não Há Inv.';
		}
		return $tempo_inv;
	}
	
	
	//para a tabela de vizualização de picagens
	public function viewPicagens($firstdate,$seconddate,$result,$userid)
	{
		$message = '';
		$olddate = '';
		$datefirst = date_create($firstdate . '00:00:00.000');
		$datesecond = date_create($seconddate . '00:00:00.000');
		
		foreach($result as $row)
		{
			$newdate = date_create($row['CheckTime']);
			$hora = toSeconds(date_format($newdate,'H:i:s'));
			
			while(date_format($datefirst,'y-m-d') < date_format($newdate,'y-m-d'))
			{
				//class="danger"
				if(date('w', strtotime(date_format($datefirst,'Ymd'))) == 0)
				{
					$message .= '<tr class="danger" onclick="corrigirPicagens('.date_format($datefirst,'Ymd').')"><td>'.date_format($datefirst,'d-m-y').'</td><td></td></tr>';
				}else{
					$message .= '<tr onclick="corrigirPicagens('.date_format($datefirst,'Ymd').')"><td>'.date_format($datefirst,'d-m-y').'</td><td></td></tr>';	
				}
				
				$datefirst->add(new DateInterval('P1D'));
			}
			
			if($olddate == '' && date_format($datefirst,'y-m-d') == date_format($newdate,'y-m-d'))
			{
				if(date('w', strtotime(date_format($datefirst,'Ymd'))) == 0)
				{
					$message .= '<tr class="danger" onclick="corrigirPicagens('.date_format($newdate,'Ymd').')"><td>'.date_format($newdate,'d-m-y').'</td>';
				}else{
					$message .= '<tr onclick="corrigirPicagens('.date_format($newdate,'Ymd').')"><td>'.date_format($newdate,'d-m-y').'</td>';
				}
				$datefirst->add(new DateInterval('P1D'));
			}
			
			if($olddate != '' && date_format($newdate,'y-m-d') > date_format($olddate,'y-m-d') && date_format($datefirst,'y-m-d') == date_format($newdate,'y-m-d'))
			{
				if($hora < LAST_TIME_SEC)
				{
					$message .= '<td>'.date_format($newdate,'H:i:s').'</td>';
					
					if(date('w', strtotime(date_format($datefirst,'Ymd'))) == 0)
					{
						$message .= '</tr><tr class="danger" onclick="corrigirPicagens('.date_format($newdate,'Ymd').')"><td>'.date_format($newdate,'d-m-y').'</td>';
					}else{
						$message .= '</tr><tr onclick="corrigirPicagens('.date_format($newdate,'Ymd').')"><td>'.date_format($newdate,'d-m-y').'</td>';
					}
				}else{
					if(date('w', strtotime(date_format($datefirst,'Ymd'))) == 0)
					{
						$message .= '</tr><tr class="danger" onclick="corrigirPicagens('.date_format($newdate,'Ymd').')"><td>'.date_format($newdate,'d-m-y').'</td>';
					}else{
						$message .= '</tr><tr onclick="corrigirPicagens('.date_format($newdate,'Ymd').')"><td>'.date_format($newdate,'d-m-y').'</td>';
					}
					$message .= '<td>'.date_format($newdate,'H:i:s').'</td>';
				}
				$datefirst->add(new DateInterval('P1D'));
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
		while(date_format($datefirst,'y-m-d') <= date_format($datesecond,'y-m-d'))
		{
			if(date('w', strtotime(date_format($datefirst,'Ymd'))) == 0)
			{
				$message .= '<tr onclick="corrigirPicagens('.date_format($datefirst,'Ymd').')"><td>'.date_format($datefirst,'d-m-y').'</td><td></td></tr>';
			}else{
				$message .= '<tr onclick="corrigirPicagens('.date_format($datefirst,'Ymd').')"><td>'.date_format($datefirst,'d-m-y').'</td><td></td></tr>';
			}
			$datefirst->add(new DateInterval('P1D'));
		}
		return $message;
	}
}
?>