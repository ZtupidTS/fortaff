<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	//level 1: utilizador Normal da loja
	//level 2: utilizador admin
	
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
			$this->session->set_userdata(array(
	            		'logged' => true,
	            		'user'  => $result['UserCode'],
	            		'user_id' => $result['Userid'],
	            		'level' => $result['Sex']
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
	public function logout(){
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