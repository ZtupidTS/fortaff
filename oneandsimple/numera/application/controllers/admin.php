<?php
//error_reporting(-1);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends MY_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public $options = '';
    public $levelStr = '';

    public function index() {
        if ($this->session->userdata('loggedInAdmin')) {
            redirect('admin/dashboard');
        }
        $data['title'] = "Admin Login";
        $this->load->model('adminmodel');

        $this->form_validation->set_rules('username', 'Username', 'required|callback_username_check');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/index', $data);
        } else {
            //print_r($_POST);die;
            if (isset($_POST) && (!empty($_POST))) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $chkRememberMe = $this->input->post('chk_remember_me');
                $chkRememberMe = $chkRememberMe == 'on' ? true : false;

                $data['adminDetail'] = $this->adminmodel->getLoginResult($username, md5($password));
                if ($data['adminDetail']) {
                    if (isset($data['adminDetail']['id'])) {
                        $data = array(
                            'id' => $data['adminDetail']['id'],
                            'admin_name' => $data['adminDetail']['userName'],
                            'loggedInAdmin' => TRUE,
                            'admin_email' => $data['adminDetail']['userEmail']
                        );
                        $this->session->set_userdata($data);
                    }
                    //setting user credential in cookies
                    if ($chkRememberMe === true) {
                        $this->input->set_cookie('admin_name', $username, '86500', '', '/', '');
                        $this->input->set_cookie('admin_pass', $password, '86500', '', '/', '');
                    } else if ($chkRememberMe === false) {
                        $this->input->set_cookie('admin_name', '', '86500', '', '/', '');
                        $this->input->set_cookie('admin_pass', '', '86500', '', '/', '');
                    }

                    /* Call function */
                    //$this->checkfolderIsexistorNot();

                    redirect('admin/dashboard');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert-error">username and password not exsit.</div>');
                    $this->load->view('admin/index.php', $data);
                }
            } else {
                $this->load->view('admin/', $data);
            }
        }
    }

    public function checkfolderIsexistorNot() {

        $allfolders = $this->adminmodel->getallfolders(null, null);

        $tokenArray = $this->adminmodel->getAllrefreshToken();
        //pr($tokenArray);

        foreach ($tokenArray as $tval) {
            /* Verify google client */
            $accessToken = $this->get_admin_google_accesstoken($tval['refreshToken']);
            $client = $this->google_client;
            $service = new Google_DriveService($client);
            $allgooglefolders[] = retrieveAllFiles($service);
        }

        //foreach($allgooglefolders as $googleFolderval)
        //{
        //foreach($googleFolderval as $fval)
        //{
        //$all_google_folder[]=$fval;
        //$all_google_folder[]=$googleFolderval;
        //}
        //}
        //pr($allgooglefolders);
    }

    function username_check($str) {
        $this->load->model('adminmodel');
        @$data['users'] = $this->adminmodel->checkUserexist($str);
        if ($str != @$data['users']['userName']) {
            $this->form_validation->set_message('username_check', 'The %s field entered is not correct');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function dashboard() {
        isAdminAuthorize(); /* checkedis admin login or not */
        if (!$this->session->userdata('loggedInAdmin'))
            redirect('admin');
        $data['title'] = 'Dashboard';
        $data['menu'] = '1';
        $this->load->model('adminmodel');
        $data['users']['noofclint'] = $this->adminmodel->totolNumberofuser('2', null);
        $data['users']['noofuser'] = $this->adminmodel->totolNumberofuser('3', null);

        //$this->checkfolderIsexistorNot();
        //print_r($data);
        $this->load->view('admin/dashboard', $data);
    }

    function logout() {
        $this->session->sess_destroy();
        redirect('admin', 'refresh');
    }

    function forgotepassword() {
        $data['title'] = 'Forgote password';
        $this->load->model('adminmodel');
        $this->form_validation->set_rules('email', 'Email', 'required|callback_userEmail_check');
        if ($this->form_validation->run() == false) {
            $this->load->view('admin/forgotepassword', $data);
        } else {
            $useremail = $this->input->post('userEmail');
            //die($this->form_validation->run());
            $userdetail = $this->adminmodel->checkusremail($useremail);
            $username = $userdetail['userName'];
            $userId = $userdetail['id'];
            $newuserpassword = str_rand();
            $getresult = $this->adminmodel->updatepassword($userId, md5($newuserpassword));
            //die($newuserpassword);
            if ($getresult) {
                //Send email body
                $from = $this->config->item('adminEmail');
                $to = $userdetail['userEmail'];
                $name = $userdetail['userName'];
                $password = $newuserpassword;
                $siteURL = NUMERA_SITE;
                $subject = " Password Recovery";
                $message = '';
                $message .='<tr>
						<td bgcolor="#951118" style="font-family:segoe UI, Arial, sans-serif; font-size:13px; color:#FFF; padding:6px 10px;">
						   <font style="font-size:15px;">' . $subject . '</font>
						</td>
					    </tr>';
                $message .= '<tr>';
                $message .= '<td valign="top" bgcolor="#ffffff" style="padding:12px;">
						      <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							    <td height="26" style="font-family:Tahoma, Arial, sans-serif; font-size:11px;color:#575757;">
								<strong>Hi Administrator,</strong>
							    </td>
							</tr>
							<tr>
							    <td style="font-family:Tahoma, Arial, sans-serif; font-size:11px; color:#575757; line-height:15px; padding-bottom:10px;">
							    You will find your login data below. Please keep this information secure & safe.
							    </td>
							</tr>';
                $message .='<tr>
							<td height="5">
							</td>
						    </tr>
						    <tr>
							<td align="left">
							    <table width="287" border="0" bgcolor="#D23D3D" cellspacing="1" cellpadding="6" style="border:solid 3px #D23D3D;">
								<tr>
								    <td colspan="2">
									<strong style="color:#FFF;">Login Information</strong>
								    </td>
								</tr>
								<tr>';
                $message .= '<td bgcolor="#ffffff" width="100"><strong>Username</strong></td>';
                $message .= '<td width="270" bgcolor="#ffffff">' . @$name . '</td>';
                $message .= '</tr>';
                $message .= '<tr>';
                $message .= '<td  bgcolor="#ffffff"><strong>Password</strong></td>';
                $message .= '<td  bgcolor="#ffffff">' . @$password . '</td>';
                $message .= '</tr>';
                $message .='</table>';
                $message .='</td>
							</tr>
							<tr>
							    <td height="25">&nbsp;</td>
							</tr>
							<tr>';
                $message .='<td>
						    </td>
						</tr>
						<tr>
						    <td height="25"></td>
						</tr>
						<tr style="color:black;">
			
						';
                $message .= '<td>Regards,<br />';
                $message .= '<a href="' . NUMERA_SITE . '">' . $this->config->item('siteName') . '</a><br />';
                $message .= '</td></tr>';
                $message .= '</table>';
                $message .= '</tr>';
                $body = getNotificationTheme($siteURL . ' Password Recovery.', $message, '');
                $this->email->from($from);
                $this->email->to($to);
                $this->email->subject($siteURL . ' Password Recovery.');
                $this->email->message($body);
                $this->email->set_mailtype('html');
                //pr($body);
                $this->email->send();
                $this->session->set_flashdata('message', '<div class="alert-success">New password has been sent on email.</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert-error">Email is not send, try again!</div>');
            }
            redirect('admin/forgotepassword', 'refresh');
            //$this->load->view('admin/forgotepassword',$data);
        }
    }

    function userEmail_check($str) {
        $this->load->model('adminmodel');
        @$data['users'] = $this->adminmodel->checkusremail($str);
        if ($str != @$data['users']['userEmail']) {
            $this->form_validation->set_message('userEmail_check', 'The %s field you have entered is not correct');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function changepassword() {
        isAdminAuthorize(); /* checked is admin login or not */
        if (!$this->session->userdata('loggedInAdmin'))
            redirect('admin');
        $this->load->model('adminmodel');
        $this->form_validation->set_rules('userPassword', 'password', 'required|callback_currentpwd_check');
        $this->form_validation->set_rules('newuserPassword', 'New Password', 'required|callback_newpassword_check');
        $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required');

        if ($this->form_validation->run() == false) {
            $data['menu'] = '6';
            $this->load->view('admin/changepassword', $data);
        } else {
            $uid = $this->session->userdata('id');
            $getuserDetails = $this->adminmodel->getuserDetail($uid, $roleid = '1');
            $username = $getuserDetails['userName'];
            $useremail = $getuserDetails['userEmail'];
            $newuserpwd = $this->input->post('newuserPassword');
            /* update password */
            $getresult = $this->adminmodel->updatepassword($uid, md5($newuserpwd));
            //die();
            if ($getresult) {
                //print_r($userdetail);
                $to = $useremail;
                $subject = 'Change password notification';

                $data = 'Hello' . $username . ',<br/> Your new password is <b>' . $newuserpwd . '</b><br/>Regards <br/>Oneandsimple';
                /* Call function */
                //send_mail($to,$subject,$data);
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'oneandsimple76@gmail.com',
                    'smtp_pass' => 'oneandsimple76123456',
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1'
                );
                $this->load->library('email', $config);
                $this->email->from('oneandsimple76@gmail.com', 'oneandsimple');
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($this->load->view('emails/message', $data, true));
                $this->email->send();
                $this->session->set_flashdata('message', '<div class="alert-success">Password has been change successfully. </div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert-error">Your password is not change, please try again!</div>');
            }
            //echo $this->email->print_debugger();			
            redirect('admin/changepassword', 'refresh');
            //$this->load->view('admin/changepassword');			
        }
    }

    function currentpwd_check($str) {
        $this->load->model('adminmodel');
        $uid = $this->session->userdata('loggedInAdmin');
        @$data['users'] = $this->adminmodel->checkusrpwdxist(md5($str), $uid);
        //print_r($data['users']);
        if (md5($str) != @$data['users']['userPassword']) {
            $this->form_validation->set_message('currentpwd_check', 'The current %s you have entered is not correct');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function newpassword_check($str) {

        if ($str != $this->input->post('confirmPassword')) {
            $this->form_validation->set_message('newpassword_check', 'The %s and confirm password does not match.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function editprofile() {
        isAdminAuthorize(); /* checked is admin login or not */
        $data['title'] = 'My profile';
        $this->load->model('adminmodel');
        if (!$this->session->userdata('loggedInAdmin'))
            redirect('admin');
        $data['menu'] = '7';
        if ($this->session->userdata('loggedInAdmin')) {
            $id = $this->session->userdata('id');
            $data['adminDetails'] = $this->adminmodel->getuserDetail($id, $roleid = '1');
            $this->load->view('admin/profile', $data);
        }
    }

    /* Add New user under the client */

    function adduser($clientId = null, $userId = null) {
        isAdminAuthorize(); /* checked is admin login or not */
        $this->load->model('adminmodel');
        $data['menu'] = '2';
        if ($this->session->userdata('loggedInAdmin')) {
            $data['userId'] = $clientId;

            /* Get All Client List */
            $data['clientlist'] = $this->adminmodel->totolNumberofuser('2', 'client');

            /* Permission code here */
            $data['results'] = $this->adminmodel->getallpermissions(null);
            //pr($data['results']);
            if ($userId) {
                $data['title'] = 'Edit user';
                $data['userDetail'] = $this->adminmodel->getuserFullDetail($clientId, $roleid = '3');
                //pr($data['userDetail']);
                if ($data['userDetail']['id']) {
                    $data['userId'] = $data['userDetail']['userId'];
                }

                /* Get client Folder list */
                $data['folders'] = $this->adminmodel->getallfolders($data['userDetail']['clientId'], 'getbychildefolder');
                //pr($data['folders']);
                /* Get only user permission List */
                //$data['userpermissions'] = $this->adminmodel->getuserpermissions($clientId);
                /* Decode Client selected file permissions */
                /* if(isset($data['userpermissions']['permissionId']) && !empty($data['userpermissions']['permissionId'])){
                  $userpermissionAry = json_decode($data['userpermissions']['permissionId']);
                  foreach($userpermissionAry as $ky=>$val)
                  {
                  $arraykey[$ky]=$userpermissionAry->$ky;
                  }
                  $data['select_usr_permission']=$arraykey;
                  } */

                /* Get only Client Folder selected permission List */
                $data['folderpermissions_array'] = $this->adminmodel->getclientfolderPermission($clientId);

                $folderarraykey = array();

                if (isset($data['folderpermissions_array']['folderpermissions']) && !empty($data['folderpermissions_array']['folderpermissions'])) {
                    $folderpermissionAry = json_decode($data['folderpermissions_array']['folderpermissions']);
                    foreach ($folderpermissionAry as $ky => $val) {
                        $folderarraykey[$ky] = $folderpermissionAry->$ky;
                    }

                    $data['select_client_folder_permission'] = $folderarraykey;
                }
            }
            //pre($data['select_client_folder_permission']);
            else {
                $data['title'] = 'Add user';
            }
            if ($this->form_validation->run() == false) {
                $this->load->view('admin/manageuser', $data);
            }
        } else {
            redirect('admin/');
        }
    }

    public function manageuser($clientId = null, $id = null) {
        isAdminAuthorize(); /* checked is admin login or not */
        $data['menu'] = '2';
        $this->load->model('adminmodel');
        if ($this->uri->segment(4) || $this->input->post('id')) /* Get existing client details */ {
            $data['title'] = 'Edit User';
        } else {
            $data['title'] = 'Add User';
            $id = '';
        }
        if ($this->input->post('btnsubmit')) {
            $id = $this->input->post('id');
            $data['userId'] = $clientId;
            if (!$this->input->post('id')) {
                $this->form_validation->set_rules('userPassword', 'Password', 'required|min_length[8]|max_length[200]');
                $this->form_validation->set_rules('userEmail', 'Email', 'required|email|valid_email');
                $this->form_validation->set_rules('userName', 'User name', 'required|min_length[3]|max_length[200]|is_unique[users.userName]');
            } else {
                $this->form_validation->set_rules('userEmail', 'Email', 'required|email|valid_email');
                $this->form_validation->set_rules('userName', 'User name', 'required|min_length[3]|max_length[200]');
            }
            $this->form_validation->set_rules('userlanguage', 'Language', 'required');
            $this->form_validation->set_rules('fname', 'First name', 'required|min_length[3]|max_length[25]');
            $this->form_validation->set_rules('lname', 'Last Name', 'required|min_length[3]|max_length[25]');
            $this->form_validation->set_rules('profession', 'Profession', 'required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('userPhone', 'Phone', 'required|integer');

            if ($this->form_validation->run() == false) {
                $data['clientId'] = $this->input->post('clientid');
                if (!$this->input->post('id')) {
                    $data['userDetail']['userPassword'] = $this->input->post('password');
                }
                $data['userDetail']['userlanguage'] = $this->input->post('userlanguage');
                $data['userDetail']['userEmail'] = $this->input->post('email');
                $data['userDetail']['userImage'] = $this->input->post('image');
                $data['userDetail']['clientId'] = $this->input->post('clientid');
                $data['userDetail']['fname'] = $this->input->post('fname');
                $data['userDetail']['lname'] = $this->input->post('lname');
                $data['userDetail']['profession'] = $this->input->post('profession');
                $data['upload_error'] = "";

                /* Get All Client List */
                $data['clientlist'] = $this->adminmodel->totolNumberofuser('2', 'client');

                /* Get All Defualt Folder list */
                $data['folders'] = $this->adminmodel->getallfolders(null, null);

                /* Permission code here */
                $data['results'] = $this->adminmodel->getallpermissions(null);
                //pr($data['results']);

                $this->load->view('admin/manageuser', $data);
                //redirect("admin/adduser/$clientId/$id");
            } else {
                /* Send email to user */
                $error = $this->adminmodel->saveUser($task = 'user');
                if ($error) {
                    /* Set language */
                    if ($this->input->post('userlanguage') == 'portugal') {
                        $this->lang->load('portugues', 'portugues');
                    } else {
                        $this->lang->load('english', 'english');
                    }

                    /* message */
                    /* Send email to user */
                    if ($id == null && $this->input->post('userPassword') != null) {
                        $this->_sendWelcomeMail($type = "user");
                    } elseif ($id != null && $this->input->post('newuserPassword') != null) {
                        //die($this->input->post('newuserPassword'));die;
                        $this->_sendchangepwdMail($type = "user");
                    }

                    if ($error == 'add') {
                        $this->session->set_flashdata('message', '<div class="alert-success">User add successfully.</div>');
                    } elseif ($error == 'update') {
                        $this->session->set_flashdata('message', '<div class="alert-success">User Updated successfully </div>');
                    }
                    /* redirect */
                    if ($task == 'user') {
                        redirect('admin/users');
                    } else {
                        redirect('admin/users');
                    }
                } else {
                    $data['users']['userPassword'] = $this->input->post('password');
                    $data['users']['userEmail'] = $this->input->post('email');
                    $data['users']['userImage'] = $this->input->post('image');
                    $data['clientId'] = $this->input->post('clientid');
                    $data['users']['fname'] = $this->input->post('clientid');
                    $data['users']['fname'] = $this->input->post('fname');
                    $data['users']['lname'] = $this->input->post('lname');
                    $data['users']['profession'] = $this->input->post('profession');
                    $data['upload_error'] = $error['error'];
                    $this->session->set_flashdata('message', '<div class="alert-error">User not added, Try Again!.</div>');
                    redirect("admin/adduser/$clientId/$id");
                }
            }
        } else {
            redirect("admin/adduser/$clientId");
        }
    }

    /* Save user */

    function manageadmin($task = null) {
        isAdminAuthorize(); /* checked is admin login or not */
        $data['menu'] = '3';
        $this->load->model('adminmodel');
        if ($this->session->userdata('loggedInAdmin')) {
            $this->form_validation->set_rules('userName', 'User Name', 'required|min_length[5]');
            $this->form_validation->set_rules('userEmail', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('userPhone', 'Phone', 'integer|integer|min_length[10]|max_length[15]');
            $this->form_validation->set_rules('adminFooterTxt', 'Footer text', 'required');
            if ($this->form_validation->run() == false) {

                //$data['user']['id'] = $this->session->userdata('id');
                $data['user']['userName'] = $this->input->post('userName');
                $data['user']['userEmail'] = $this->input->post('userEmail');
                $data['user']['userPhone'] = $this->input->post('userPhone');
                redirect('admin/editprofile');
                //$this->load->view('admin/profile',$data);
            } else {

                $error = $this->adminmodel->saveUser($task = 'admin');
                if ($error == 'update') {
                    $this->session->set_flashdata('message', '<div class="alert-success">Profile has been updated successfully.</div>');
                    redirect('admin/editprofile');
                } else {
                    $data['user']['id'] = $this->input->post('id');
                    $data['user']['userName'] = $this->input->post('userName');
                    $data['user']['userEmail'] = $this->input->post('userEmail');
                    $data['user']['userPhone'] = $this->input->post('userPhone');
                    if ($this->input->post('userImage')) {
                        $data['user']['userImage'] = $this->input->post('userImage');
                    }
                    $data['upload_error'] = $error['error'];
                    $this->session->set_flashdata('message', '<div class="alert-success">Profile not updated, Try Again!.</div>');
                    redirect('admin/editprofile');
                }
            }
        } else {
            redirect('admin');
        }
    }

    /* List of All user under the all client */
    /* List of All client */

    function users() {
        isAdminAuthorize(); /* checked is admin login or not */
        $this->load->library("pagination");
        $this->load->model('adminmodel');
        //page title
        $data['title'] = 'Users';
        $data['menu'] = '2';
        //pagination configurations
        $data['total_row'] = $this->adminmodel->getUserlist($uclientid = null, $type = 'users', null, null);

        $config['total_rows'] = count($data['total_row']);
        $config['per_page'] = PER_PAGE_RECORD; /* DEFINE IN CONFIG/CONSTAANT.PHP */;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';

        //get all the URI segments for pagination and sorting
        $segment_array = $this->uri->segment_array();
        $segment_count = $this->uri->total_segments();

        //for ordering the data items
        $do_orderby = array_search("orderby", $segment_array);

        //asc and desc sorting
        $asc = array_search("asc", $segment_array);
        $desc = array_search("desc", $segment_array);

        //get the records
        if ($this->uri->segment($do_orderby + 1) == 'admin') {
            $sortby = 'id';
        } else {
            $sortby = $this->uri->segment($do_orderby + 1);
        }

        $this->db->order_by($sortby, $this->uri->segment($do_orderby + 2));

        //getting the records and limit setting
        if (ctype_digit($segment_array[$segment_count])) {

            $data['page'] = $segment_array[$segment_count];
            $page = $segment_array[$segment_count];
            $this->db->limit($config['per_page'], $segment_array[$segment_count]);
            array_pop($segment_array);
        } else {
            $page = null;
            $data['page'] = NULL;
            $this->db->limit($config['per_page']);
        }

        $config['base_url'] = site_url(join("/", $segment_array));
        $config['uri_segment'] = count($segment_array) + 1;

        //initialize pagination
        $this->pagination->initialize($config);
        $data['results'] = $this->adminmodel->getUserlist($uclientid = null, $type = 'users', $config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        //load the view
        $this->load->view('admin/users', $data);
    }

    /* List of All client */

    function clients() {
        isAdminAuthorize(); /* checked is admin login or not */
        $this->load->library("pagination");
        $this->load->model('adminmodel');
        //page title
        $data['title'] = 'Client list';
        $data['menu'] = '4';
        //pagination configurations

        $data['total_row'] = $this->adminmodel->getUserlist($uclientid = null, $type = 'client', null, null);
        //die('dd');
        $config['total_rows'] = count($data['total_row']);
        $config['per_page'] = PER_PAGE_RECORD; /* DEFINE IN CONFIG/CONSTAANT.PHP */;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';

        //get all the URI segments for pagination and sorting
        $segment_array = $this->uri->segment_array();
        $segment_count = $this->uri->total_segments();

        //for ordering the data items
        $do_orderby = array_search("orderby", $segment_array);

        //asc and desc sorting
        $asc = array_search("asc", $segment_array);
        $desc = array_search("desc", $segment_array);

        //get the records
        if ($this->uri->segment($do_orderby + 1) == 'admin') {
            $sortby = 'id';
        } else {
            $sortby = $this->uri->segment($do_orderby + 1);
        }

        $this->db->order_by($sortby, $this->uri->segment($do_orderby + 2));

        //getting the records and limit setting
        if (ctype_digit($segment_array[$segment_count])) {

            $data['page'] = $segment_array[$segment_count];
            $page = $segment_array[$segment_count];
            $this->db->limit($config['per_page'], $segment_array[$segment_count]);
            array_pop($segment_array);
        } else {
            $page = null;
            $data['page'] = NULL;
            $this->db->limit($config['per_page']);
        }

        $config['base_url'] = site_url(join("/", $segment_array));
        $config['uri_segment'] = count($segment_array) + 1;

        //initialize pagination
        $this->pagination->initialize($config);
        $data['results'] = $this->adminmodel->getUserlist($uclientid = null, $type = 'client', $config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        //pre($data['results']);
        //load the view
        $this->load->view('admin/clients', $data);
    }

    function addclient($id = null) {

        isAdminAuthorize(); /* checked is admin login or not */
        $data['menu'] = 4;
        $this->load->model('adminmodel');
        if ($id) {
            $data['title'] = 'Edit Client';
            $data['clientDetail'] = $this->adminmodel->getuserDetail($id, $roleid = '2');

            if (@$data['clientDetail']['id']) {
                $data['clientId'] = $data['clientDetail']['id'];
            } else {
                $data['clientId'] = '';
            }
            /* Get more client_details tables */
            $data['clientDetail']['moredetails'] = $this->adminmodel->getclientDetail($data['clientId']);
            //pr($data['clientDetail']);
            @$data['clientDetail']['companyName'] = $data['clientDetail']['moredetails']['companyName'];
            @$data['clientDetail']['accountManager'] = $data['clientDetail']['moredetails']['accountManager'];
            @$data['clientDetail']['clientAddress'] = $data['clientDetail']['moredetails']['clientAddress'];
            @$data['clientDetail']['googleemail'] = $data['clientDetail']['moredetails']['email'];

            /* Get Individual Client Contact person List */
            $data['contact_person_detail'] = $this->adminmodel->getcontact_person_detail($data['clientDetail']['moredetails']['id']);
            //pre($data['contact_person_detail']);

            /* Get Individual Clinet Service List */
            $data['client_service_list_detail'] = $this->adminmodel->getclient_service_detail($data['clientDetail']['moredetails']['id']);
            //pre($data['contact_person_detail']);
        } else {
            $data['title'] = 'Add Client';
        }
        /* Get All Defualt Folder list */
        $data['folders'] = $this->adminmodel->getallfolders(null, null);

        /* Permission code here */
        $data['results'] = $this->adminmodel->getallpermissions(null);
        //pr($data['results']);

        /* Get only user permission List */
        $data['userpermissions'] = $this->adminmodel->getuserpermissions($id);

        /* Decode Client selected file permissions */
        if ($data['userpermissions']) {
            $userpermissionAry = json_decode($data['userpermissions']['permissionId']);
            foreach ($userpermissionAry as $ky => $val) {
                $arraykey[$ky] = $userpermissionAry->$ky;
            }
            $data['select_usr_permission'] = $arraykey;
        }

        /* Get only Client Folder selected permission List */
        $data['folderpermissions_array'] = $this->adminmodel->getclientfolderPermission($id);
        if ($data['folderpermissions_array']) {
            $folderpermissionAry = json_decode($data['folderpermissions_array']['folderpermissions']);
            foreach ($folderpermissionAry as $ky => $val) {
                //if($val=='yes'){
                $folderarraykey[$ky] = $folderpermissionAry->$ky;
                //}
            }

            $data['select_client_folder_permission'] = $folderarraykey;
        }
        //pre($data['select_client_folder_permission']);

        if ($this->session->userdata('loggedInAdmin')) {
            if (!empty($data['clientDetail']['id'])) {
                $data['clientId'] = $data['clientDetail']['id'];
            } else {
                $data['clientId'] = '';
            }
            if ($this->form_validation->run() == false) {

                $this->load->view('admin/manageclient', $data);
            }
        }
    }

    public function manageclient($id = null) {


        isAdminAuthorize(); /* checked is admin login or not */
        $this->load->model('adminmodel');

        $data['menu'] = '4';
        if ($this->uri->segment(3) || $this->input->post('id')) /* Get existing client details */ {
            $id = $this->uri->segment(3);
            $data['title'] = 'Edit Client';
            //$this->load->view('admin/manageclient',$data);
        } else {
            $data['title'] = 'Add Client';
            $data['clientId'] = '';
            $id = '';
        }

        if ($this->input->post('btnsubmit')) {

            //pre($_FILES['userImage']['name']);
            //pr($_FILES);
            $id = $this->input->post('id');
            $this->form_validation->set_rules('userName', 'userName', 'required');
            if (!isset($id)) {
                $this->form_validation->set_rules('googlepassword', 'google password', 'required|min_length[5]|max_length[55]');
                $this->form_validation->set_rules('googleemail', 'google email', 'required|email|valid_email|is_unique[google_login_detail.email]');
            } else {
                $this->form_validation->set_rules('googleemail', 'google email', 'required|email|valid_email');
            }
            //else { $this->form_validation->set_rules('googlepassword', 'google password', 'min_length[5]|max_length[55]');} 
            $this->form_validation->set_rules('companyName', 'Company Name', 'required|string');
            //$this->form_validation->set_rules('clientAddress', 'address', 'required');
            $this->form_validation->set_rules('userEmail', 'Email', 'required|email|valid_email');
            $this->form_validation->set_rules('userPhone', 'Phone', 'required|integer|min_length[10]');

            if (!isset($id)) {
                /* Contact person validation */
                $this->form_validation->set_rules('personname', 'Person Name', 'required|min_length[5]');
                $this->form_validation->set_rules('personprofession', 'Profession', 'required|min_length[3]');
                $this->form_validation->set_rules('personemail', 'Email', 'required|valid_email|is_unique[client_contact_persons.email]');
                $this->form_validation->set_rules('personphone', 'Phone', 'required|integer|min_length[10]|max_length[15]');

                /* Client Service validation */
                $this->form_validation->set_rules('serviceName', 'Service Name', 'required|min_length[3]');
                $this->form_validation->set_rules('serviceDescription', 'Description', 'required|min_length[3]');
                $this->form_validation->set_rules('startingDate', 'Starting date', 'required');
                $this->form_validation->set_rules('endingDate', 'Ending date', 'required');
            }
            if ($this->form_validation->run() == false) {
                $data['clientDetail'] = $this->adminmodel->getuserDetail($id, $roleid = '2');
                if (isset($data['clientDetail']['id'])) {
                    $data['clientId'] = $data['clientDetail']['id'];
                } else {
                    $data['clientId'] = '';
                }

                /* Get All Defualt Folder list */
                $data['folders'] = $this->adminmodel->getallfolders($userid = null, null);
                /* Permission code here */
                $data['results'] = $this->adminmodel->getallpermissions($userid = null);
                //pr($data['results']);
                /* Get only user permission List */
                $data['userpermissions'] = $this->adminmodel->getuserpermissions($userid);
                //pr($data['userpermissions']);

                /* Get only Client Folder selected permission List */
                $data['selectedpermissions'] = $this->adminmodel->getclientfolderPermission($userid);

                /* Decode Client selected file permissions */
                if ($data['userpermissions']) {
                    $userpermissionAry = json_decode($data['userpermissions']['permissionId']);
                    foreach ($userpermissionAry as $ky => $val) {
                        //if($val=='yes'){
                        $arraykey[$ky] = $userpermissionAry->$ky;
                        //}
                    }
                    //print_r($arraykey);
                    $data['select_usr_permission'] = $arraykey;
                }

                /* Decode Client selected folder permissions */
                if ($data['selectedpermissions']) {
                    $userpermissionAry = json_decode($data['selectedpermissions']['permissionId']);
                    foreach ($userpermissionAry as $ky => $val) {
                        //if($val=='yes'){
                        $arraykey[$ky] = $userpermissionAry->$ky;
                        //}
                    }
                    //print_r($arraykey);
                    $data['select_client_folder_permission'] = $arraykey;
                }

                /* Get more client_details tables */
                $data['clientDetail']['moredetails'] = $this->adminmodel->getclientDetail($data['clientId']);
                @$data['clientDetail']['companyName'] = $data['clientDetail']['moredetails']['companyName'];
                @$data['clientDetail']['accountManager'] = $data['clientDetail']['moredetails']['accountManager'];
                @$data['clientDetail']['clientAddress'] = $data['clientDetail']['moredetails']['clientAddress'];
                @$data['clientDetail']['googleemail'] = $data['clientDetail']['moredetails']['email'];

                //@$data['contact_person_detail']['googleemail']=$data['contact_person_detail']['moredetails']['email'];

                $data['upload_error'] = "";
                $this->load->view('admin/manageclient', $data);
                //redirect("admin/addclient/$id");
            } else {
                /* Save session client info. */
                $saveclientSessionArray = array();

                if ($this->input->post('id') == null) {
                    if (@$_FILES['userImage']['name'] != '') {
                        $uploaded_data = $this->do_file_upload('users/', 'userImage');
                    }
                }

                if (@$_FILES['userImage']['name'] != '') {
                    $uploaded_data = $this->do_file_upload('users/', 'userImage');
                } else {
                    if ($this->input->post('userImage_old')) {
                        $uploaded_data['upload_data']['file_name'] = $this->input->post('userImage_old');
                    } else {
                        $uploaded_data = array('error' => '', 'upload_data' => array('file_name' => 'no-image.gif'));
                    }
                }

                $saveclientSessionArray['clientinfo'] = array(
                    'id' => $this->input->post('id'),
                    'userName' => $this->input->post('userName'),
                    'userEmail' => $this->input->post('userEmail'),
                    'userPhone' => $this->input->post('userPhone'),
                    'userImage' => $uploaded_data['upload_data']['file_name'],
                    'userRoleId' => '2',
                    'userCreateDate' => date('Y-m-d H:i:s'),
                    'userUpdateDate' => date('Y-m-d H:i:s')
                );

                //do_file_upload

                $saveclientSessionArray['ImageArray'] = array(
                    'ImageArray' => $_FILES['userImage'],
                );

                /* edit case */
                if ($this->input->post('id') != null) {
                    if ($this->input->post('newgooglepassword') != null) {
                        $saveclientSessionArray['clientinfo'] = array_merge($saveclientSessionArray['clientinfo'], array('userPassword' => md5($this->input->post('newgooglepassword'))));
                    }
                } else {
                    $saveclientSessionArray['clientinfo'] = array_merge($saveclientSessionArray['clientinfo'], array('userPassword' => md5($this->input->post('userPassword'))));
                }

                $saveclientSessionArray['clientDetail'] = array(
                    'companyName' => $this->input->post('companyName'),
                    'clientAddress' => $this->input->post('clientAddress'),
                    'accountManager' => $this->input->post('accountManager'),
                    'accountType' => $this->input->post('accountType'),
                );

                if ($this->input->post('accountType') == 'numera') {
                    $saveclientSessionArray['googleloginDetail'] = array(
                        'email' => NUMERA_GMAIL_EMAIL,
                        'password' => NUMERA_GMAIL_PWD,
                    );
                } else {
                    /* edit case */
                    if ($this->input->post('id') != null) {
                        if ($this->input->post('newgooglepassword') != null) {
                            $saveclientSessionArray['googleloginDetail'] = array(
                                'password' => $this->input->post('newgooglepassword'),
                                'email' => $this->input->post('googleemail'),
                            );
                        }
                    } else {
                        $saveclientSessionArray['googleloginDetail'] = array(
                            'email' => $this->input->post('googleemail'),
                            'password' => $this->input->post('googlepassword'),
                        );
                    }
                }
                //pr($saveclientSessionArray);

                $saveclientSessionArray['clientContactperson'] = array(
                    'name' => $this->input->post('personname'),
                    'profession' => $this->input->post('personprofession'),
                    'email' => $this->input->post('personemail'),
                    'phone' => $this->input->post('personphone'),
                    'createDate' => date('Y-m-d H:i:s'),
                );
                /* Contact person single row */
                $saveclientSessionArray['clientContactperson_single'] = array(
                    'cp' => $this->input->post('cp'),
                );

                /* Service */
                $saveclientSessionArray['save_client_services_one'] = array(
                    'serviceName' => $this->input->post('serviceName'),
                    'serviceDescription' => $this->input->post('serviceDescription'),
                    'serviceUpload' => $this->input->post('serviceUpload'),
                    'startingDate' => $this->input->post('startingDate'),
                    'endingDate' => $this->input->post('endingDate'),
                );
                /* more service */
                $saveclientSessionArray['clientservicearraylist'] = array(
                    'services' => $this->input->post('services'),
                );


                //pr($saveclientSessionArray);
                /* save data array in sesssion */
                $this->session->set_userdata('saveclientSessionArray', $saveclientSessionArray);


                if ($this->input->post('id') == '') {

                    /* Check client token exist or not */
                    $clientEamil = $saveclientSessionArray['googleloginDetail']['email'];
                    $clientemailArray = $this->adminmodel->getAccesrefreshToken($clientEamil);
                    //$clientemailArray['refreshToken'];

                    /* Verify google client */
                    if ($clientemailArray['refreshToken'] == '') {
                        $this->get_google_refresh_token();
                    } else {
                        $client = $this->google_client;

                        $client->refreshToken($clientemailArray['refreshToken']);
                        $this->session->set_userdata('accessToken', $client->getAccessToken());


                        $client->setAccessToken($this->session->userdata('accessToken'));
                        $service = new Google_DriveService($client);

                        $folderName = $saveclientSessionArray['clientinfo']['userName'];

                        $description = 'new folder in' . $folderName;
                        $parentId = '';
                        $mimeType = "application/vnd.google-apps.folder";
                        $filename = $folderName;
                        //pr($saveclientSessionArray);
                        $googlresponse = insertFile($service, $folderName, $description, $parentId, $mimeType, $filename);
                        //$googlresponse=createPublicFolder($service, $folderName);

                        $googlefolderArray = array('googlefolderId' => $googlresponse->id);
                        $saveclientSessionArray = array_merge($saveclientSessionArray, $googlefolderArray);

                        $noupdatearray = array('noupdate' => 'noupdate');
                        $saveclientSessionArray = array_merge($saveclientSessionArray, $noupdatearray);
                        //pr($saveclientSessionArray);
                        if (empty($saveclientSessionArray['clientinfo']['id'])) {
                            //pr($saveclientSessionArray);

                            $result = $this->adminmodel->saveUser('client', $saveclientSessionArray);
                            if ($result) {
                                $this->session->set_flashdata('message', '<div class="alert-success">Client added successfully.</div>');
                            } else {
                                $this->session->set_flashdata('message', '<div class="alert-error">Folder not added, please try again.</div>');
                            }
                        }
                        redirect("admin/clients");
                        //pr($saveClientArray);	
                    }
                } else {
                    /* edit case */
                    $saveClientArray = $saveclientSessionArray;
                    $result = $this->adminmodel->saveUser('client', $saveClientArray);
                    if ($result) {
                        $this->session->set_flashdata('message', '<div class="alert-success">Client updated successfully.</div>');
                    }
                    redirect("admin/clients");
                }
            }
        } else {
            //pre($this->session->all_userdata());
            if (isset($_GET['respons']) && $_GET['respons'] == 'ys') {
                /* folder update record */
                $saveClientArray = $this->session->userdata('saveclientSessionArray');
                $saveClientArray = array_merge($saveClientArray, array('id' => $id));
                //pr($saveClientArray);
                //try {

                $client = $this->google_client;
                $client->setAccessToken($this->session->userdata('accessToken'));
                $service = new Google_DriveService($client);

                $folderName_array = $this->session->userdata('saveclientSessionArray');
                $folderName = $folderName_array['clientinfo']['userName'];

                $description = 'new folder in' . $folderArray['folderName'];
                $parentId = '';
                $mimeType = "application/vnd.google-apps.folder";
                $filename = $folderName;

                $googlresponse = insertFile($service, $folderName, $description, $parentId, $mimeType, $filename);
                //$googlresponse=createPublicFolder($service, $folderName);

                $googlefolderArray = array('googlefolderId' => $googlresponse->id);
                $saveClientArray = array_merge($saveClientArray, $googlefolderArray);
                //pr($saveClientArray);
                //$this->session->set_userdata('createclientfolder_session',$googlresponse);

                if (empty($saveClientArray['clientinfo']['id'])) {
                    $result = $this->adminmodel->saveUser('client', $saveClientArray);
                    if ($result) {
                        $this->session->set_flashdata('message', '<div class="alert-success">Client added successfully.</div>');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert-error">Folder not added, please try again.</div>');
                    }
                }
                //} catch (Exception $e) {
                //pre($e);
                //redirect("admin/clients");
                //}
                redirect("admin/clients");
            }
            redirect("admin/addclient/$id");
        }
    }

    /**
     * @ Function Name	: active
     * @ Function Params	: $id {array/integer}
     * @ Function Purpose 	: make Client status active
     * @ Function Returns	: 
     */
    function active($id = '') {
        isAdminAuthorize(); /* checked is admin login or not */
        $this->load->model('adminmodel');
        $result = false;
        //pr($id);
        if ($this->uri->segment(3)) {
            /* Get User detail */
            $usrdetail = $this->adminmodel->getuserDetailbyId($id);
            if ($usrdetail) {
                $id = $usrdetail['userId'];  /* User Only */
                $usr = "user";
            } else {
                $id = $this->uri->segment(3); /* Client only */
                $usr = "client";
            }
            $result = $this->adminmodel->status($id, 'active');
        }

        if ($result == true) {
            $this->session->set_flashdata('message', "<div class='alert-success'>Active status set for $usr successfully.</div>");
        } else {
            $this->session->set_flashdata('message', "<div class='alert-error'>No status set for $usr, please try again.</div>");
        }

        if ($usr == 'user') {
            redirect('admin/users');
        } else {
            redirect('admin/clients');
        }
    }

    /**
     * @ Function Name	: inactive
     * @ Function Params	: $id {array/integer}
     * @ Function Purpose 	: make Client status inactive
     * @ Function Returns	: 
     */
    function inactive($id = '') {
        isAdminAuthorize(); /* checked is admin login or not */
        $this->load->model('adminmodel');
        $result = false;
        if ($this->uri->segment(3)) {
            /* Get User detail */
            $usrdetail = $this->adminmodel->getuserDetailbyId($id);
            if ($usrdetail) {
                $id = $usrdetail['userId'];  /* User Only */
                $usr = "user";
            } else {
                $id = $this->uri->segment(3); /* Client only */
                $usr = "client";
            }
            $result = $this->adminmodel->status($id, 'inactive');
        }
        if ($result == true) {
            echo $this->session->set_flashdata('message', "<div class='alert-success'>Inactive status set for $usr successfully.</div>");
        } else {
            echo $this->session->set_flashdata('message', "<div class='alert-error'>No status set for $usr, please try again.</div>");
        }
        if ($usr == 'user') {
            redirect('admin/users');
        } else {
            redirect('admin/clients');
        }
    }

    /**
     * @ Function Name	: Delete
     * @ Function Params	: $id {array/integer}
     * @ Function Purpose 	: make Client status inactive
     * @ Function Returns	: 
     */
    function delete($id = '') {
        isAdminAuthorize(); /* checked is admin login or not */
        $this->load->model('adminmodel');
        $result = false;
        if ($this->uri->segment(3)) {
            /* Get User detail */
            $usrdetail = $this->adminmodel->getuserDetailbyId($id);
            if ($usrdetail) {
                $id = $usrdetail['userId'];  /* User Only */
                $usr = "User";
            } else {
                $id = $this->uri->segment(3); /* Client only */
                $usr = "Client";
            }
            $result = $this->adminmodel->deleteusers_clients($id);
        }
        if ($result == true) {
            echo $this->session->set_flashdata('message', "<div class='alert-success'>$usr deleted successfully.</div>");
        } else {
            echo $this->session->set_flashdata('message', "<div class='alert-error'>$usr not deleted, please try again.</div>");
        }
        if ($usr == 'User') {
            redirect('admin/users');
        } else {
            redirect('admin/clients');
        }
    }

    /**
     * @ Function Name	: managecontactperoson
     * @ Function Params	: $id {array/integer}
     * @ Function Purpose 	: add new contact person for a client
     * @ Function Returns	: 
     */
    function managecontactperson($clientId = null, $id = null) {
        isAdminAuthorize(); /* checked is admin login or not */
        $data['menu'] = '4';
        $data['clientId'] = $this->uri->segment(3);
        $this->load->model('adminmodel');
        if ($id) {
            $data['title'] = 'Edit Contact person';
        } else {
            $data['title'] = 'New Contact person';
        }
        if ($this->input->post('btnsubmit')) {
            $this->form_validation->set_rules('name', 'Person Name', 'required|min_length[5]');
            $this->form_validation->set_rules('profession', 'Profession', 'required|min_length[3]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[client_contact_persons.email]');
            $this->form_validation->set_rules('phone', 'Phone', 'required|integer|min_length[10]|max_length[15]');
            if ($this->form_validation->run() == false) {
                $this->load->view('admin/managecontactperson.php', $data);
            } else {
                $clientDetails = $this->adminmodel->getClientdetails($this->uri->segment(3));
                $client_detail_id = $clientDetails['id'];
                $cpersonname = array(
                    'clientId' => $client_detail_id,
                    'name' => $this->input->post('name'),
                    'profession' => $this->input->post('profession'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                    'createDate' => date('Y-m-d H:i:s'),
                );
                /* edit contact person record */
                if ($this->input->post('contactpid')) {
                    $cpid = $this->input->post('contactpid');
                    $result = $this->adminmodel->savecontactperson($cpid, $this->uri->segment(3), $cpersonname);
                } else {
                    /* addd new contact person record */
                    $result = $this->adminmodel->savecontactperson(null, $this->uri->segment(3), $cpersonname);
                }
                if ($result) {
                    if (empty($cpid)) {
                        echo $this->session->set_flashdata('message', '<div class="alert-success">Contact persone added successfully.</div>');
                    } else {
                        echo $this->session->set_flashdata('message', '<div class="alert-success">Contact persone updated successfully.</div>');
                    }
                } else {
                    echo $this->session->set_flashdata('message', '<div class="alert-error">Contact persone not added, please try again.</div>');
                }
                redirect('admin/clients');
                //continue
            }
        } else {
            if ($id) {
                $data['contact_person_detail'] = $this->adminmodel->getcontact_person_detail($id);
            }
            $this->load->view('admin/managecontactperson.php', $data);
        }
    }

    /**
     * @ Function Name	: manageclientservice
     * @ Function Params	: $clientId of client / $id of service {array/integer}
     * @ Function Purpose 	: add new/ edit service contract for a client
     * @ Function Returns	: 
     */
    function manageclientservice($clientId = null, $serviceid = null) {
        isAdminAuthorize(); /* checked is admin login or not */
        $data['clientId'] = $this->uri->segment(3);
        $data['menu'] = '4';
        $this->load->model('adminmodel');
        $this->load->library('utility');
        if ($serviceid) {
            $data['title'] = 'Edit Service';
        } else {
            $data['title'] = 'New Service';
        }
        if ($this->input->post('btnsubmit')) {
            $this->form_validation->set_rules('serviceName', 'Service Name', 'required|min_length[3]');
            $this->form_validation->set_rules('serviceDescription', 'Description', 'required|min_length[3]');
            $this->form_validation->set_rules('startingDate', 'Starting date', 'required');
            $this->form_validation->set_rules('endingDate', 'Ending date', 'required');
            if ($this->form_validation->run() == false) {
                $this->load->view('admin/manageclientservice.php', $data);
            } else {
                $clientDetails = $this->adminmodel->getClientdetails($this->uri->segment(3));
                $client_detail_id = $clientDetails['id'];

                $sdate = $this->input->post('startingDate');
                $edate = $this->input->post('endingDate');

                $stardate = $this->utility->dateFormat($sdate, 'Y-m-d H:i:s');
                $enddate = $this->utility->dateFormat($edate, 'Y-m-d H:i:s');

                //$stardate = date_format($sdate, 'Y-m-d H:i:s');
                //$enddate = date_format($edate, 'Y-m-d H:i:s');

                $clientservice = array(
                    'clientId' => $client_detail_id,
                    'serviceName' => $this->input->post('serviceName'),
                    'serviceDescription' => $this->input->post('serviceDescription'),
                    'serviceUpload' => $this->input->post('serviceUpload'),
                    'startingDate' => $stardate,
                    'endingDate' => $enddate,
                );
                //pr($clientservice);
                /* edit contact person record */
                if ($this->input->post('clientserviceid')) {
                    $cpid = $this->input->post('clientserviceid');
                    $result = $this->adminmodel->saveclientService($cpid, $this->uri->segment(3), $clientservice);
                } else {
                    /* addd new contact person record */
                    $result = $this->adminmodel->saveclientService(null, $this->uri->segment(3), $clientservice);
                }
                if ($result) {
                    if (empty($cpid)) {
                        echo $this->session->set_flashdata('message', '<div class="alert-success">Client service added successfully.</div>');
                    } else {
                        echo $this->session->set_flashdata('message', '<div class="alert-success">Client service updated successfully.</div>');
                    }
                } else {
                    echo $this->session->set_flashdata('message', '<div class="alert-error">Client service not added, please try again.</div>');
                }
                redirect('admin/clientservices');
                //continue
            }
        } else {
            if ($serviceid) {

                $data['client_service_detail'] = $this->adminmodel->getclient_service_detail($serviceid);
            }
            $this->load->view('admin/manageclientservice.php', $data);
        }
    }

    /**
     * @ Function Name	: clientservices
     * @ Function Params	: $clientId
     * @ Function Purpose 	: Show all clients service and get individual client service
     * @ Function Returns	: 
     */
    function clientservices($cId = null, $type = null) {
        isAdminAuthorize(); /* checked is admin login or not */
        $this->load->library("pagination");
        $this->load->model('adminmodel');
        $this->load->helper('text');
        //page title
        $data['title'] = 'Client Services';
        $data['menu'] = '4';

        //pagination configurations
        if ($cId && $type == "notall") {
            $data['total_row'] = $this->adminmodel->getclientservicelist($cId, $type = 'client', null, null);
        } else {
            $data['total_row'] = $this->adminmodel->getclientservicelist($uclientid = null, $type = 'client', null, null);
            //die('dd');
        }
        $config['total_rows'] = count($data['total_row']);
        $config['per_page'] = PER_PAGE_RECORD; /* DEFINE IN CONFIG/CONSTAANT.PHP */;

        //get all the URI segments for pagination and sorting
        $segment_array = $this->uri->segment_array();
        $segment_count = $this->uri->total_segments();

        //for ordering the data items
        $do_orderby = array_search("orderby", $segment_array);

        //asc and desc sorting
        $desc = array_search("desc", $segment_array);
        $asc = array_search("asc", $segment_array);


        //get the records
        if ($this->uri->segment($do_orderby + 1) == 'admin') {
            $sortby = 'cservice.id';
        } else {
            $sortby = $this->uri->segment($do_orderby + 1);
        }

        $this->db->order_by($sortby, $this->uri->segment($do_orderby + 2));

        //getting the records and limit setting
        if (ctype_digit($segment_array[$segment_count])) {

            $data['page'] = $segment_array[$segment_count];
            $page = $segment_array[$segment_count];
            $this->db->limit($config['per_page'], $segment_array[$segment_count]);
            array_pop($segment_array);
        } else {
            $page = null;
            $data['page'] = NULL;
            $this->db->limit($config['per_page']);
        }

        $config['base_url'] = site_url(join("/", $segment_array));
        $config['uri_segment'] = count($segment_array) + 1;

        //initialize pagination
        $this->pagination->initialize($config);
        if ($cId && $type == "notall") {
            $data['results'] = $this->adminmodel->getclientservicelist($cId, $type = 'client', $config["per_page"], $page);
        } else {
            $data['results'] = $this->adminmodel->getclientservicelist($uclientid = null, $type = 'client', $config["per_page"], $page);
        }
        $data["links"] = $this->pagination->create_links();

        //load the view
        $this->load->view('admin/clientservices.php', $data);
    }

    /**
     * @ Function Name	: cservicedelete
     * @ Function Params	: $id {array/integer}
     * @ Function Purpose 	: delete contact person from contact_person_tables.
     * @ Function Returns	: 
     */
    function cservicedelete($clntid, $serviceid) {
        isAdminAuthorize(); /* checked is admin login or not */
        $this->load->model('adminmodel');
        $data['title'] = 'Contact person delete ';
        $result = $this->adminmodel->cservicedelete($clntid, $serviceid);
        if ($result == true) {
            echo $this->session->set_flashdata('message', '<div class="alert-success">Client service deleted successfully.</div>');
        } else {
            echo $this->session->set_flashdata('message', '<div class="alert-error">Client service not delete, please try again.</div>');
        }
        redirect("admin/clientservices");
    }

    /**
     * @ Function Name	: do_file_upload
     * @ Function Params	: $path / $filename
     * @ Function Purpose 	: upload file for contract service
     * @ Function Returns	: 
     */
    function do_file_upload($path, $fileName) {
        $config['upload_path'] = './uploads/' . $path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx';
        $this->load->library('upload', $config);
        $this->upload->do_upload($fileName);
        return array('error' => $this->upload->display_errors(), 'upload_data' => $this->upload->data());
    }

    /**
     * @ Function Name	: managecontactperoson
     * @ Function Params	: $id {array/integer}
     * @ Function Purpose 	: add new contact person for a client
     * @ Function Returns	: 
     */
    function contactperson($userId = null) {
        isAdminAuthorize(); /* checked is admin login or not */
        $this->load->library("pagination");
        $this->load->model('adminmodel');
        $data['title'] = 'List of contact person';
        $data['menu'] = '4';

        /* Get client id from client_detail table */
        $clientDetails = $this->adminmodel->getClientdetails($userId);
        $clientId = $clientDetails['id'];
        //$data['contacpersonList'] = $this->adminmodel->getContactpersonlist($clientId);
        //$this->load->view('admin/contactpersonlist.php',$data);




        $data['total_row'] = $this->adminmodel->getContactpersonlist($clientId, $type = null, null, null);

        $config['total_rows'] = count($data['total_row']);
        $config['per_page'] = PER_PAGE_RECORD; /* DEFINE IN CONFIG/CONSTAANT.PHP */

        //get all the URI segments for pagination and sorting
        $segment_array = $this->uri->segment_array();
        /* bcz of incriment for client id */
        array_push($segment_array, '');

        $segment_count = $this->uri->total_segments();
        /* incriment for client id */
        //$last_segment = end($this->uri->segment_array());
        $segment_count = $segment_count + 1;

        //for ordering the data items
        $do_orderby = array_search("orderby", $segment_array);

        //asc and desc sorting
        $asc = array_search("asc", $segment_array);
        $desc = array_search("desc", $segment_array);

        //get the records
        if ($this->uri->segment($do_orderby + 1) == 'admin') {
            $sortby = 'id';
        } else {
            $sortby = $this->uri->segment($do_orderby + 1);
        }

        $this->db->order_by($sortby, $this->uri->segment($do_orderby + 2));

        //getting the records and limit setting
        if (ctype_digit($segment_array[$segment_count])) {
            $data['page'] = $segment_array[$segment_count];
            $page = $segment_array[$segment_count];
            $this->db->limit($config['per_page'], $segment_array[$segment_count]);
            array_pop($segment_array);
            //array_pop($segment_array);
        } else {
            $page = null;
            $data['page'] = NULL;
            $this->db->limit($config['per_page']);
        }

        $config['base_url'] = site_url(join("/", $segment_array));
        $config['uri_segment'] = count($segment_array) + 1;

        //initialize pagination
        $this->pagination->initialize($config);

        //$data['contacpersonList'] = $this->adminmodel->getContactpersonlist($clientId);
        //$this->adminmodel->getContactpersonlist($clientId,$type=null,null, null);
        //echo $config["per_page"];
        //echo $page;
        $data['contacpersonList'] = $this->adminmodel->getContactpersonlist($clientId, $type = null, $config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        //pr($data["links"]);
        //load the view
        $this->load->view('admin/contactpersonlist.php', $data);
    }

    /**
     * @ Function Name	: contactpersondelete
     * @ Function Params	: $id {array/integer}
     * @ Function Purpose 	: delete contact person from contact_person_tables.
     * @ Function Returns	: 
     */
    function contactpersondelete($userid, $cpid) {
        isAdminAuthorize(); /* checked is admin login or not */
        $this->load->model('adminmodel');
        $data['title'] = 'Contact person delete ';
        $result = $this->adminmodel->contactpersondelete($userid, $cpid);
        if ($result == true) {
            echo $this->session->set_flashdata('message', '<div class="alert-success">Contact persone deleted successfully.</div>');
        } else {
            echo $this->session->set_flashdata('message', '<div class="alert-error">Contact persone not delete, please try again.</div>');
        }
        redirect("admin/contactperson/$userid");
    }

    /* chech user is exis or not by jquery */

    function checkUser_jquery($name) {
        $this->load->model('adminmodel');
        if (isset($name)) {
            $userArray = $this->adminmodel->checkUser_jquery($name);
            echo count($userArray);
            //pre($userArray);
        }
    }

    /* Client folder acording client name by jquery */

    function getclientfolders($select, $userid = null) {
        $this->load->model('adminmodel');
        if (isset($select)) {
            $folderlist = $this->adminmodel->getclientallfolders($select);

            /* Get only Client Folder selected permission List */
            @$data['folderpermissions_array'] = $this->adminmodel->getclientfolderPermission($userid);
            $folderarraykey = array();
            if (isset($data['folderpermissions_array']['folderpermissions']) && !empty($data['folderpermissions_array']['folderpermissions'])) {
                $folderpermissionAry = json_decode($data['folderpermissions_array']['folderpermissions']);
                foreach ($folderpermissionAry as $ky => $val) {
                    $folderarraykey[$ky] = $folderpermissionAry->$ky;
                }

                $select_client_folder_permission = $folderarraykey;
            }
            if (count($folderlist) > 0) {


                //pre($folderlist);
                echo'<table width="100%" cellspacing="0" cellpadding="0" border="0" id="clientfolders">
					<colgroup>
					<col width="25">
					<col width="250">
					</colgroup>
					<tbody>
						<tr>	<td colspan="7" scope="col"> &nbsp;</td></tr>
						<tr>	<td colspan="7" scope="col"> <strong>Folders</strong></td></tr>
						<tr>	<th scope="col"></th><th scope="col"></th></tr>
					<!--Folder Listing-->';
                foreach ($folderlist as $folder) {
                    if (!empty($select_client_folder_permission[$folder['id']]->Createfile) && $select_client_folder_permission[$folder['id']]->Createfile == "accept") {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }

                    if (!empty($select_client_folder_permission[$folder['id']]->moovefile) && $select_client_folder_permission[$folder['id']]->moovefile == "accept") {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }

                    if (!empty($select_client_folder_permission[$folder['id']]->Deletefile) && $select_client_folder_permission[$folder['id']]->Deletefile == "accept") {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }

                    if (!empty($select_client_folder_permission[$folder['id']]->Viewfolder) && $select_client_folder_permission[$folder['id']]->Viewfolder == "accept") {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }


                    echo '</tr>
							<tr class="alternateRow">
							<td scope="col">' . $folder['folderName'] . '</td>
							<td scope="col">
								<div>
									<div class="clear"></div>
									<div style="float:left">
										<table>
											<tbody>
												<tr><td colspan="3"><strong>File</strong></td></tr>
												<tr>
												     <td><div class="radio-input">Add <input type="checkbox" ' . $checked . '  value="accept" name="folderpermission[' . $folder['id'] . '][Createfile]"></div> </td>
												     <td><div class="radio-input">Move <input type="checkbox"  ' . $checked . ' value="accept" name="folderpermission[' . $folder['id'] . '][moovefile]"></div> </td>
												     <td><div class="radio-input">Delete <input type="checkbox" ' . $checked . ' value="accept" name="folderpermission[' . $folder['id'] . '][Deletefile]"></div> </td>
												</tr>
												<tr>
												     <td colspan="3"><strong>Folder</strong></td>
												     
												</tr>
												<!--<tr>
												     <td><div class="radio-input">Create<input type="checkbox" ' . $checked . '  value="accept" name="folderpermission[' . $folder['id'] . '][Createfolder]"></div></td>
												     <td><div class="radio-input">Delete<input type="checkbox" ' . $checked . '  value="accept" name="folderpermission[' . $folder['id'] . '][Deletefolder]"></div></td>
												     <td><div class="radio-input">Moove<input type="checkbox" ' . $checked . '  value="accept" name="folderpermission[' . $folder['id'] . '][Moovefolder]"></div></td>
												</tr>-->
												<tr>
												     <td><div class="radio-input">View<input type="checkbox" ' . $checked . ' value="accept" name="folderpermission[' . $folder['id'] . '][Viewfolder]"></div></td>
												     <td><div class="checkboxhidden" >
														 permission true<input type="checkbox"  name="folderpermission[' . $folder['id'] . '][permissiontrue]" value="accept" checked="checked">
													</div>
												      </td>
												      <td><!--<div class="radio-input">Rename<input type="checkbox" ' . $checked . ' value="accept" name="folderpermission[' . $folder['id'] . '][Renamefolder]"></div>--></td>
												</tr>
												<tr>
												     <td></td>
												     <td></td>
												     <td></td>
												</tr>
										       </tbody>
										</table>     
									</div>	
								</div>
							</td>
						</tr>';
                }
                '</tbody></table>';
            } else {
                echo '<div class="alert-info" id="infoclass">No folder available for this user, add new folder from client manage folder.</div>';
            }
        }
    }

    /**
     * @ Function Name	: setpermission
     * @ Function Params	: $id {array/integer}
     * @ Function Purpose 	: Show all permissions
     * @ Function Returns	: 
     */
    function setpermission($userid) {
        isAdminAuthorize(); /* checked is admin login or not */
        $data['menu'] = '5';
        $this->load->model('adminmodel');
        $data['title'] = 'Set permisssion';

        /* Get user records, This function define on common_helper */
        $rows = get_user($userid);
        if ($rows) {
            $data['username'] = $rows->userName;
        } else {
            $data['username'] = null;
        }

        //pr($rows);
        /* Get all permission list */
        $data['results'] = $this->adminmodel->getallpermissions($userid);

        /* Get only user permission List */
        $data['userpermissions'] = $this->adminmodel->getuserpermissions($userid);
        //pr($data['userpermissions']);
        if ($data['userpermissions']) {
            $userpermissionAry = json_decode($data['userpermissions']['permissionId']);
            foreach ($userpermissionAry as $ky => $val) {
                //if($val=='yes'){
                $arraykey[$ky] = $userpermissionAry->$ky;
                //}
            }
            //print_r($arraykey);
            $data['select_usr_permission'] = $arraykey;
        }
        if ($userid) {
            $data['userid'] = $userid;
        } else {
            $data['userid'] = null;
        }
        //pr($data['result']);
        if ($this->input->post('setpermission') && $this->input->post('userId')) {
            //json_encode($sequential)
            //json_decode($sequential)
            $permissionnamevalue = json_encode($this->input->post('pid'));
            $permissionarray = array(
                'permissionId' => $permissionnamevalue,
                'userId' => $this->input->post('userId'),
                'userPerDate' => date('Y-m-d H:i:s'),
            );
            //pr($clientservice);
            /* edit contact person record */
            if ($this->input->post('permissionid')) {
                $perid = $this->input->post('permissionid');
                $result = $this->adminmodel->savepermissions($perid, $userid, $permissionarray);
            } else {
                /* addd new contact person record */
                $result = $this->adminmodel->savepermissions($perid = null, $userid, $permissionarray);
            }
            if ($result) {
                if (empty($userid)) {
                    echo $this->session->set_flashdata('message', '<div class="alert-success">Permissions set successfully.</div>');
                } else {
                    echo $this->session->set_flashdata('message', '<div class="alert-success">Permissions updated successfully.</div>');
                }
            } else {
                echo $this->session->set_flashdata('message', '<div class="alert-error">Permission not set, please try again.</div>');
            }
            redirect("admin/setpermission/$userid");
            //continue
        } else {
            $this->load->view('admin/setpermission.php', $data);
        }
    }

    /**
     * @ Function Name	: managefolder
     * @ Function Params	: 
     * @ Function Purpose 	: sends mail to all user from admin side.
     * @ Function Returns	: 
     */
    public function managefolder($id = null) {

        isAdminAuthorize(); /* checked is admin login or not */
        $this->load->model('adminmodel');
        if ($id) {
            $data['title'] = 'Edit folder';
        } else {
            $data['title'] = 'New folder';
        }
        $data['foder_array'] = $this->adminmodel->getallfolders($id, null);

        if (isset($id) && $id != '') {
            //$data['folderDetail']=$this->adminmodel->getallfolders($id,'getbyId'); comment on 2709
            @$data['folderDetail']['parentfolder'] = $this->adminmodel->getallfolders($id, 'byuserId');
        }
        //pre($data['folderDetail']);
        $options = walk_dir_folder(0, "", $id, 'option');
        //pre($options);
        //echo "<select>";
        //$options;
        //echo "</select>";
        if (count($options) > 0) {
            $data['userfoldersoption'] = $options;
        }
        //pre($data['parentfolder']);

        if ($this->input->post('btnsubmit')) {

            $result_row = $this->adminmodel->getallfolders($this->input->post('parentfolderid'), 'getbyId');
            $clientid = $result_row[0]['userId'];
            $folderLevel = $result_row[0]['folderLevel'];

            //pr($result_row);

            $clientInfoArry = $this->adminmodel->getclientDetail($clientid);
            //pr($clientInfoArry);	

            /* setredirect url folder id */
            if ($this->input->post('redirectfolderid') != null) {
                $this->session->set_userdata('redirecturlfolderid', $this->input->post('redirectfolderid'));
            }


            if ($this->input->post('id')) {
                $this->form_validation->set_rules('folderName', 'Name', 'required');
            } else {
                $this->form_validation->set_rules('parentfolderid', 'folder name', 'required');
                $this->form_validation->set_rules('folderName', 'Name', 'required|callback_valid_unique_folder');
            }

            if ($this->form_validation->run() == false) {
                $this->load->view('admin/managefolder.php', $data);
                //return false;
            } else {
                if ($this->input->post('id') != null) {
                    $folderArray = array(
                        'folderName' => $this->input->post('folderName'),
                        'id' => $this->input->post('id'),
                    );
                } else {
                    $folderArray = array(
                        'folderName' => $this->input->post('folderName'),
                        'parentId' => $this->input->post('parentfolderid'),
                        'userId' => $clientid,
                        'googleFolderName' => $this->input->post('folderName'),
                        'id' => $this->input->post('id'),
                        'folderLevel' => $folderLevel + 1,
                    );
                }

                /* save data array in sesssion */
                $this->session->set_userdata('folderArrayset', $folderArray);

                /* Verify google client */

                $resultArray = $this->adminmodel->getAccesrefreshToken($clientInfoArry['email']);
                //pr($resultArray);
                if (empty($resultArray['refreshToken'])) {
                    redirect('admin/managefolder');
                }

                $refreshtoken = $resultArray['refreshToken'];

                $accessToken = $this->get_admin_google_accesstoken($refreshtoken);

                if (!empty($accessToken)) {
                    $this->google_client->setAccessToken($accessToken);
                } else {
                    redirect('admin/managefolder');
                }
                $folderparentid = $this->session->userdata('folderArrayset');
                $parent_folder_row = $this->adminmodel->getallfolders($folderparentid['parentId'], 'getbyId');
                $parentfolderName = $parent_folder_row[0]['googleFolderName'];
                $redirectfolderid = $parent_folder_row[0]['userId'];

                $folderArray = $this->session->userdata('folderArrayset');

                try {

                    $client = $this->google_client;
                    $service = new Google_DriveService($client);
                    if ($folderArray['id'] == null) {
                        //pr($parentfolderName);
                        /* Search parent folder in google drive */
                        $this->data['user_folders_list'] = retrieveAllFiles($service);
                        //pr($this->data['user_folders_list']);
                        foreach ($this->data['user_folders_list'] as $folders) {

                            if ($folders->title == $parentfolderName) {
                                //pr($parentfolderName);
                                /* Create a folder */
                                $description = 'new folder in' . $folderArray['folderName'];
                                $parentId = $folders->id;
                                $mimeType = "application/vnd.google-apps.folder";
                                $filename = $folderArray['folderName'];
                                $return = insertFile($service, $folderArray['folderName'], $description, $parentId, $mimeType, $filename);
                            }
                        }
                    }
                    if ($return) {
                        $folderArray = array_merge($folderArray, array('googlefolderId' => $return->id));
                        $result = $this->adminmodel->savefolder($folderArray);
                    }
                    if ($result && $return) {
                        if ($result == 'update') {
                            echo $this->session->set_flashdata('message', '<div class="alert-success">Folder updated successfully.</div>');
                        } else {
                            echo $this->session->set_flashdata('message', '<div class="alert-success">Folder added successfully.</div>');
                        }
                    } else {
                        echo $this->session->set_flashdata('message', '<div class="alert-error">Folder not added, please try again.</div>');
                    }
                } catch (Exception $e) {
                    pr($e);
                    $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('google_client_not_valid_email') . '</div>');
                }
                redirect('admin/folderlist/' . $this->session->userdata('redirecturlfolderid'));
            }
        } else {
            $this->load->view('admin/managefolder.php', $data);
        }
    }

    public function valid_unique_folder($str) {
        $clientid = $this->uri->segment(3);
        //$this->load->model('adminmodel');
        @$data['users'] = $this->adminmodel->checkUserFolderexist($str, $clientid);
        if (count($data['users']) > 0) {
            $this->form_validation->set_message('valid_unique_folder', 'The folder %s field is all ready exist, Try different ');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * @ Function Name	: Delete folder 
     * @ Function Purpose: Delete folder from database and google drive
     * @ Function Returns: 
     */
    public function deletefolder($id = null) {
        if (isset($id)) {
            /* Verify google client */
            $result_row = $this->adminmodel->getallfolders($id, 'getbyId');
            //pr($result_row);
            $clientid = $result_row[0]['userId'];
            $deletefolderArray = array('id' => $result_row[0]['id'], 'foldername' => $result_row[0]['folderName'], 'googlefolderId' => $result_row[0]['googlefolderId']);
            /* save data array in sesssion */
            //$this->session->set_userdata('deletefolderArray',$deletefolderArray);

            /* Verify google client */
            $clientInfoArry = $this->adminmodel->getclientDetail($clientid);
            $resultArray = $this->adminmodel->getAccesrefreshToken($clientInfoArry['email']);
            //pr($resultArray);
            if (empty($resultArray['refreshToken'])) {
                redirect('admin/managefolder');
            }

            $refreshtoken = $resultArray['refreshToken'];
            $accessToken = $this->get_admin_google_accesstoken($refreshtoken);
            //pr($accessToken);

            if (!empty($accessToken)) {
                $this->google_client->setAccessToken($accessToken);
            } else {
                redirect('admin/managefolder');
            }

            /* folder update record */
            //$deletefolderArray = $this->session->userdata['deletefolderArray'];
            //pr($deletefolderArray);
            try {
                $client = $this->google_client;
                //$client->setAccessToken($this->session->userdata('accessToken'));
                $service = new Google_DriveService($client);

                /* Get google derive folder list to delete particular folder */
                $this->data['user_folders_list'] = retrieveAllFiles($service);
                foreach ($this->data['user_folders_list'] as $folders) {
                    if ($folders->id == $deletefolderArray['googlefolderId']) {
                        //Delete
                        $fileId = $folders->id;
                        deleteFile($service, $fileId);
                    }
                }
                //die('delete');
            } catch (Exception $e) {
                $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('google_client_not_valid_email') . '</div>');
            }
            $result = $this->adminmodel->deletefolder($deletefolderArray);
            if ($result) {
                echo $this->session->set_flashdata('message', '<div class="alert-success">Folder delete successfully.</div>');
            } else {
                echo $this->session->set_flashdata('message', '<div class="alert-error">Folder not deleted, please try again.</div>');
            }
            redirect("admin/folderlist/$clientid");
        }
    }

    public function get_google_refresh_token() {

        $client = $this->google_client;

        $redirect = 'manageclient';
        $tokenArray = array('redirectfun' => $redirect,);
        $this->session->set_userdata('tokenArray', $tokenArray);

        $client->setApprovalPrompt('force');
        //$oauth2 = new Google_Oauth2Service($client);

        $client->authenticate();
        exit;
    }

    public function getGoogleAccessToken() {

        $client = $this->google_client;

        if (isset($_GET['code'])) {
            try {
                $oauth2 = new Google_Oauth2Service($client);
                $accessToken = $client->authenticate($_GET['code']);
                $this->session->set_userdata('accessToken', $accessToken);
                $user = $oauth2->userinfo->get();
                $saveclientSessionArray = $this->session->userdata('saveclientSessionArray');
                if ($user->email != $saveclientSessionArray['googleloginDetail']['email']) {
                    $this->session->set_flashdata('message', '<div class="alert-error">Entered client email and google email address is not match, please try again.</div>');
                    //redirect to clien add page with error
                    redirect('admin/addclient?msg=invalid');
                    exit;
                } else {

                    $tokenArry = json_decode($accessToken, true);
                    //pr($tokenArry);
                    $this->adminmodel->new_savegooglerefreshToken($tokenArry['refresh_token']);
                    //pr($tokenArry);
                    //echo 're-'.$redirect;
                    //die;
                    redirect("admin/manageclient?respons=ys");
                    exit;
                    //pr('savedata');
                    // save refresh token top db	
                }
            } catch (Exception $e) {
                var_dump($e);
                //pr($e);
            }
            /* echo $_GET['code'];
              pre($this->session->all_userdata());
              pr($user);
              //$this->session->set_userdata('accessToken'));
              pre($user);
              echo "<pre>";print_r($this->session->userdata('accessToken'));
              die; */
            header('location:' . $url);
            exit;
        } else {
            redirect('admin/addclient');
        }
    }

    function get_admin_google_accesstoken($refresh_token) {

        if (!empty($refresh_token)) {
            $client = $this->google_client;
            try {
                $client->refreshToken($refresh_token);
                //$this->session->set_userdata('accessToken',$client->getAccessToken());
                return $client->getAccessToken();
                //redirect("users/alldocs");	
            } catch (Exception $e) {

                var_dump($e);
                exit;
            }
        }
    }

    /**
     * @ Function Name	: folderlist
     * @ Function Params	: 
     * @ Function Purpose 	: sends mail to all user from admin side.
     * @ Function Returns	: 
     */
    public function folderlist($id) {

        isAdminAuthorize(); /* checked is admin login or not */
        $this->load->library("pagination");
        $this->load->model('adminmodel');
        $data['title'] = 'Folders';
        $this->session->unset_userdata('redirecturlfolderid');

        $config = array();
        $config["base_url"] = base_url() . "admin/folderlist/$id";
        $config["total_rows"] = count($this->adminmodel->getallfolders($id, null));
        $config['per_page'] = PER_PAGE_RECORD; /* DEFINE IN CONFIG/CONSTAANT.PHP */;

        $config["uri_segment"] = 4;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['folder_array'] = $this->adminmodel->allfolders_pagination($id, $config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        $Arraylist = walk_dir_folder(0, "", $id, 'list');
        if (count($Arraylist) > 0) {
            $data['userfolders'] = $Arraylist;
        }
        //load the view
        $this->load->view('admin/folderlist.php', $data);
    }

    public function updatenumeraemail() {
        isAdminAuthorize(); /* checked is admin login or not */
        if (!$this->session->userdata('loggedInAdmin'))
            redirect('admin');
        $this->load->model('adminmodel');
        $this->form_validation->set_rules('numeraEmail', 'Numera email', 'required|valid_email|callback_checkEmailisGmail');
        $this->form_validation->set_rules('numeraPassword', 'Password', 'required|min_length[8]|max_length[100]');

        /* Get Exist Email and password */
        $data['numeraEmailDetail'] = $this->adminmodel->getNumeraEmailDetail();
        //pre($data['numeraEmailDetail']);	
        if ($this->form_validation->run() == false) {
            $data['menu'] = '8';
            $this->load->view('admin/updatenumeraemail', $data);
        } else {
            $uid = $this->session->userdata('id');
            $numeraEmail = $this->input->post('numeraEmail');
            $numeraPassword = $this->input->post('numeraPassword');

            /* update password */
            $getresult = $this->adminmodel->getNumeraEmailDetail("addEdit");
            //pre($getresult);


            if ($getresult) {
                //print_r($userdetail);
                $to = $this->session->userdata('admin_email');
                if ($getresult == "Eadd") {
                    $subject = 'Numera new email notification';
                    $pt = "New";
                } else {
                    $subject = 'Numera email change notification';
                    $pt = "Update";
                }
                $username = "Administrator";

                $data = 'Hello ' . $username . ',<br/> ' . $pt . ' Nemura  email : <b>' . $numeraEmail . '</b><br/><br/> password :' . $numeraPassword . '<br/><br/>Regards <br/><a href="http://www.oneandsimple.com/" target="_blank">Oneandsimple</a>';
                /* Call function */
                //send_mail($to,$subject,$data);
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'oneandsimple76@gmail.com',
                    'smtp_pass' => 'oneandsimple76123456',
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1'
                );
                $this->load->library('email', $config);
                $this->email->from($numeraEmail, 'oneandsimple');
                $this->email->to($to);
                $this->email->subject($subject);
                //pr($data);
                $this->email->message($this->load->view('emails/message', $data, true));
                $this->email->send();

                if ($getresult == "Eadd") {
                    $this->session->set_flashdata('message', '<div class="alert-success">Numera email add successfully. </div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert-success">Numera email has been change successfully. </div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert-error">Your password is not change, please try again!</div>');
            }
            //echo $this->email->print_debugger();			
            redirect('admin/updatenumeraemail', 'refresh');
            //$this->load->view('admin/changepassword');			
        }
    }

    function checkEmailisGmail($str) {
        $email = explode('@', $str);
        //echo $email[1];
        if ($email[1] != "gmail.com") {
            $this->form_validation->set_message('checkEmailisGmail', 'The %s field is not gmail email address');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * @ Function Name		: _sendWelcomeMail
     * @ Function Params	: 
     * @ Function Purpose 	: sends mail to all user from admin side.
     * @ Function Returns	: 
     */
    private function _sendWelcomeMail($type) {
        $from = $this->session->userdata('admin_email');
        $email = $this->input->post("userEmail");
        if ($type == 'user') {
            $first_name = $this->input->post("fname");
            $last_name = $this->input->post("lname");

            if ($this->input->post("newuserPassword") != '') {
                $password = $this->input->post("newuserPassword");
            } else {
                $password = $this->input->post("userPassword");
            }
            $userName = $this->input->post("userName");
        } else {
            $first_name = $this->input->post("userName");
            $last_name = '';
            $userName = $this->input->post("userName");
            $password = $this->input->post("googlepassword");
        }

        $siteurl = SITE_URL;
        $subject = $this->lang->line('admin_registration');
        $message = '';
        $message .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
        $message .= '<tr>';
        $message .= '<td height="26" style="font-family:Tahoma, Arial, sans-serif; font-size:11px;color:#575757;"><strong>' . $this->lang->line("admin_dear") . ucfirst($first_name) . '&nbsp;' . ucfirst($last_name) . '</strong></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td style="font-family:Tahoma, Arial, sans-serif; font-size:11px; color:#575757; line-height:15px; padding-bottom:10px;">' . $this->lang->line("admin_regisgration_successfully") . '</td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td height="5"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td align="left">';
        $message .= '<table width="287" border="0" bgcolor="#D23D3D" cellspacing="1" cellpadding="6" style="border:solid 3px #D23D3D;">';
        $message .= '<tr>';
        $message .= '<td colspan="2"><strong style="color:#FFF;">' . $this->lang->line("admin_login_info_label") . '</strong></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td bgcolor="#ffffff" width="100" style="font-family:Tahoma, Arial, sans-serif; font-size:12px;color:#575757;"><strong>' . $this->lang->line("admin_user_name_label") . '</strong></td>';
        $message .= '<td width="270" bgcolor="#ffffff" style="font-family:Tahoma, Arial, sans-serif; font-size:12px;color:#575757;">' . @$userName . '</td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td  bgcolor="#ffffff" style="font-family:Tahoma, Arial, sans-serif; font-size:12px;color:#575757;"><strong>' . $this->lang->line("admin_user_password_label") . '</strong></td>';
        $message .= '<td  bgcolor="#ffffff" style="font-family:Tahoma, Arial, sans-serif; font-size:12px;color:#575757;">' . @$password . '</td>';
        $message .= '</tr>';
        $message .= '</table>';
        $message .= '</td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td height="25" style="font-family:Tahoma, Arial, sans-serif; font-size:12px;color:#575757;">' . $this->lang->line("admin_user_click_label") . '<a href="' . $siteurl . '"> ' . $this->lang->line("admin_user_here_label") . '</a> ' . $this->lang->line("admin_user_tologin_label") . '</td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td height="25">&nbsp;</td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td height="25"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td style="font-family:Tahoma, Arial, sans-serif; font-size:12px;color:#575757;">' . $this->lang->line('admin_thanksandregards_label') . ',<br />';
        $message .= '<a href="' . NUMERA_SITE . '">' . $this->config->item('siteName') . '</a><br />';
        $message .= '</td>';
        $message .= '</tr>';
        $message .= '</table>';
        $body = getNotificationTheme($subject, '<font style="font-size:16px;">' . $this->lang->line("admin_welcome_label") . '<a href="' . NUMERA_SITE . '" style="color:#fff">' . $this->config->item('siteName') . '</a>!</font>', $message);
        $this->email->from($from);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($body);
        $this->email->set_mailtype('html');
        //pre($body);
        $this->email->send();
        return TRUE;
    }

    /**
     * @ Function Name		: _sendWelcomeMail
     * @ Function Params	: 
     * @ Function Purpose 	: sends mail to all user from admin side.
     * @ Function Returns	: 
     */
    private function _sendchangepwdMail($type) {
        $from = $this->session->userdata('admin_email');
        $email = $this->input->post("userEmail");
        if ($type == 'user') {
            $first_name = $this->input->post("fname");
            $last_name = $this->input->post("lname");
            $password = $this->input->post("newuserPassword");
            $userName = $this->input->post("userName");
        } else {
            $first_name = $this->input->post("userName");
            $last_name = '';
            $userName = $this->input->post("userName");
            $password = $this->input->post("googlepassword");
        }
        $name = $first_name;
        $loginName = $userName;

        $siteurl = NUMERA_SITE;
        $subject = $this->lang->line('change_password_notification_label');
        $message = '';
        $message .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
        $message .= '<tr>';
        $message .= '<td bgcolor="#951118" style="font-family:segoe UI, Arial, sans-serif; font-size:13px; color:#FFF; padding:6px 10px;">
				   <font style="font-size:15px;">' . $subject . '</font>
				</td>
			    </tr>';
        $message .= '<tr>';
        $message .= '<td valign="top" bgcolor="#ffffff" style="padding:12px;">
				      <table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
					    <td height="26" style="font-family:Tahoma, Arial, sans-serif; font-size:12px;color:#575757;">
						<strong>' . $this->lang->line("hi_label") . ' ' . ucfirst(@$name) . ',</strong>
					    </td>
					</tr>
					<tr>
					    <td style="font-family:Tahoma, Arial, sans-serif; font-size:11px; color:#575757; line-height:15px; padding-bottom:10px;font-size:12px;">' . $this->lang->line("login_info_notification_label") . '</td>
					</tr>';
        $message .='<tr>
					<td height="5">
					</td>
				    </tr>
				    <tr>
					<td align="left">
					    <table width="287" border="0" bgcolor="#D23D3D" cellspacing="1" cellpadding="6" style="border:solid 3px #D23D3D;">
						<tr>
						    <td colspan="2">
							<strong style="color:#FFF;">' . $this->lang->line("admin_login_info_label") . '</strong>
						    </td>
						</tr>
						<tr>';
        $message .= '<td bgcolor="#ffffff" width="100" style="font-family:Tahoma, Arial, sans-serif; font-size:12px;color:#575757;"><strong>' . $this->lang->line("admin_user_name_label") . '</strong></td>';
        $message .= '<td width="270" bgcolor="#ffffff" style="font-family:Tahoma, Arial, sans-serif; font-size:12px;color:#575757;">' . @$loginName . '</td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td  bgcolor="#ffffff" style="font-family:Tahoma, Arial, sans-serif; font-size:12px;color:#575757;"><strong>' . $this->lang->line("admin_user_password_label") . '</strong></td>';
        $message .= '<td  bgcolor="#ffffff" style="font-family:Tahoma, Arial, sans-serif; font-size:12px;color:#575757;">' . @$password . '</td>';
        $message .= '</tr>';
        $message .='</table>';
        $message .='</td>
					</tr>
					<tr>
					    <td height="25">&nbsp;</td>
					</tr>
					<tr>';
        $message .='<td>
				    </td>
				</tr>
				<tr>
				    <td height="25"></td>
				</tr>
				<tr>
				    <td height="25"></td>
				</tr>
				<tr style="color:black;">';
        $message .= '<td>' . $this->lang->line('admin_thanksandregards_label') . ',<br />';
        $message .= '<a href="' . NUMERA_SITE . '">' . $this->config->item('siteName') . '</a><br />';
        $message .= '</td></tr>';
        $message .= '</table>';
        $message .= '</tr>';
        $message .= '</table>';
        $body = getNotificationTheme($siteurl . $subject, $message, '');
        $this->email->from($from);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($body);
        $this->email->set_mailtype('html');
        //pr($body);
        $this->email->send();
        return TRUE;
    }


    function view_message() {
        $this->load->model('adminmodel');

	/*Set Flage 1 for Read a message*/
	$this->adminmodel->set_message_readed($_GET['msgid']);
        //page title
        $data['title'] = 'Message';
        $data['message'] = $this->adminmodel->getMessage($_GET['msgid']);
        $this->load->view('admin/message', $data);
    }


    

    function download_file($filename) {
        $this->load->helper('download');
        $data = file_get_contents('./uploads/attachment/' . $filename); // Read the file's contents
        $name = $filename;
        force_download($name, $data);
    }

    function getAllUsers_byClientID() {
        $this->load->model('adminmodel');
        if (isset($_POST['clientid']) && $_POST['clientid'] != '') {
            $users = $this->adminmodel->getAllUsers_byClientID($_POST['clientid']);
        } else {
            $users = $this->adminmodel->getAllUsers();
        }
        $html = '';
        $html .= '<select class="select" name="user">
                                <option value="">Select User</option>';
        foreach ($users as $key => $val) {
            $html .= '<option value="' . $val['id'] . '">' . $val['fname'] . ' ' . $val['lname'] . '</option>';
        }
        $html .= '</select>';
        echo $html;
    }
    
    
	/******GV******/

    function messagebox() {
	isAdminAuthorize(); /* checked is admin login or not */
        if (!$this->session->userdata('loggedInAdmin'))
            redirect('admin');
        $this->load->model('adminmodel');
        //page title
        $data['title'] = 'Inbox';
        $data['menu'] = '9';
        $data['submenu'] = '9a';

        // get Inbox count
        $msgCount = $this->adminmodel->getAllInboxCount();
        $this->load->library('pagination');

        $config['base_url'] = base_url() . 'admin/messagebox/';
        $config['total_rows'] = $msgCount;
        $config['per_page'] = PER_PAGE_RECORD;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);

        $data['count'] = $page + 1;

        $data['inbox_message'] = $this->adminmodel->getPaginatedInboxMsg($config["per_page"], $page);

        $this->load->view('admin/message_inbox', $data);
    }

      function msg_history(){
            isAdminAuthorize(); /* checked is admin login or not */
        if (!$this->session->userdata('loggedInAdmin'))
            redirect('admin');

            $this->load->model('adminmodel');

            /* Get All msg history */
          
            //$data['users'] = $this->adminmodel->getAllUsers();
            
            $record = $this->adminmodel->getUserReplyDetail($this->uri->segment(3));
            $data['user_id'] = $record['user_id'];
            $data['subject'] = $record['subject'];
          
            //page title  
            $data['title'] = 'Message History';

            $data['reply_id'] = $this->uri->segment(3);

            $data['message'] = $this->adminmodel->getHistoryMsgByUser($this->uri->segment(3));
            
            $this->load->view('admin/message_history', $data);
    
        
    }

    function composeMessage() {
	ob_start();
        isAdminAuthorize(); /* checked is admin login or not */
        if (!$this->session->userdata('loggedInAdmin'))
            redirect('admin');
        $this->form_validation->set_rules('user', 'user', 'required');
        $this->form_validation->set_rules('subject', 'subject', 'required|trim');
        $this->form_validation->set_rules('message', 'message', 'required|trim');

        $this->form_validation->set_message('user', 'Please select user');
        $this->form_validation->set_message('subject', 'Fill message subject');
        $this->form_validation->set_message('message', 'Fill message content');


        if ($this->form_validation->run() == false) {
            $this->load->model('adminmodel');

            /* Get All Client List */
            $data['clientlist'] = $this->adminmodel->totolNumberofuser('2', 'client');

            $data['users'] = $this->adminmodel->getAllUsers();
            //page title
            $data['title'] = 'Add Message';
            $data['menu'] = '9';
            $data['submenu'] = '9c';
            $this->load->view('admin/add_message', $data);
        } else {

            // check for upload file---------------------------upload attached file in folder if any
            $uploaded_data['upload_data']['file_name'] = '';
            if (@$_FILES['attach']['name'] != '') {
                $uploaded_data = $this->do_file_upload('attachment/', 'attach');
            }
	    $insert_msg = array('user_id' => $this->input->post('user'),
                'subject' => $this->input->post('subject'),
                'message' => $this->input->post('message'),
                'attachment' => $uploaded_data['upload_data']['file_name'],
                'message_type' => 'outbox',
                'created_date' => date('Y-m-d H:i:s'),
                'notification_flag' => 0,
                'receiver' => $this->input->post('user')
            );

            $insertID = $this->adminmodel->addMessage($insert_msg);

            if ($insertID) {

                // get email of user

                $userinfo = $this->adminmodel->getUserEmailByID($this->input->post('user'));
		
	/*Get reciever Email Id */
		$this->load->model('usermodel');
		$recieverDetail='';
		$toEmail='';
		$toUser='';
		$recieverId=$this->input->post('user');
		
		if($recieverId=='0'){ $recieverId=1;}		
		$recieverDetail=$this->usermodel->getUserDetails($recieverId);
	 	//pr($recieverDetail);
		if($recieverDetail){
		   $toEmail = $recieverDetail->userEmail;
		   $toUser = $recieverDetail->userName;  
		}
		$subject = $this->input->post('subject');
                $data_msg_desc = 'You have one new message in your numera account.<br/><br/> Please <a href="'.base_url().'numera">click here </a> to view you message.<br/><br/><b>From : Administrator</b> ';	
		    $dataArray=array(
				'ToEmail'=>$toEmail,
				'subject'=>$subject,
				'userName'=>$toUser,
				'message'=>$data_msg_desc,						
				);
			/*$dataArray=array(
				'ToEmail'=>'brijendra.s@cisinlabs.com',
				'subject'=>'Welcome-msg',
				'userName'=>'jitendra',
				'message'=>'Welcome to numera',						
				);*/
		    /*Send Email*/		
		    $this->email_notification_admin($dataArray);

                
                $this->session->set_flashdata('message', '<div class="alert-success">Message sent successfully. </div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert-error">Your message is not sent, please try again!</div>');
            }
	    ob_flush();	
            redirect('admin/messagebox');
        }
    }	

    //admin reply function
    function replyMessage() {
        isAdminAuthorize(); /* checked is admin login or not */
        if (!$this->session->userdata('loggedInAdmin'))
            redirect('admin');

        $this->form_validation->set_rules('message', 'message', 'required');
       
        $this->form_validation->set_message('message', 'Please write some reply');
   

        if ($this->form_validation->run() == false) {
            $this->load->model('adminmodel');

            //page title
            $data['title'] = 'Message History';
            $data['menu'] = '9';
            $data['submenu'] = '9c';
            $this->load->view('admin/message_history', $data);
        } else {

            // check for upload file---------------------------upload attached file in folder if any
            $uploaded_data['upload_data']['file_name'] = '';
            if (@$_FILES['attach']['name'] != '') {
                $uploaded_data = $this->do_file_upload('attachment/', 'attach');
            }
			
	    /*Get reciever Email Id */
		$this->load->model('usermodel');
		$recieverDetail='';
		$toEmail='';
		$toUser='';
		$recieverId=$this->input->post('user_id');
			
		if($recieverId=='0'){ $recieverId=1;}		
		$recieverDetail=$this->usermodel->getUserDetails($recieverId);
	 	//pr($recieverDetail);
		if($recieverDetail){
		   $toEmail = $recieverDetail->userEmail;
		   $toUser = $recieverDetail->userName;  
		}		
            $insert_msg = array('user_id' => $this->input->post('user_id'),
                'subject' => $this->input->post('subject'),
                'message' => $this->input->post('message'),
                'attachment' => $uploaded_data['upload_data']['file_name'],
                'message_type' => 'outbox',
                'reply_id' => $this->input->post('reply_id'),
                'created_date' => date('Y-m-d H:i:s')
            );
            $insertID = $this->adminmodel->addMessage($insert_msg);
            if ($insertID) {
                // get email of user
                $userinfo = $this->adminmodel->getUserEmailByID($this->input->post('user'));
		$subject = 'Reply :'.$this->input->post('subject');
                $data_msg_desc = 'You have one new message in your numera account.<br/><br/> Please <a href="'.base_url().'numera">click here </a> to view you message.<br/><br/><b>From : Administrator</b> ';	
		    /*$dataArray=array(
				'ToEmail'=>'brijendra.s@cisinlabs.com',
				'subject'=>'tsubt',
				'userName'=>'tunm',
				'message'=>'tmssge test test',						
				); */

$dataArray=array(
				'ToEmail'=>$toEmail,
				'subject'=>$subject,
				'userName'=>$toUser,
				'message'=>$data_msg_desc,						
				);
	
		    /*Send Email*/		
		    $this->email_notification_admin($dataArray);

                $this->session->set_flashdata('message', '<div class="alert-success">Message sent successfully. </div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert-error">Your message is not sent, please try again!</div>');
            }

            redirect('admin/msg_history/'.$this->input->post('reply_id'), 'refresh');
        }
        $this->load->model('adminmodel');
       }

	public function email_notification_admin($dataArray){
		$this->load->library('email');	
		$from = $this->config->item('adminEmail');
		$to = $dataArray['ToEmail'];
		//$to='brijendra.s@cisinlabs.com';
		$loginName =$dataArray['userName'];
		$siteURL = NUMERA_SITE;
		$subject = $dataArray['subject']; 
		$message_desc = $dataArray['message'];
		$message ='';
		$message .='<tr>
				<td bgcolor="#2182B7" style="font-family:segoe UI, Arial, sans-serif; font-size:13px; color:#FFF; padding:6px 10px;">
				   <font style="font-size:15px;"> Subject : ' . $subject . '</font>
				</td>
			    </tr>';
		$message .= '<tr>';
		$message .= '<td valign="top" bgcolor="#ffffff" style="padding:12px;">
				      <table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
					    <td height="26" style="font-family:Tahoma, Arial, sans-serif; font-size:12px;color:#575757;">
						<strong> Hello '.ucfirst(@$loginName).',</strong>
					    </td>
					</tr>
					<tr>
					    <td style="font-family:Tahoma, Arial, sans-serif; font-size:11px; color:#575757; line-height:15px; padding-bottom:10px;font-size:12px;">'.$message_desc.'</td>
					</tr>';
		$message .='<tr>
					<td height="5">
					</td>
				    </tr>
				    <tr>
					<td align="left">';
		$message .='</td>
					</tr>
					<tr>
					    <td height="25">&nbsp;</td>
					</tr>
					<tr>';
		$message .='<td>
				    </td>
				</tr>
				<tr>
				    <td height="25"></td>
				</tr>
				<tr style="color:black;">

				';
		$message .= '<td>Thanks and regards,<br />';
		$message .= '<a href="' . NUMERA_SITE. '">' . $this->config->item('siteName') . '</a><br />';
		$message .= '</td></tr>';
		$message .= '</table>';
		$message .= '</tr>';
		$body = getNotificationTheme($siteURL . $subject, $message, '');
		$this->email->from($this->session->userdata('userEmail'), $this->session->userdata('userName'));
		//$ufrom=$this->session->userdata('userEmail'), $this->session->userdata('userName');
		$headers= 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";	
		mail($to,$subject,$body,$headers);
		//echo "Mail Sent.";
		//pr($body);
		return TRUE;
    }

}

/* End of file welcome.php */
    /* Location: ./application/controllers/welcome.php */

    
