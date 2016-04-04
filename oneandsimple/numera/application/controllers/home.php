<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	var $menu;
	public function index()
	{
		
		if($this->session->userdata('loggedIn'))
		{
			$this->session->set_userdata('loggedIn',true);
			$this->load->view('/home/index');
			
		}else{
			//$this->load->view('user/login');
			redirect('user/');
		}		
	}
	
	public function aboutus()
	{
		
		$this->menu=5;
		$this->load->view('aboutus');
	}
	
	public function logout(){
		$this->session->sess_destroy();	
		redirect('login');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */