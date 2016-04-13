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
			$sql = "select * from(select (count(Logid) % 2) as number, Userid, datepart(DAY,CheckTime) as dia, datepart(Month,CheckTime) as mes, datepart(Year,CheckTime) as ano, Name from V_Record where CheckTime between '".$firstdate."' and DATEADD(DAY,1,'".$seconddate."') group by datepart(DAY,CheckTime), Userid, datepart(Month,CheckTime), datepart(Year,CheckTime), Name) d where number = 1";	
		}
		
		//devolve um array
		$result = $this->picagem_model->getpicagens($sql);
		
		if($result)
		{
			$data['result'] = $result;
			$this->load->view("v_home", $data);
		}else{
			$data['error'] = 'Sem Resultados / Verifcar Datas inseridas';
			$this->load->view("v_home", $data);
		}
	}

	public function picagens($iduser,$date)
	{
		$data['id'] = $iduser;
		$data['data'] = $date;
		//$this->load->view("v_picagens", $data);
		echo ($iduser);
	}
}
