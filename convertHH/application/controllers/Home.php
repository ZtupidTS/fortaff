<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('v_home');
	}
	
	public function createplayer()
	{
		$result = $this->All_model->getlimit();
		if($result)
		{
			$data['result'] = $result;
			$this->load->view('v_createplayer', $data);
		}else{
			$data['result'] = $result;
			//isso é para quando vou de ver as picagens para essa pagina de corrigir picagens
			//assim não precido de reescrever outra pagina
			$data['erro'] = 'Problemas na obtenção dos dados, tentar novamente.';	
			$this->load->view("v_createplayer", $data);
		}
	}
	
	public function insertplayer()
	{
		//print_r($this->input->post(NULL,TRUE));		
		$nickname = $this->input->post('nickname');
		$dateexpire = $this->input->post('dateexpire');
		$email = $this->input->post('email');
		$checkbox = $this->input->post('checkbox');
		$limitplay = $this->input->post('limit_play');
		$limitplay2 = $this->input->post('limit_play2');
		$skype = $this->input->post('skype');
		$path = $this->input->post('path');
		
		if($limitplay2 == "0")
			$limitplay2 = "15";
			
		if($limitplay == "0")
			$limitplay = "15";		
		
		$sql_data = array(
		            'nick_player'        	=> $nickname,
		            'limit_play'		=> $limitplay,
		            'limit_play2'		=> $limitplay2,
		            'expire_date'		=> $dateexpire,
		            'email'		=> $email,
		            'skype'		=> $skype,
		            'pathfolder'	=> $path,
		            'enable'		=> $checkbox	            
		        );
		
		$result = $this->All_model->addPlayer($sql_data);
		
		if($result)
	        {
			//$Logid = $this->db->insert_id();
			$return = array(
				'return' => 'success',
				//'Logid'  => $Logid,
				'message' => 'Player inserido com sucesso');
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'O Player não foi inserido, voltar a tentar');
			echo json_encode($return);
			return true;
		}
	}

	public function viewmodifyplayer()
	{
		$result = $this->All_model->getlimit();
		$result2 = $this->All_model->getplayers();
		if($result)
		{
			$data['result'] = $result;
			$data['result2'] = $result2;
			$this->load->view('v_modifyplayer', $data);
		}else{
			$data['result'] = $result;
			//isso é para quando vou de ver as picagens para essa pagina de corrigir picagens
			//assim não precido de reescrever outra pagina
			$data['erro'] = 'Problemas na obtenção dos dados, tentar novamente.';	
			$this->load->view("v_modifyplayer", $data);
		}
	}

	public function getplayer()
	{
		$id_player = $this->input->post('id_player');
		$result = $this->All_model->getplayer($id_player);
		//print_r($result);
		if($result)
	        {
			//$Logid = $this->db->insert_id();
			$return = array(
				'return' => 'success',
				'nick_player' => $result[0]['nick_player'],
				'limit_play' => $result[0]['limit_play'],
				'limit_play2' => $result[0]['limit_play2'],
				'pathfolder' => $result[0]['pathfolder'],
				'expire_date' => $result[0]['expire_date'],
				'email' => $result[0]['email'],
				'skype' => $result[0]['skype'],
				'enable' => $result[0]['enable']
				);
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'Não foi possível obter o player');
			echo json_encode($return);
			return true;
		}
	}

	public function modifyplayer()
	{
		//print_r($this->input->post(NULL,TRUE));		
		$nickname = $this->input->post('nickname2');
		$dateexpire = $this->input->post('expire_date');
		$email = $this->input->post('email');
		$checkbox = $this->input->post('checkbox');
		$limitplay = $this->input->post('limit_play');
		$limitplay2 = $this->input->post('limit_play2');
		$skype = $this->input->post('skype');
		$path = $this->input->post('pathfolder');
		$id = $this->input->post('id');
		
		if($limitplay2 == "0")
			$limitplay2 = "15";
			
		if($limitplay == "0")
			$limitplay = "15";		
		
		$sql_data = array(
		            'nick_player'        	=> $nickname,
		            'limit_play'		=> $limitplay,
		            'limit_play2'		=> $limitplay2,
		            'expire_date'		=> $dateexpire,
		            'email'		=> $email,
		            'skype'		=> $skype,
		            'pathfolder'	=> $path,
		            'enable'		=> $checkbox	            
		        );
		
		$result = $this->All_model->modifyplayer($sql_data,$id);
		
		if($result)
	        {
			//$Logid = $this->db->insert_id();
			$return = array(
				'return' => 'success',
				//'Logid'  => $Logid,
				'message' => 'Player atualizado com sucesso');
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'O Player não foi atualizado, voltar a tentar');
			echo json_encode($return);
			return true;
		}
	}
}