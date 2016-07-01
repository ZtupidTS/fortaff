<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function Home()
	{
		parent::__construct();

		if(!$this->session->userdata('logged'))
	    		redirect('login');
	}
	
	
	public function index()
	{
		log_message('utilizadores', $this->session->userdata('user_id').' - '.$this->session->userdata('nome').': Entrou');
		if($this->session->userdata('level') == 2)
		{
			$this->load->view('v_home');
		}
		if($this->session->userdata('level') != 2)
		{
			$this->load->view('v_verpicagens');
		}
	}
	
	/*
	* Paras consultar o resumo das horas referente as picagens
	*/
	public function resumototais()
	{
		//tenho que enviar os dpt
		$result = $this->picagem_model->getDpt();
		if($result)
		{
			$data['result'] = $result;
			$this->load->view('v_resumopicagens', $data);	
		}		
	}
	
	/*
	* Paras consultar o resumo das horas com resumo diario
	*/
	public function resumodiario()
	{
		//tenho que enviar os dpt
		$result = $this->user_model->getAll();
		if($result)
		{
			$data['result'] = $result;
			$this->load->view('v_resumodiario', $data);	
		}else{
			$data['result'] = $result;
			$data['erro'] = 'Problemas na obtenção dos dados, tentar novamente.';
			$this->load->view("v_resumodiario", $data);
		}		
	}
	
	/*
	* Paras consultar o resumo das horas com resumo semanal
	*/
	public function resumosemanal()
	{
		//tenho que enviar os dpt
		$result = $this->picagem_model->getDpt();
		if($result)
		{
			$data['result'] = $result;
			$this->load->view('v_resumosemanal', $data);	
		}else{
			$data['result'] = $result;
			$data['erro'] = 'Problemas na obtenção dos dados, tentar novamente.';
			$this->load->view("v_resumosemanal", $data);
		}		
	}
	
	/*
	* Vou devolver as picagens de toda gente da loja
	*/
	public function picagemAll()
	{
		$this->load->helper('myfunction_helper');
		
		$firstdate = $this->input->post('datefirst');
		$seconddate = $this->input->post('datesecond');
		$userid  = $this->input->post('Userid');
		
		$resultuser = $this->user_model->getAll();
		if($resultuser)
		{
			$return = '';
			$message = '';
			$i = 0;
			foreach($resultuser->result() as $row_user)
			{
				$message_tb_head = '<table class="table table-hover picagens table-borderless" id="picagens'.$i.'"><caption>'.$row_user->Userid.' - '.$row_user->Name.'</caption><thead><tr><th>Dia</th><th colspan="12">Picagens</th></tr></thead>';
				
				$result = $this->picagem_model->picagensbyuser($row_user->Userid,$firstdate,$seconddate);
				if($result)
				{
					$message_return = $this->picagem_model->viewPicagens($firstdate,$seconddate,$result,$row_user->Userid);
					$message .= $message_tb_head . $message_return .'</tbody></table>';	
				}else{
					$message .= $message_tb_head . '<tr><td colspan="2">Não tem picagens</td></tr></tbody></table>';
				}
				$i++;				
			}
			
			$array_table = array();
			for($l=0;$l<$i;$l++)
			{
				array_push($array_table,'picagens'.$l);
			}
			
			$return = array(
				'return' => 'success',
				'message' => $message,
				'array_table' => $array_table
			);
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'Não tem picagens? Verificar'
			);
			echo json_encode($return);
			return true;
		}
	}
	
	/*
	* Obter as picagens por utilizador e dar o resumo de picagens pelas datas escolhidas
	*/
	public function picagembyuser()
	{
		$this->load->helper('myfunction_helper');
		
		$firstdate = $this->input->post('datefirst');
		$seconddate = $this->input->post('datesecond');
		$userid  = $this->input->post('Userid');
		
		if($this->session->userdata('user_id') != 12)
		{
			log_message('utilizadores', $this->session->userdata('user_id').' - '.$this->session->userdata('nome').': Viu picagens (Ver picagens) do funcionario '.$this->input->post('Namefunc'));	
		}
		
		$result = $this->picagem_model->picagensbyuser($userid,$firstdate,$seconddate);
		
		if($result)
		{
			$message_tb_head = '<table class="table table-hover picagens table-borderless" id="picagens1"><thead><tr><th>Dia</th><th colspan="12">Picagens</th></tr></thead>';
				
			$message = $this->picagem_model->viewPicagens($firstdate,$seconddate,$result,$userid);
			$message = $message_tb_head . $message .'</tbody></table>';
		
			$array_table = array('picagens1');
			$return = array(
				'return' => 'success',
				'message' => $message,
				'array_table' => $array_table
			);
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'Não tem picagens? Verificar'
			);
			echo json_encode($return);
			return true;
		}
	}

	/*
	* Vou devolver as picagens de toda gente da loja
	*/
	public function picagemResumodiario()
	{
		$this->load->helper('myfunction_helper');
		
		$firstdate = date_create($this->input->post('datefirst'));
		$seconddate = date_create($this->input->post('datesecond'));
		$userid  = $this->input->post('Userid');
		
		if($this->session->userdata('user_id') != 12)
		{
			log_message('utilizadores', $this->session->userdata('user_id').' - '.$this->session->userdata('nome').': Viu picagens (R. Diario) do funcionario '.$this->input->post('Namefunc'));	
		}
		
		if($userid == '999999')
		{
			$resultuser = $this->user_model->getAll();	
		}else{
			$resultuser = $this->user_model->get($userid);
		}
		
		if($resultuser)
		{
			$return = '';
			$message = '';
			$message_return = '';
			$i = 0;
			$array_table = array();
			
			if($userid == '999999')
			{
				foreach($resultuser->result() as $row_user)
				{
					$message_tb_head = '<table class="table table-hover picagens table-borderless" id="picagens'.$i.'"><caption>'.$row_user->Userid.' - '.$row_user->Name.'</caption><thead><tr><th>Dia</th><th>H. Trabalhadas</th><th>H. Pausas</th></tr></thead>';
					
					while(date_format($firstdate,'y-m-d') <= date_format($seconddate,'y-m-d'))
					{
						$result = $this->picagem_model->calculoHorasTrabalhadas($row_user->Userid,$firstdate->format('Y-m-d'),$firstdate->format('Y-m-d'));
						
						if(date('w', strtotime(date_format($firstdate,'Ymd'))) == 0)
						{
							$message_return .= '<tr class="danger"><td>'.date_format($firstdate,'d-m-y').'</td>';
						}else{
							$message_return .= '<tr><td>'.date_format($firstdate,'d-m-y').'</td>';
						}
						
						if($result['horas'] == '00:00:00')
						{
							$message_return .= '<td colspan="2" class="text-center text-danger">Não Trabalhou</td></tr>';
						}else{
							$message_return .= '<td>'.$result['horas'].'</td><td>'.$result['pausas'].'</td></tr>';
						}
						
						$firstdate->add(new DateInterval('P1D'));
					}
					
					$message .= $message_tb_head . $message_return .'</tbody></table>';	
					$i++;				
				}
				
				for($l=0;$l<$i;$l++)
				{
					array_push($array_table,'picagens'.$l);
				}
			}else{
				$message_tb_head = '<table class="table table-hover picagens table-borderless" id="picagens'.$i.'"><caption>'.$resultuser['Userid'].' - '.$resultuser['Name'].'</caption><thead><tr><th>Dia</th><th>H. Trabalhadas</th><th>H. Pausas</th></tr></thead>';
					
				while(date_format($firstdate,'y-m-d') <= date_format($seconddate,'y-m-d'))
				{
					$result = $this->picagem_model->calculoHorasTrabalhadas($resultuser['Userid'],$firstdate->format('Y-m-d'),$firstdate->format('Y-m-d'));
					if(date('w', strtotime(date_format($firstdate,'Ymd'))) == 0)
					{
						$message_return .= '<tr class="danger"><td>'.date_format($firstdate,'d-m-y').'</td>';
					}else{
						$message_return .= '<tr><td>'.date_format($firstdate,'d-m-y').'</td>';
					}
					//$message_return .= '<tr><td>'.date_format($firstdate,'d-m-y').'</td>';
					
					if($result['horas'] == '00:00:00')
					{
						$message_return .= '<td colspan="2" class="text-center text-danger">Não Trabalhou</td></tr>';
					}else{
						$message_return .= '<td>'.$result['horas'].'</td><td>'.$result['pausas'].'</td></tr>';
					}
					
					$firstdate->add(new DateInterval('P1D'));
				}
				
				$message .= $message_tb_head . $message_return .'</tbody></table>';
				array_push($array_table,'picagens'.$i);
			}
			
			
			$return = array(
				'return' => 'success',
				'message' => $message,
				'array_table' => $array_table
			);
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'Não tem picagens? Verificar'
			);
			echo json_encode($return);
			return true;
		}
	}
	
	/*
	* Paras consultar o resumo das horas referente as picagens
	*/
	public function ver()
	{
		//tenho que enviar os dpt
		$result = $this->user_model->getAll();
		if($result)
		{
			$data['result'] = $result;
			$this->load->view('v_verpicagens', $data);	
		}else{
			$data['result'] = $result;
			$data['erro'] = 'Problemas na obtenção dos dados, tentar novamente.';
			$this->load->view("v_verpicagens", $data);
		}		
	}
	
	/*
	* Verifica se existe falta de picagens nos funcionarios
	*/
	public function verify_picagens($iduser = FALSE)
	{
		//Agora nas datas e vou ver o numero de picagens pelos funcionarios
		$firstdate = $this->input->post('datefirst');
		$seconddate = $this->input->post('datesecond');
		
		//para voltar a preencher o input
		$data['datefirst'] = $firstdate;
		$data['datesecond'] = $seconddate;
		
		$array_picagemfaltam = array();
		
		if(!$iduser)
		{
			//nessa query só vou buscar o numero impares para saber onde falta picagens
			/*$sql = "select * from(select (count(Logid) % 2) as odd, count(Logid) as number, Userid, datepart(DAY,CheckTime) as dia, FORMAT(datepart(Month,CheckTime),'00') as mes, datepart(Year,CheckTime) as ano, Name from V_Record where CheckTime between '".$firstdate."' and DATEADD(DAY,1,'".$seconddate."') group by datepart(DAY,CheckTime), Userid, datepart(Month,CheckTime), datepart(Year,CheckTime), Name) d where odd = 1";*/
			
			//para todas datas do filtro
			while($firstdate <= $seconddate)
			{
				$sql = "select * from(select (count(Logid) % 2) as odd, count(Logid) as number, Userid, Name from V_Record where CheckTime between '".$firstdate." ".FIRST_TIME."' and DATEADD(DAY,1,'".$firstdate." ".LAST_TIME."') group by  Userid,   Name) d where odd = 1";
				$result = $this->picagem_model->getpicagens($sql);
				
				if($result)
				{
					$parts = explode('-', $firstdate);
				
					foreach($result as $row)
					{
						array_push($array_picagemfaltam,array(
							'Userid' => $row['Userid'],
							'Name' => $row['Name'],
							'ano' => $parts[0],
							'mes' => $parts[1],
							'dia' => $parts[2],
							'number' => $row['number']
						));
					}
				}
				$firstdate = date('Y-m-d', strtotime($firstdate . ' +1 day'));					
			}	
		}
		//devolve um array
		
		if($array_picagemfaltam)
		{
			$data['result'] = $array_picagemfaltam;
			$this->load->view("v_home", $data);
		}else{
			$data['informacao'] = 'Sem Resultados / Verifcar Datas inseridas';
			$this->load->view("v_home", $data);
		}
	}
	
	/*
	* Para ir buscar a DB os dados para corrigir
	*/
	public function obter_picagens()
	{
		//ponho ja os dados no $data
		$data['iduser'] = $this->input->post('iduser');
		$data['datapicagem'] = $this->input->post('datapicagem');
		$data['datefirst'] = $this->input->post('datefirst');
		$data['datesecond'] = $this->input->post('datesecond');
		$data['nomeuser'] = $this->input->post('nome');
		
		//ir a DB buscar as picagens
		$result = $this->picagem_model->picagensbyuser($data['iduser'],$data['datapicagem']);
		if($result)
		{
			$data['result'] = $result;
			$this->load->view("v_corrigirpicagens", $data);
		}else{
			$data['result'] = $result;
			//isso é para quando vou de ver as picagens para essa pagina de corrigir picagens
			//assim não precido de reescrever outra pagina
			if($data['datefirst'] != '')
			{
				$data['erro'] = 'Problemas na obtenção dos dados, tentar novamente.';	
			}
			$this->load->view("v_corrigirpicagens", $data);
		}
		
	}
	
	/*
	* editar a picagem
	*/
	public function editar_picagem()
	{
		//print_r($_POST);
		/*antigapicagem
		novapicagem
		logid
		datapicagem
		echo $iduser.' ';
		echo $datapicagem.' ';
		echo $datefirst.' ';
		echo $datesecond.' ';*/
		if($this->input->post('novapicagem') == '')
		{
			echo 'Não inseriu a hora da nova picagem';
			return true;
		}else{
			if($this->session->userdata('user_id') != 12)
			{
				log_message('utilizadores', $this->session->userdata('user_id').' - '.$this->session->userdata('nome').': Edito picagens do funcionario '.$this->input->post('nome').' do dia '.$this->input->post('datapicagem'). ' old: '.$this->input->post('antigapicagem').' nova: '.$this->input->post('novapicagem'));
			}
			
			$newpicagem = $this->input->post('datapicagem').' '.$this->input->post('novapicagem').'.000';
			$sql_data = array(
		            'CheckTime'        => $newpicagem
		        );
		        $result = $this->picagem_model->updatepicagem($this->input->post('logid'),$sql_data);
		        if($result)
		        {
				$return = array(
					'return' => 'success',
					'message' => 'Atualização realizada com sucesso');
				echo json_encode($return);
				return true;
			}else{
				$return = array(
					'return' => 'error',
					'message' => 'Atualização com problemas');
				echo json_encode($return);
				return true;
			}
		}
	}
	
	/*
	* Eliminar picagens
	*/
	public function del_picagem()
	{
		$result = $this->picagem_model->deletepicagem($this->input->post('logid'));
		
		if($this->session->userdata('user_id') != 12)
		{
			log_message('utilizadores', $this->session->userdata('user_id').' - '.$this->session->userdata('nome').': Elimino picagens do funcionario '.$this->input->post('nome').' do dia '.$this->input->post('datapicagem').' ('.$this->input->post('antigapicagem').')');
		}
		
		if($result)
	        {
			$return = array(
				'return' => 'success',
				'message' => 'Registo eliminado com sucesso');
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'Occoreu um erro e o registo não foi eliminado');
			echo json_encode($return);
			return true;
		}
	}
	
	/*
	* Adicionar picagem
	*/
	public function add_picagem()
	{
		$this->load->helper('myfunction_helper');
		$new_hora_picagem = toSeconds($this->input->post('novapicagem'));
		
		if($this->session->userdata('user_id') != 12)
		{
			log_message('utilizadores', $this->session->userdata('user_id').' - '.$this->session->userdata('nome').': Adiciono picagens do funcionario '.$this->input->post('nome').' do dia '.$this->input->post('datapicagem').' ('.$this->input->post('novapicagem').')');
		}		
		
		if($new_hora_picagem < LAST_TIME_SEC)
		{
			$newday = date('Y-m-d', strtotime($this->input->post('datapicagem') . ' +1 day'));
			$newpicagem = $newday.' '.$this->input->post('novapicagem').'.000';
		}else{
			if($new_hora_picagem < 86399)
			{
				$newpicagem = $this->input->post('datapicagem').' '.$this->input->post('novapicagem').'.000';
			}else{
				$return = array(
					'return' => 'error',
					'message' => 'A picagem não foi inserida, por haver um problema na hora de inserção');
				echo json_encode($return);
				return true;
			}
		}
		
		//$newpicagem = $this->input->post('datapicagem').' '.$this->input->post('novapicagem').'.000';
		$sql_data = array(
		            'CheckTime'        	=> $newpicagem,
		            'Userid'		=> $this->input->post('iduser'),
		            'CheckType'		=> 0,
		            'Sensorid'		=> 0,
		            'WorkType'		=> 0,
		            'Checked'		=> 1,
		            'Exported'		=> 0,
		            'OpenDoorFlag'	=> 0		            
		        );
		
		$result = $this->picagem_model->addpicagem($sql_data);
		if($result)
	        {
			$Logid = $this->db->insert_id();
			$return = array(
				'return' => 'success',
				'Logid'  => $Logid,
				'message' => 'Picagem inserida com sucesso');
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'A picagem não foi inserida, voltar a tentar');
			echo json_encode($return);
			return true;
		}
	}
	
	/*
	* obtenho as picagens referente ao que foi pedido
	*/
	public function obterresumopicagem()
	{
		$datefirst = $this->input->post('datefirst');
		$datesecond = $this->input->post('datesecond');
		$departamento = $this->input->post('departamento');
		
		$result = $this->picagem_model->getresumopicagem($departamento,$datefirst,$datesecond);
		//print_r($result);
		if($result)
		{
			$message_tb_head = '<table class="table table-hover picagens display" id="picagens"><thead><tr><th>Nº</th><th>Nome</th><th>Dias Trab.</th><th>Horas Trab.</th><th>Pausas Trab.</th><th>Horas Dom.</th><th>P. Horas Dom.</th><th>Horas Fer.</th><th>P. Horas Fer.</th><th>Horas Not.</th><th>Horas Inv.</th></tr></thead>';
			
			$message = '';
			foreach($result as $row)
			{
				if($row['Name'] == 'Total')
				{
					$message_tb_foot = '<tfoot><tr><td><b>'.$row['Userid'].'</b></td><td><b>'.$row['Name'].'</b></td><td><b>'.$row['Dias'].'</b></td><td><b>'.$row['HTrabalhadas'].'</b></td></td><td><b>'.$row['HPTrab'].'</b></td><td><b>'.$row['Hdomingo'].'</b></td><td><b>'.$row['HPdomingo'].'</b></td><td><b>'.$row['Hferiado'].'</b></td><td><b>'.$row['HPferiado'].'</b></td><td><b>'.$row['HNoturnas'].'</b></td><td><b>'.$row['HInv'].'</b></td></tr></tfoot><tbody>';
				}else{
					$message .= '<tr><td>'.$row['Userid'].'</td><td>'.$row['Name'].'</td><td>'.$row['Dias'].'</td><td>'.$row['HTrabalhadas'].'</td><td>'.$row['HPTrab'].'</td><td>'.$row['Hdomingo'].'</td><td>'.$row['HPdomingo'].'</td><td>'.$row['Hferiado'].'</td><td>'.$row['HPferiado'].'</td><td>'.$row['HNoturnas'].'</td><td>'.$row['HInv'].'</td></tr>';	
				}
			}
			$message = $message_tb_head . $message_tb_foot . $message .'</tbody></table>';
			
			$return = array(
				'return' => 'success',
				'Logid'  => 'blabla',
				'message' => $message
				);
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'Não foi possível obter dados, se o problema persistir contactar o administrador');
			echo json_encode($return);
			return true;
		}
	}
	
	/*
	* Resumo semanal de trabalho
	*/
	public function picagemResumosemanal()
	{
		$this->load->helper('myfunction_helper');
		
		$datefirst = $this->input->post('datefirst');
		$datesecond = $this->input->post('datesecond');
		$departamento = $this->input->post('departamento');
		
		$result = $this->picagem_model->getresumopicagem($departamento,$datefirst,$datesecond);
		//print_r($result);
		if($result)
		{
			$message_tb_head = '<table class="table table-hover picagens display" id="picagens"><thead><tr><th>Nº</th><th>Nome</th><th>Dias Trab.</th><th>Contracto</th><th>Horas Trab.</th></tr></thead><tbody>';
			
			$message = '';
			foreach($result as $row)
			{
				$result2 = $this->user_model->get($row['Userid']);
				if($row['Name'] != 'Total')
				{
					if($result2['Contracto'] == '')
					{
						$message .= '<tr><td>'.$row['Userid'].'</td><td>'.$row['Name'].'</td><td>'.$row['Dias'].'</td><td>Não Foi Preenchido</td><td class="text-center">'.$row['HTrabalhadas'].'</td></tr>';
					}else{
						
						$hcontracto = intval($result2['Contracto']) * 3600;
						$htrab = toSeconds($row['HTrabalhadas']);
						
						if($htrab < ($hcontracto - 900) || $htrab > ($hcontracto + 3600))
						{
							$message .= '<tr><td>'.$row['Userid'].'</td><td>'.$row['Name'].'</td><td>'.$row['Dias'].'</td><td>'.$result2['Contracto'].' h</td><td class="text-center text-danger">'.$row['HTrabalhadas'].'</td></tr>';
						}else{
							$message .= '<tr><td>'.$row['Userid'].'</td><td>'.$row['Name'].'</td><td>'.$row['Dias'].'</td><td>'.$result2['Contracto'].' h</td><td class="text-center">'.$row['HTrabalhadas'].'</td></tr>';
						}	
					}
				}
			}
			$message = $message_tb_head . $message .'</tbody></table>';
			
			$return = array(
				'return' => 'success',
				'message' => $message
				);
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'Não foi possível obter dados, se o problema persistir contactar o administrador');
			echo json_encode($return);
			return true;
		}
	}
	
	/*
	* Para ir ver os feriados
	*/
	public function feriados()
	{
		//como só vou usar o model feriado aqui só o vou por a  carregar aqui
		$this->load->model('holiday_model');
		
		$result = $this->holiday_model->getHoliday();
		if($result)
		{
			$data['result'] = $result;
			$this->load->view('v_holidays', $data);	
		}else{
			$data['erro'] = 'Problemas na obtenção dos dados, tentar novamente.';
			$this->load->view('v_holidays', $data);
		}
	}
	
	/*
	* Para ver e editar os contractos
	*/
	public function contractos()
	{
		$result = $this->user_model->get();
		$data['result'] = $result;
		$this->load->view('v_contracto', $data);		
	}
	
	/*
	* editar feriado
	*/
	public function editar_holiday()
	{
		//como só vou usar o model feriado aqui só o vou por a  carregar aqui
		$this->load->model('holiday_model');
		
		$newname = $this->input->post('Name');
		$newdate = $this->input->post('BDate').' 00:00:00.000';
		$sql_data = array(
	            'BDate'        => $newdate,
	            'Name'        => $newname
	        );
	        $result = $this->holiday_model->updateholiday($this->input->post('Holidayid'),$sql_data);
	        if($result)
	        {
			$return = array(
				'return' => 'success',
				'message' => 'Atualização realizada com sucesso');
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'Atualização com problemas');
			echo json_encode($return);
			return true;
		}
	}
	
	/*
	* editar feriado
	*/
	public function editar_contracto()
	{
		$userid = $this->input->post('Userid');
		$contracto = $this->input->post('Contracto');
		
		$sql_data = array(
	            'Userid'        => $userid,
	            'Contracto'        => $contracto
	        );
	        $result = $this->user_model->update($userid,$sql_data);
	        
	        if($result)
	        {
			$return = array(
				'return' => 'success',
				'message' => 'Atualização realizada com sucesso');
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'Atualização com problemas');
			echo json_encode($return);
			return true;
		}
	}
	
	/*
	* Eliminar feriado
	*/
	public function del_holiday()
	{
		//como só vou usar o model feriado aqui só o vou por a  carregar aqui
		$this->load->model('holiday_model');
		
		$result = $this->holiday_model->deleteholiday($this->input->post('Holidayid'));
		if($result)
	        {
			$return = array(
				'return' => 'success',
				'message' => 'Registo eliminado com sucesso');
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'Occoreu um erro e o registo não foi eliminado');
			echo json_encode($return);
			return true;
		}
	}
	
	/*
	* Adicionar feriado
	*/
	public function add_holiday()
	{
		//como só vou usar o model feriado aqui só o vou por a  carregar aqui
		$this->load->model('holiday_model');
		
		$sql_data = array(
		            'BDate'        	=> $this->input->post('BDate'),
		            'Name'		=> $this->input->post('Name'),
		            'Days'		=> 1		            
		        );
		
		$result = $this->holiday_model->addholiday($sql_data);
		if($result)
	        {
			$Holidayid = $this->db->insert_id();
			$return = array(
				'return' => 'success',
				'Holidayid'  => $Holidayid,
				'message' => 'Feriado inserido com sucesso');
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'O feriado não foi inserida, voltar a tentar');
			echo json_encode($return);
			return true;
		}
	}
	
	/*
	* pagina view log
	*/
	public function viewlog()
	{
		$this->load->view('v_logs');
	}
	
	/*
	* Para procurar o tipo de log que queremos
	*/
	public function searchlog()
	{
		$this->load->helper('directory');
		$this->load->helper('file');
		
		$map = get_dir_file_info(APPPATH.'logs/');
		
		$datefirst = $this->input->post('datefirst');
		$datesecond = $this->input->post('datesecond');
		$typelog = $this->input->post('Typelog');
		
		//'ERROR' => 1, 'DEBUG' => 2, 'INFO' => 3, 'UTILIZADORES' => 4, 'ALL' => 5
		
		$files_exists = array();
		$searchString = "UTILIZADORES";	
		$message = '<table class="table table-hover logs table-borderless" id="logs"><thead><tr><th>Logs</th></tr></thead>';	
		foreach($map as $file)
		{
			/*if(exec('grep '.escapeshellarg($searchString).' '.$file)) 
                	{
                		array_push($files_exists,$file);
                	}*/
                	if($file['name'] != 'index.html')
                	{
				/*if(strpos(file_get_contents($file),$searchString) !== false) 
	                	{*/
	                	if(strtotime($datefirst) <= $file['date'] && $file['date'] <= strtotime($datesecond . "+1 days"))
	                	{
					//echo file_get_contents($file['server_path']);
					//array_push($files_exists,$file['name']);
					$contentfile = file_get_contents($file['server_path']);
					if($typelog != 'ALL')
					{
						if(strpos($contentfile, $typelog) !== false)
						{
							$handle = fopen($file['server_path'], "r");
							if ($handle) {
							    	while (($line = fgets($handle)) !== false) 
							    	{
							    		if(strpos($line, $typelog) !== false) 
							    		{
										$message .= '<tr><td>'.$line.'</td></tr>';
									}      
							    	}
							    	fclose($handle);
							}else{
								$message .= '<tr><td>Não Conseguiu abrir o ficheiro '.$file['server_path'].'</td></tr>';
							}
						}	
					}else{
						$handle = fopen($file['server_path'], "r");
						if ($handle) {
						    	while (($line = fgets($handle)) !== false) 
						    	{
						    		$message .= '<tr><td>'.$line.'</td></tr>';
						    	}
						    	fclose($handle);
						}else{
							$message .= '<tr><td>Não Conseguiu abrir o ficheiro '.$file['server_path'].'</td></tr>';
						}
					}
				}
			}
		}
		//echo $message;
		$message = $message . '</tbody></table>';
		$return = array(
			'return' => 'success',
			'message' => $message);
		echo json_encode($return);
		return true;
		
	}
	
	/*
	* View page Export to sage
	*/
	public function vexporttosage()
	{
		//tenho que enviar os dpt
		$result = $this->user_model->getAll();
		if($result)
		{
			$data['result'] = $result;
			$this->load->view('v_exporttosage', $data);	
		}else{
			$data['result'] = $result;
			$data['erro'] = 'Problemas na obtenção dos dados, tentar novamente.';
			$this->load->view("v_exporttosage", $data);
		}		
	}
	
	/*
	* Export to sage
	*/
	public function exporttosage()
	{
		$this->load->helper('myfunction_helper');
		
		$firstdate = $this->input->post('datefirst');
		$seconddate = $this->input->post('datesecond');
		$userid  = $this->input->post('Userid');
		
		$result_export = $this->picagem_model->createexportsage($userid,$firstdate,$seconddate);
		//$result_export = true;
		
		if($result_export)
		{
			$return = array(
				'return' => 'success',
				'message' => 'Exportação realizada com sucesso e ficheiro pronto para download'
			);
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'Exportação com problemas'
			);
			echo json_encode($return);
			return true;
		}
	}
}
?>