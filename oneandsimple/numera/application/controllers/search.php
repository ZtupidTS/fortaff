<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Search extends MY_Controller {
	/**
	* @ Function Name	: class constructor
	* @ Function Purpose 	: constructor function for class to load default files
	* @ Function Returns	: 
	*/
    
    public function __construct() {
        parent::__construct();
        $this->_userdata = $this->session->userdata('loggedInUser');
        $this->load->model("usermodel");
	$this->load->helper('language');
	//$this->load->helper('googledrive');
	
	//$this->load->library('googleplus');
    }
    
    /*     * ************* start of public functions ****************** */

    /**
     * @ Function Name		: index
     * @ Function Purpose 	: homepage functionality is written in this
     * @ Function Returns	: 
     */
    public function index()
    {
	
	    if($this->session->userdata('loggedInUser'))
	    {
		$this->data['title'] = $this->lang->line('search_lable');
		$this->data['selected'] = 'searchactive';
		$this->data['user_folders_list']=null;
		$this->data['checkedAdvance']=null;    
    		if($_POST)
		{
		    //pr($_POST);
		    $searchby=null;
		    try {
				/*Search by category*/
				$searchArray['text'] = $this->input->post('searchvalue');
				$searchArray['parentfolderid'] = $this->session->userdata('parentfolderid');
				$type="basic";
				if($this->input->post('checkedadvancesearch'))
				{
				    $this->data['checkedAdvance']='chacked';    
				    $type="advance";
				    $searchArray['title'] = $this->input->post('title');
				    $searchArray['fullText']= $this->input->post('fullText');
				    $searchArray['parents'] = $this->input->post('searchfolderid');
				    $searchArray['mimeType'] = $this->input->post('searchfiletype');
				    
				}
				$client = $this->google_client;	
				$client->setAccessToken($this->session->userdata('accessToken'));
				$service = new Google_DriveService($client);
		
				if($this->session->userdata('userRoleId')=='3')
				{	/*User folder list*/ 
				    $user_folders = $this->usermodel->getUserdocumentbyId();
				    if(isset($user_folders->folderpermissions) && !empty($user_folders->folderpermissions))
				    {
					$user_folders_array=json_decode($user_folders->folderpermissions);
					if(!empty($user_folders_array))
					{
					    foreach($user_folders_array as $ky=>$val)
					    {
						$folderId_array[]=$ky;
					    }
					    /*Get user folder list which allot permissons*/
					    $this->data['user_folders_list_db'] = $this->usermodel->getuserfolderlist($folderId_array);
					    
					    $allfilesarray=$this->data['user_folders_list_db'];
					}
					
				    }
				}
				
				$this->data['user_folders_list'] = searchAllfileFolder($service,$searchArray,$type);
			//	pre($this->data['user_folders_list']);
				//get unique value
				 $searchparerntArray = array();

				foreach($this->data['user_folders_list'] as $sval){
				    foreach($sval->parents as $par){
					if(empty($par->isRoot)){
						$searchparerntArray[] = $par->id;
						break;
					}
				    }		
				    
				}
				
			//	pre($searchparerntArray);

				 $searchparerntArray = array_unique($searchparerntArray);
                  	         $this->data['searchparerntArray'] = $searchparerntArray;	

				
				//pr($this->data['user_folders_list'][$parenkey]);
				//$this->data['user_folders_list']=$this->data['user_folders_list'][$parenkey];
				
				/*Show folders list*/
			    
				
				/*store search file list in session*/
				
				foreach($this->data['user_folders_list'] as $srchkey=>$srchvalue)
				{
				    $filesrcharray[$srchkey]['id']= $srchvalue->id;
				    foreach($srchvalue->parents as $srchPar){
					if(empty($srchPar->isRoot)){
						$filesrcharray[$srchkey]['parentid']= $srchPar->id;
					}
				    }			
				    
				    //$filesrcharray[$srchkey]['title']= $srchvalue->title;
				    $tmparray[]=implode(',',$filesrcharray[$srchkey]);
				}
//pr($tmparray);
				if(isset($tmparray)){
				    $this->data['googlesearchfile']=$tmparray;    
				}
			} catch (Exception $e) {
			    $this->session->set_flashdata('message', '<div class="alert-error">'.$this->lang->line('google_client_not_valid_email').'</div>');
			}
			    $foldersessionarray = $this->session->userdata('userfolderpermissoin');
			    //pr($this->data['user_folders_list_db'] );	
			    foreach($this->data['user_folders_list_db'] as $akey=>$aval)
			    {
				foreach($foldersessionarray as $obkey=>$obval)
				{
				    if($aval['id']==$obkey)
				    {
					$mergray[$akey]=$aval;
					$mergray[$akey][]=$obval;
				    }
				    
				}
			    }
		
		    $this->data['visiblefolders'] = $mergray;
		}

		    $this->load->view('search/index.php',$this->data);
	    }
	    else
	    {
		redirect('/users/login');	
	    }		
    }
    public function uploadfile(){	
	if($_FILES['upld_file'] && $this->input->post('folderid')){
	    
	    try {
		$client = $this->google_client;	
		$client->setAccessToken($this->session->userdata('accessToken'));
		$service = new Google_DriveService($client);
		 
		$folderdetailArray=$this->usermodel->getallfolders($this->input->post('folderid'),'getbyId');
		//pr($folderdetailArray);
		/*$file = new Google_DriveFile();
		$file->setTitle($_FILES['upld_file']['name']);
		$file->setDescription('This is a '.$_FILES['upld_file']['type'].' document');
		$file->setMimeType($_FILES['upld_file']['type']);
		$service->files->insert(
		    $file,
		    array(
			'data' => file_get_contents($_FILES['upld_file']['tmp_name']),
			'mimeType' => $_FILES['upld_file']['type']
		    )
		);*/
		$title=$_FILES['upld_file']['name'];
		$description='This is a '.$_FILES['upld_file']['type'].' document';
		$parentId=$folderdetailArray[0]['googlefolderId'];
		$mimeType=$_FILES['upld_file']['type'];
		$filename=$_FILES['upld_file']['name'];
		$filepath=$_FILES['upld_file']['tmp_name'];
		
		
		
		$file = new Google_DriveFile();
		$file->setTitle($title);
		$file->setDescription($description);
		$file->setMimeType($mimeType);
		
		if ($parentId != null) {
		$parent = new Google_ParentReference();
		$parent->setId($parentId);
		    $file->setParents(array($parent));
		}
		$service->files->insert(
		    $file,
		    array(
			'data' => file_get_contents($filepath),
			'mimeType' => $mimeType
		    )
		);
		//pr($service);
		/*Recent file insert function call*/
		$array=array(
		    'title'	=>$title,
		    'doc_id'	=>'',
		    'doc_type'	=>$mimeType,
		    'folder_id'	=>$parentId,
		    'folder_name'=>'',
		    'user_id'=>$this->session->userdata('userid'),
		    'action_description'=>'File uploading',
		);
		$this->usermodel->saverecentfiles($array);
				
		//insertFile($service, $title, $description, $parentId, $mimeType, $filename,$filepath);
		$this->session->set_flashdata('message', '<div class="alert-success">'.$this->lang->line('file_upload_sucesss').'</div>');
		redirect('users/fileListing/'.$parentId);
	    } catch (Exception $e) {
		pre($e);
		exit;
	       $this->session->set_flashdata('message', '<div class="alert-error">'.$this->lang->line('file_upload_sucesss').'</div>');
	       redirect('users/fileListing/'.$parentId);
	    }
	}
    }
    
}
?>
