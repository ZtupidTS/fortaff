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
	
	public function resumo()
	{
		//tenho que enviar os dpt
		$result = $this->picagem_model->getDpt();
		if($result)
		{
			$data['result'] = $result;
			$this->load->view('v_resumopicagens', $data);	
		}else{
			
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
		
		if(!$iduser)
		{
			//nessa query só vou buscar o numero impares para saber onde falta picagens
			$sql = "select * from(select (count(Logid) % 2) as odd, count(Logid) as number, Userid, datepart(DAY,CheckTime) as dia, FORMAT(datepart(Month,CheckTime),'00') as mes, datepart(Year,CheckTime) as ano, Name from V_Record where CheckTime between '".$firstdate."' and DATEADD(DAY,1,'".$seconddate."') group by datepart(DAY,CheckTime), Userid, datepart(Month,CheckTime), datepart(Year,CheckTime), Name) d where odd = 1";	
		}
		
		//devolve um array
		$result = $this->picagem_model->getpicagens($sql);
		
		if($result)
		{
			$data['result'] = $result;
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
			$data['erro'] = 'Problemas na obtenção dos dados, tentar novamente.';
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
		$newpicagem = $this->input->post('datapicagem').' '.$this->input->post('novapicagem').'.000';
		
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
			$message = '<table class="table table-hover picagens display" id="picagens"><thead><tr><th>Nº</th><th>Nome</th><th>Dias Trab.</th><th>Horas Trab.</th><th>Pausas Trab.</th><th>Horas Dom.</th><th>P. Horas Dom.</th><th>Horas Fer.</th><th>P. Horas Fer.</th><th>Horas Not.</th></tr></thead><tbody>';
			foreach($result as $row)
			{
				if($row['Name'] == 'Total')
				{
					$message = $message . '<tr><td><b>'.$row['Userid'].'</b></td><td><b>'.$row['Name'].'</b></td><td><b>'.$row['Dias'].'</b></td><td><b>'.$row['HTrabalhadas'].'</b></td></td><td><b>'.$row['HPTrab'].'</b></td><td><b>'.$row['Hdomingo'].'</b></td><td><b>'.$row['HPdomingo'].'</b></td><td><b>'.$row['Hferiado'].'</b></td><td><b>'.$row['HPferiado'].'</b></td><td><b>'.$row['HNoturnas'].'</b></td></tr>';
				}else{
					$message = $message . '<tr><td>'.$row['Userid'].'</td><td>'.$row['Name'].'</td><td>'.$row['Dias'].'</td><td>'.$row['HTrabalhadas'].'</td><td>'.$row['HPTrab'].'</td><td>'.$row['Hdomingo'].'</td><td>'.$row['HPdomingo'].'</td><td>'.$row['Hferiado'].'</td><td>'.$row['HPferiado'].'</td><td>'.$row['HNoturnas'].'</td></tr>';	
				}
			}
			$message = $message . '</tbody></table>';
			
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
}
?>