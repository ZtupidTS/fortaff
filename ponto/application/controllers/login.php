<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	//level 1: funcionario da loja
	//level 2: admin
	//level 3: chefes
	
	public function index()
	{
		$this->load->view('v_login');
	}
	
	public function entrar(){
		
		$pass = $this->input->post('password');
		$result = $this->user_model->login($this->input->post('number_user'),$pass);
	    	//print_r($result);
	    	if($result)
	    	{
			//aqui é para os chefes visualizar os funcionarios que pretendemos
			$userid_arr = array();
			if($result['Address'] != '' && $result['Address'] != '9999')
			{
				//$arr_temp = array();
				$split_add = explode(',', $result['Address']);
				//print_r($split_add);
				foreach($split_add as $userid)
				{
					$result2 = $this->user_model->get($userid);
					if($result2)
					{
						array_push($userid_arr,array(
								'Userid' => $result2['Userid'],
								'Name' => $result2['Name']
							));
					}
				}
			}
			
			//aqui é para o director ou outro admin
			if($result['Address'] == '9999')
			{
				$result2 = $this->user_model->getAll();
				if($result2)
				{
					foreach($result2->result_array() as $row)
					{
						array_push($userid_arr,array(
							'Userid' => $row['Userid'],
							'Name' => $row['Name']
						));	
					}
				}				
			}
			
			$this->session->set_userdata(array(
	            		'logged' => true,
	            		'user'  => $result['UserCode'],
	            		'user_id' => $result['Userid'],
	            		'nome' => $result['Name'],
	            		'level' => $result['Sex'],
	            		'arr_user' => $userid_arr
	        	));
	        	if($pass == "")
	        	{
				//change pass
				$data['password'] = 'change';
				$this->load->view("v_login",$data);
			}else{
				redirect('home');	
			}
			
		}else{
			// Load View
			//$this->session->set_userdata(array('logged' => false));
	        	$data['erro'] = "Numero e/ou Palavra Passe incorretos";	 
	        	$this->load->view("v_login", $data);
		}
	}
	
	/*
	 * Aqui eu destruo a variável logado na sessão e redireciono para a url base. Como esta variável não existe mais, o usuário
	 * será direcionado novamente para a tela de login.
	 */
	public function logout()
	{
		if($this->session->userdata('user_id') != 12)
		{
			log_message('utilizadores', $this->session->userdata('user_id').' - '.$this->session->userdata('nome').': Saiu');
		}
		$this->session->unset_userdata("logged");
		redirect(base_url());
	}
	
	/*
	*Mudar a pass logo no 1º login
	*/
	public function changepass()
	{
		if($this->input->post('password') != $this->input->post('confirmPassword'))
		{
			$data['password'] = 'change';
			$data['erro'] = "As palavras passe não coincidem";		
			$this->load->view("v_login",$data);
		}else{
			$sql_data = array(
	        	'Telephone'    	=> $this->input->post('password'),
	        	'Sex'		=> '1'
		    	);
			$result = $this->user_model->update($this->session->userdata('user_id'),$sql_data);
			if($result)
			{
				$this->session->set_userdata(array(
		            		'level' => '1'		            		
		        	));
				redirect('home');	
			}else{
				$data['password'] = 'change';
				$data['erro'] = "Problemas na mudança da palavra passe";		
				$this->load->view("v_login",$data);
			}
		}
	}
	
}
?>