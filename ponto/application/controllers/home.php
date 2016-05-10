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
		$this->load->view('v_home');
	}
	
	/*
	* Paras consultar o resumo das horas referente as picagens
	*/
	public function resumo()
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
					$message_return = viewPicagens($firstdate,$seconddate,$result);
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
		
		$result = $this->picagem_model->picagensbyuser($userid,$firstdate,$seconddate);
		
		if($result)
		{
			$message_tb_head = '<table class="table table-hover picagens table-borderless" id="picagens1"><thead><tr><th>Dia</th><th colspan="12">Picagens</th></tr></thead>';
				
			$message = viewPicagens($firstdate,$seconddate,$result);
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
}
?>