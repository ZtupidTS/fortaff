<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Application MY_Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package	CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class MY_Controller extends CI_Controller {
	var $data = array();
	var $google_client;
	protected $_userdata;
	
	/**
	 * @ Function Name	: class constructor
	 * @ Function Purpose 	: constructor function for class to load default files
	 * @ Function Returns	: 
	 */	
	public function __construct() 
    	{
		parent:: __construct();
		//error_reporting(E_ALL);
		
		$current_url = $_SERVER['REQUEST_URI'];
		$this->data['select'] = "home";
		if($this->session->userdata('language')=='portugal'){
			$this->lang->load('portugues', 'portugues');	
		}else {
			$this->lang->load('english', 'english');		
		}
		
		
		
		require_once APPPATH.'third_party/google_drive/google-api-php-client/src/Google_Client.php';
		require_once APPPATH.'third_party/google_drive/google-api-php-client/src/contrib/Google_DriveService.php';
		require_once APPPATH.'third_party/google_drive/google-api-php-client/src/contrib/Google_Oauth2Service.php';
		
		$this->google_client = new Google_Client();
		
		if($_SERVER['HTTP_HOST'] == "localhost"){
		    $url = "http://localhost/numera/admin/getGoogleAccessToken";
		}else {
			$url = "http://www.oneandsimple.com/numera/admin/getGoogleAccessToken";
		}
		
		
		$this->google_client->setRedirectUri($url);
		$this->google_client->setScopes(array('https://www.googleapis.com/auth/drive', 'https://www.googleapis.com/auth/userinfo.email'));
		$this->google_client->setAccessType('offline');
		
		
		if($_SERVER['HTTP_HOST'] == "localhost"){
			$this->google_client->setClientId('127134155723-mro508pbq0a0d8uct5sufsffljocfttq.apps.googleusercontent.com');
			$this->google_client->setClientSecret('HeUe62nXatbPwn73qU52QFzE');
		}
		else{
			$this->google_client->setClientId('449354131456-ufmhbc9fo473psoubq4fske6uacikvtn.apps.googleusercontent.com');
			$this->google_client->setClientSecret('dYL0C5dhv8WUIo1Ui3p9FxHg');
		}
		
		// FRONT

		if(!strpos($current_url,'admin')){
			
			global $options;
			
			$this->data = array();
			$this->load->helper(array('form', 'email','cookie','googledrive'));
			$this->load->library(array('form_validation', 'email','encrypt'));
			$this->form_validation->set_error_delimiters('<div id="diverror">','</div>');
			
			if($this->session->userdata('loggedInUser')){
				$this->get_google_accesstoken();	
			}
			
			$this->data['unread_notification'] = $this->getUnreadNotification($this->session->userdata('userid'));
		}
		if(strpos($current_url,'admin')){
			$this->data = array();
			$this->load->helper(array('form', 'email','googledrive','common','cookie'));
			$this->load->model('adminmodel');
			$this->load->library(array('form_validation', 'email','encrypt'));
			$this->form_validation->set_error_delimiters('<div id="diverror">','</div>');
			
			
			
		}
		// Sections to print with profiler
		$sections = array(
			'queries' 		=> TRUE,
			'benchmarks' 		=> FALSE,
			'config' 		=> FALSE,
			'controller_info' 	=> FALSE,
			'get'			=> FALSE,
			'http_headers'		=> FALSE,
			'memory_usage'		=> TRUE,
			'post'			=> FALSE,
			'uri_string' 		=> FALSE
		);
		$this->output->set_profiler_sections($sections);
		$this->output->enable_profiler(FALSE);
		
		
		
		
		
	}
	private function get_google_accesstoken(){
	
		$sess_refrest_tkn = $this->session->userdata('sess_refresh_token');
		
		if(!empty($sess_refrest_tkn)){
			$client = $this->google_client;	
			try {
				$client->refreshToken($sess_refrest_tkn);
				$this->session->set_userdata('accessToken',$client->getAccessToken());
				//redirect("users/alldocs");	
			} catch (Exception $e) {

				var_dump($e);exit;	
			}	
		}
		
		
	}
   public function getUnreadNotification($userid) { 
        $this->load->model('usermodel');
        //get unread notification of login user
        $notification_count = $this->usermodel->getNotificationCountByUserid($userid);
        return $notification_count;
    }
}
?>
