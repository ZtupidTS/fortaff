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
				echo 'Atualização realizada com sucesso';
				return true;
			}else{
				echo 'Atualização com problemas';
				return true;
			}
		}
	}
	
	/*
	* Eliminar picagens
	*/
	public function del_picagem()
	{
		
	}
}
?>