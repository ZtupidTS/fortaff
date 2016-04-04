<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends MY_Controller {

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

        //$this->load->library('googleplus');
    }

    /*     * ************* start of public functions ****************** */

    /**
     * @ Function Name		: index
     * @ Function Purpose 	: homepage functionality is written in this
     * @ Function Returns	: 
     */
    public function index() {
        if ($this->session->userdata('loggedInUser')) {
            //print_r($this->session->all_userdata());
            //$this->data['title'] = 'Home';
            //$this->data['selected'] = 'alldocs';
            redirect('/users/alldocs');
            //$this->load->view('users/alldocs'); 
        } else {
            redirect('/users/login');
        }
    }

    /**
     * @ Function Name		: login
     * @ Function Purpose 	: to display the login page on frontend
     * @ Function Returns	: 
     */
    public function login() {
        if (!empty($this->_userdata)) {
            redirect('users/');
        };
        $this->form_validation->set_rules('username', 'Username', 'required|callback_usernameRegex');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('users/login');
        } else {
            if (isset($_POST) && (!empty($_POST))) {

                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $chkRememberMe = $this->input->post('chk_remember_me');
                $chkRememberMe = $chkRememberMe == 'on' ? true : false;

                /* Google drive functionality */
                if (preg_match("/^[^@]*@[^@]*\.[^@]*$/", $username)) {
                    //echo 'email format';/*For client only*/
                    $data['getuserDetail'] = $this->usermodel->checkClientCredential($username, $password);
                } else {
                    //echo 'string is not email formate'; /*For users only*/
                    $password_cookees = $password;
                    $password = md5($password);
                    $data['getuserDetail'] = $this->usermodel->checkUserCredential($username, $password);
                }

                /* Refresh token is exit ot not */
                $clientEmailarray = $this->usermodel->getGoogleEmailbyId($data['getuserDetail']['clientId']);
                $email = $clientEmailarray['email'];
                $resultArray = $this->usermodel->getAccesrefreshToken($email);

                /* Get full logged in user or client detail */
                if (count($data['getuserDetail']) > 0 && !empty($data['getuserDetail']) && $data['getuserDetail']['userId'] && @$data['getuserDetail']['userRoleId'] == 3) {
                    //pr($resultArray);
                    if (empty($resultArray['refreshToken'])) {
                        $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('refresh_token_not_found') . '</div>');
                        redirect('users/login');
                        exit;
                    }
                    $userid = $data['getuserDetail']['userId']; /* User id */

                    /* Set defualt languge as per client login */
                    if (isset($data['getuserDetail']['userlanguage'])) {
                        $defaultlang = $data['getuserDetail']['userlanguage'];
                    } else {
                        $defaultlang = 'english';
                    }
                    $this->session->set_userdata('language', $defaultlang);

                    $data['userLoggedInDetail'] = $this->usermodel->getloggedinUserDetailbyId($userid);
                    //pre($data['userLoggedInDetail']);
                    $clientrootfolder = $this->usermodel->getclientparentfolder($data['userLoggedInDetail']['clientId']);

                    /* Set user client parent folder id */
                    $data['userLoggedInDetail']['parentfolderid'] = $clientrootfolder['googlefolderId'];
                    $data['userLoggedInDetail']['userparentfolderid'] = $clientrootfolder['parentId'];
                    $data['userLoggedInDetail']['dbparentfolderid'] = $clientrootfolder['id'];

                    //pr($data['userLoggedInDetail']);
                    $usrpermissionfolder = $data['userLoggedInDetail']['folderpermissions'];
                    //pr($usrpermissionfolder);
                    $userfolderpermissoin = json_decode($usrpermissionfolder);
                    //pre($userfolderpermissoin);
                    $data['userLoggedInDetail']['userfolderpermissoin'] = $userfolderpermissoin;
                    //pre($data['userLoggedInDetail']);    
                    //Check permissions
                    if (isset($data['userLoggedInDetail']['userId'])) {
                        $session_array = array(
                            'userid' => $data['userLoggedInDetail']['userId'],
                            'loggedInUser' => TRUE,
                            'sess_refresh_token' => $resultArray['refreshToken']
                        );
                        $data = array_merge($session_array, $data['userLoggedInDetail']);

                        $this->session->set_userdata($data);

                        // Rubina
                        // store notification count in session array so that user can see notification in all pages
                        if (isset($data['userLoggedInDetail']['userRoleId']) && $data['userLoggedInDetail']['userRoleId'] == 3) {
                            //get unread notification of login user
                            $userid = $data['userLoggedInDetail']['userId'];
                            $notification_count = $this->usermodel->getNotificationCountByUserid($userid);

                            $notification_array = array(
                                'notification_count' => $notification_count
                            );
                            $data = array_merge($notification_array, $data['userLoggedInDetail']);
                            //pr($data);
                            $this->session->set_userdata($data);
                        }
                        //pr($data);
                    }


                    //setting user credential in cookies
                    if ($chkRememberMe === true) {

                        $this->input->set_cookie('user_name', $username, '86500', '', '/', '');
                        $this->input->set_cookie('user_pass', $password_cookees, '86500', '', '/', '');
                    } else if ($chkRememberMe === false) {
                        $this->input->set_cookie('user_name', '', '86500', '', '/', '');
                        $this->input->set_cookie('user_pass', '', '86500', '', '/', '');
                    }
                    redirect('/users/alldocs');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('username_password_not_exsit') . '</div>');
                    redirect('users/login');
                }
            }
            $this->data['title'] = 'Login';
            $this->load->view('users/login', $data);
        }
    }

    function usernameRegex($str = '') {
        if (!preg_match("/^([-a-z0-9_ ])+$/i", $str)) {
            $this->form_validation->set_message('usernameRegex', $this->lang->line('alpha_numeric_label'));
            return FALSE;
        } elseif ($str != null) {
            $statusresult = $this->usermodel->userstatus($str);
            if ($statusresult) {
                $this->form_validation->set_message('usernameRegex', $this->lang->line('user_deactive_msg'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }

    /**
     * @ Function Name	: myprofile
     * @ Function Purpose: display the myprofile page of user
     * @ Function Returns: 
     */
    public function profile() {
        $this->data['title'] = $this->lang->line('my_profile');
        if (empty($this->_userdata)) {
            $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('username_login_first') . '</div>');
            redirect('users/login');
        }
        if ($this->session->userdata('userid') && $this->session->userdata('userRoleId') == '3') {
            $userid = $this->session->userdata('userid');
            $this->data['userDetail'] = $this->usermodel->getloggedinUserDetailbyId($userid);
        } else {
            $clientid = $this->session->userdata('userid');
            $this->data['userDetail'] = $this->usermodel->getloggedinClientDetailbyId($clientid);
        }
        $this->data['selected'] = $this->lang->line('my_profile');
        $this->load->view('users/profile', $this->data);
    }

    /**
     * @ Function Name	: Update user iformation
     * @ Function Purpose 	: display the forgot password form to user to recover a password
     * @ Function Returns	: 
     */
    function manageuser() {
        $this->data['title'] = $this->lang->line('my_profile');
        if ($this->input->post('btnsubmit')) {
            if (!$this->session->userdata('userid')) {
                $this->form_validation->set_rules('userPassword', 'Password', 'required|min_length[8]|max_length[200]');
                $this->form_validation->set_rules('userEmail', 'Email', 'required|email|valid_email|is_unique[users.userEmail]');
                $this->form_validation->set_rules('userName', 'User name', 'required|min_length[3]|max_length[200]|is_unique[users.userName]');
            } else {
                $this->form_validation->set_rules('userEmail', 'Email', 'required|email|valid_email');
                $this->form_validation->set_rules('userName', 'User name', 'required|min_length[3]|max_length[200]');
            }

            $this->form_validation->set_rules('fname', 'First name', 'required|min_length[3]|max_length[25]');
            $this->form_validation->set_rules('lname', 'Last Name', 'required|min_length[3]|max_length[25]');
            $this->form_validation->set_rules('profession', 'Profession', 'required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('userPhone', 'Phone', 'required|integer');

            if ($this->form_validation->run() == false) {
                $data['clientId'] = $this->input->post('clientid');
                if (!$this->input->post('id')) {
                    $data['userDetail']['userPassword'] = $this->input->post('password');
                }
                $data['userDetail']['userEmail'] = $this->input->post('email');
                $data['userDetail']['userImage'] = $this->input->post('image');
                $data['userDetail']['fname'] = $this->input->post('fname');
                $data['userDetail']['lname'] = $this->input->post('lname');
                $data['userDetail']['profession'] = $this->input->post('profession');
                $data['upload_error'] = "";
                $this->load->view('users/profile', $data);
            } else {
                $error = $this->usermodel->update($task = 'user');
                if ($error == 'update') {
                    $this->session->set_flashdata('message', '<div class="alert-success">' . $this->lang->line('profile_update_label') . '</div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('profile_not_update_label') . '</div>');
                }
                redirect("users/profile");
            }
        } else {
            redirect("users/profile");
        }
    }

    /**
     * @ Function Name	: forgotPassword
     * @ Function Purpose 	: display the forgot password form to user to recover a password
     * @ Function Returns	: 
     */
    function forgotPassword() {

        $data['title'] = 'Forgot password';
        $this->form_validation->set_rules('email', 'Email', 'required|callback_userEmail_check');
        if ($this->form_validation->run() == false) {
            $this->load->view('users/forgotpassword', $data);
        } else {
            $useremail = $this->input->post('email');
            //die($this->form_validation->run());
            /* Check email id is valid or not */
            $userdetail = $this->usermodel->getUserDetailsByEmail($useremail);
            if (isset($userdetail) && !empty($userdetail)) {
                /* Check email id  is client email or user email */
                if (isset($userdetail->id)) {
                    $usergoogledetail = $this->usermodel->getUserGoogleidbyemail($useremail, $userdetail->id);
                }
                if (isset($usergoogledetail->email) && isset($userdetail->id)) { /* Client information */
                    $IsuserEamil = 'Client';
                    $getuserpassword = $usergoogledetail->password;
                    $name = $userdetail->userName;
                    $loginName = $usergoogledetail->email;
                } else {
                    /* User information */
                    $IsuserEamil = 'User';
                    $newuserpassword = str_rand();
                    $getuserpassword = $newuserpassword;
                    $name = $userdetail->userName;
                    $userId = $userdetail->id;
                    $loginName = $userdetail->userName;
                    $getresult = $this->usermodel->updatepassword($userId, md5($newuserpassword));
                }
                if (isset($IsuserEamil) && isset($getuserpassword)) {
                    //Send email body
                    $from = $this->config->item('adminEmail');
                    $to = $userdetail->userEmail;
                    $name = $name;
                    $loginName = $loginName;
                    $password = $getuserpassword;
                    $siteURL = NUMERA_SITE;
                    $subject = $this->lang->line("forgote_password_lbl");
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
									<strong>' . $this->lang->line("hi_label") . ' ' . ucfirst(@$name) . ',</strong>
								    </td>
								</tr>
								<tr>
								    <td style="font-family:Tahoma, Arial, sans-serif; font-size:11px; color:#575757; line-height:15px; padding-bottom:10px;">
								    ' . $this->lang->line('your_login_data_below') . '
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
										<strong style="color:#FFF;">' . $this->lang->line('login_information_label') . '</strong>
									    </td>
									</tr>
									<tr>';
                    $message .= '<td bgcolor="#ffffff" width="100" style="font-family:segoe UI, Arial, sans-serif; font-size:13px;" ><strong>' . $this->lang->line('admin_user_name_label') . '</strong></td>';
                    $message .= '<td width="270" bgcolor="#ffffff">' . @$loginName . '</td>';
                    $message .= '</tr>';
                    $message .= '<tr>';
                    $message .= '<td  bgcolor="#ffffff" style="font-family:segoe UI, Arial, sans-serif; font-size:13px; ><strong>' . $this->lang->line('admin_user_password_label') . '</strong></td>';
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
                    $message .= '<td>' . $this->lang->line('admin_thanksandregards_label') . ',<br />';
                    $message .= '<a href="' . NUMERA_SITE . '">' . $this->config->item('siteName') . '</a><br />';
                    $message .= '</td></tr>';
                    $message .= '</table>';
                    $message .= '</tr>';
                    $body = getNotificationTheme($siteURL . $this->lang->line("forgote_password_lbl"), $message, '');
                    $this->email->from($from);
                    $this->email->to($to);
                    $this->email->subject($siteURL . $this->lang->line("forgote_password_lbl"));
                    $this->email->message($body);
                    $this->email->set_mailtype('html');
                    //pr($body);
                    $this->email->send();
                    $this->session->set_flashdata('message', '<div class="alert-success">' . $this->lang->line('password_sent_label') . '</div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('password_not_sent_label') . '</div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('email_not_exist_label') . '</div>');
            }
            redirect('users/forgotpassword');
            //$this->load->view('admin/forgotepassword',$data);
        }
    }

    public function logout() {

        $this->session->unset_userdata();
        $this->session->sess_destroy();
        $this->_userdata = '';
        redirect('/');
    }

    /**
     * @ Function Name	: changePassword
     * @ Function Purpose 	: change the password of user with previous password check
     * @ Function Returns	: 
     */
    public function changepassword() {
        if (empty($this->_userdata)) {
            $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('username_login_first') . '</div>');
            redirect('users/login');
        }
        //pr($this->session->userdata('userId'));
        $data['title'] = $this->lang->line('changepwd_lable');
        $this->form_validation->set_rules('userPassword', 'Old password', 'required|callback_currentpwdchk');
        $this->form_validation->set_rules('updatepassword', 'New Password', 'required|callback_newpasswordchk');
        $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('users/changepassword', $data);
        } else {

            $uid = $this->session->userdata('userId');
            $getuserDetails = $this->usermodel->getloggedinUserDetailbyId($uid);
            //pr($getuserDetails);
            $username = $getuserDetails['userName'];
            $useremail = $getuserDetails['userEmail'];
            $newuserpwd = $this->input->post('updatepassword');
            /* update password */
            $getresult = $this->usermodel->updatepassword($uid, md5($newuserpwd));
            //die();
            if ($getresult) {
                //Send email body
                $from = $this->config->item('adminEmail');
                $to = $useremail;
                $name = $getuserDetails['fname'] . ' ' . $getuserDetails['lname'];
                $loginName = $username;
                $password = $newuserpwd;
                $siteURL = NUMERA_SITE;
                $subject = $this->lang->line("change_password_notification_label");
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
					    <tr style="color:black;">
		    
					    ';
                $message .= '<td>' . $this->lang->line('admin_thanksandregards_label') . ',<br />';
                $message .= '<a href="' . NUMERA_SITE . '">' . $this->config->item('siteName') . '</a><br />';
                $message .= '</td></tr>';
                $message .= '</table>';
                $message .= '</tr>';
                $body = getNotificationTheme($siteURL . $subject, $message, '');
                $this->email->from($from);
                $this->email->to($to);
                $this->email->subject($siteURL . $subject);
                $this->email->message($body);
                $this->email->set_mailtype('html');
                //pr($body);
                $this->email->send();
                $this->session->set_flashdata('message', '<div class="alert-success">' . $this->lang->line('password_change_label') . '</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('password_not_change_label') . '</div>');
            }
            //echo $this->email->print_debugger();			
            redirect('users/changepassword', 'refresh');
        }
    }

    function currentpwdchk($str) {
        //pre($str);
        //pre($this->session->userdata);
        $uid = $this->session->userdata('userId');
        $data['users'] = $this->usermodel->checkusrpwdxist(md5($str), $uid);
        //echo md5($str);
        //pr($data['users']);
        if (md5($str) != @$data['users']['userPassword']) {
            $this->form_validation->set_message('currentpwdchk', $this->lang->line('password_not_match_label'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function newpasswordchk($str) {
        //pr($str);
        if ($str != $this->input->post('confirmPassword')) {
            $this->form_validation->set_message('newpasswordchk', $this->lang->line('crn_password_new_pwd_not_match_label'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * @ Function Name		: alldocs
     * @ Function Purpose 	: display the myprofile page of user
     * @ Function Returns	: 
     */
	// public function alldocs() {
//
//        if (empty($this->_userdata)) {
//            $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('username_login_first') . '</div>');
//            redirect('users/login');
//        }
//
//        $this->data['selecttop'] = "alldocs";
//        $this->data['title'] = $this->lang->line('all_docs');
//        $this->data['user_folders_list'] = null;
//        try {
//            $client = $this->google_client;
//            $client->setAccessToken($this->session->userdata('accessToken'));
//            $service = new Google_DriveService($client);
//
//            /* Call function to check folder is exist or not */
//            //$this->checkfolderIsexistorNot(); 
//
//            if ($this->session->userdata('userRoleId') == '3') { /* User folder list */
//                $user_folders = $this->usermodel->getUserdocumentbyId();
//                if (isset($user_folders->folderpermissions) && !empty($user_folders->folderpermissions)) {
//                    $user_folders_array = json_decode($user_folders->folderpermissions);
//                    if (!empty($user_folders_array)) {
//                        foreach ($user_folders_array as $ky => $val) {
//                            $folderId_array[] = $ky;
//                        }
//                        /* Get user folder list which allot permissons */
//                        $this->data['user_folders_list_db'] = $this->usermodel->getuserfolderlist($folderId_array);
//                    }
//                }
//            } else {
//                /* Client folder list */
//                /* Get user folder list which allot permissons */
//                $clientid = $this->session->userdata('userid');
//                $this->data['user_folders_list'] = $this->usermodel->getclientfolderlist($clientid);
//            }
//
//            /* Get only folder */
//            $this->data['user_folders_list'] = printFilesInFolder($service, $this->session->userdata('parentfolderid'));
//
//            /* Get all folder from database */
//            foreach ($this->session->userdata['userfolderpermissoin'] as $ufkey => $ufval) {
//                $selected_ufkey[] = $ufkey;
//            }
//
//            //pre($selected_ufkey_array);
//            $db_folder_array = $this->usermodel->getuserfolderlist($selected_ufkey);
//            foreach ($db_folder_array as $dbkey => $dbval) {
//                $folders_in_files[$dbkey] = test_retrieveFiles($service, $dbval['googlefolderId']);
//            }
//            foreach ($folders_in_files as $folderkey => $folderval) {
//                if (is_array($folderval)) {
//                    foreach ($folderval as $filfeVal) {
//                        $fileparentId[$folderkey] = $filfeVal->parents[0]->id;
//                    }
//                } else {
//                    $fileparentId[$folderkey] = $folderval->parents[0]->id;
//                }
//            }
//
//            /* Get only files */
//            if (isset($fileparentId)) {
//                foreach ($fileparentId as $fileval)
//                    $foldersfile[] = printFile($service, $fileval);
//            }
//            //pre($foldersfile);
//            if (isset($foldersfile)) {
//                $this->data['user_files_list'] = $foldersfile;
//            } else {
//                $this->data['user_files_list'] = null;
//            }
//            //pr($this->data['user_files_list']);
//            /* Get only */
//        } catch (Exception $e) {
//            $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('google_client_not_valid_email') . '</div>');
//        }
//        $foldersessionarray = $this->session->userdata('userfolderpermissoin');
//        //pre($foldersessionarray);
//        if (isset($this->data['user_folders_list_db'])) {
//            foreach ($this->data['user_folders_list_db'] as $akey => $aval) {
//                foreach ($foldersessionarray as $obkey => $obval) {
//                    if ($aval['id'] == $obkey) {
//                        $mergray[$akey] = $aval;
//                        $mergray[$akey][] = $obval;
//                    }
//                }
//            }
//            if (isset($mergray)) {
//                $this->data['visiblefolders'] = $mergray;
//            }
//        } else {
//            $this->data['visiblefolders'] = null;
//        }
//        //pre($mergray);	    
//
//        $this->data['selected'] = 'alldocs';
//        $this->load->view('users/alldocs', $this->data);
//    }
    public function alldocs() {
        if (empty($this->_userdata)) {
            $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('username_login_first') . '</div>');
            redirect('users/login');
        }
        //pre($this->session);

        $this->data['selecttop'] = "alldocs";
        $this->data['title'] = $this->lang->line('all_docs');
        $this->data['user_folders_list'] = null;
        try {
            $client = $this->google_client;
            $client->setAccessToken($this->session->userdata('accessToken'));
            $service = new Google_DriveService($client);

            /* Call function to check folder is exist or not */
            //$this->checkfolderIsexistorNot(); 

            if ($this->session->userdata('userRoleId') == '3') { /* User folder list */
                //echo 'welcome';    
                $user_folders = $this->usermodel->getUserdocumentbyId();
                if (isset($user_folders->folderpermissions) && !empty($user_folders->folderpermissions)) {
                    $user_folders_array = json_decode($user_folders->folderpermissions);
                    if (!empty($user_folders_array)) {
                        foreach ($user_folders_array as $ky => $val) {
                            $folderId_array[] = $ky;
                        }
                        /* Get user folder list which allot permissons */
                        $this->data['user_folders_list_db'] = $this->usermodel->getuserfolderlist($folderId_array);
                    }
                }
            } else {
                /* Client folder list */
                /* Get user folder list which allot permissons */
                $clientid = $this->session->userdata('userid');
                $this->data['user_folders_list'] = $this->usermodel->getclientfolderlist($clientid);
            }
	    //pre($this->data['user_folders_list_db']);
	    
		$all_folder_arry = array();	
	
	   foreach($this->data['user_folders_list_db'] as $val){
		$all_folder_arry[$val['googlefolderId']] =  $val;
	   }	
	 // pr($all_folder_arry);


            $foldersessionarray = $this->session->userdata('userfolderpermissoin');
            //pre($foldersessionarray);
            if (isset($this->data['user_folders_list_db'])) {
                foreach ($this->data['user_folders_list_db'] as $akey => $aval) {
                    foreach ($foldersessionarray as $obkey => $obval) {
                        if ($aval['id'] == $obkey) {
                            $mergray[$akey] = $aval;
                            $mergray[$akey][] = $obval;
                        }
                    }
                }
                if (isset($mergray)) {
                    $this->data['visiblefolders'] = $mergray;
                }
            } else {
                $this->data['visiblefolders'] = null;
            }
            //pre($this->data['visiblefolders']);
            /* Get only folder */
            $this->data['user_folders_list'] = printFilesInFolder($service, $this->session->userdata('parentfolderid'));

            foreach ($this->session->userdata['userfolderpermissoin'] as $ufkey => $ufval) {
                $selected_ufkey[] = $ufkey;
            }

            $folderHavinfFiles = array();		
	    
           

            $db_folder_array = $this->usermodel->getuserfolderlist($selected_ufkey); /*List of folder who is view to users*/
	    //pre($db_folder_array);
            foreach ($db_folder_array as $dbkey => $dbval) {
                //$folders_in_files[$dbkey] = test_retrieveFiles($service, $dbval['googlefolderId']);
		$file_result = test_retrieveFiles($service, $dbval['googlefolderId']);
		//pre($file_result);
		//if(is_array($file_result) && $file_result->parents[1]['id']==$dbval['googlefolderId']){
		
		if(is_array($file_result) && !empty($file_result[0]->parents)){
			$folderHavinfFiles[] = $dbval['googlefolderId'];
			//$folderParentArry[$dbval['googlefolderId']] = $file_result->parents[1]['id'];
		}

            }

	    	
	   
	   //pre($all_folder_arry[$val['googlefolderId']]	);
//pre($folderParentArry);	
            /* Get only files */
	  //  echo count($fileparentId);
            if (isset($folderHavinfFiles)) {
                foreach ($folderHavinfFiles as $fileval){

		    $folderContentArry = printFile($service, $fileval);
//pr($folderContentArry);
		  $parentfolder_id = $folderContentArry->parents[0]->id;
			
		    if(!in_array($parentfolder_id,$folderHavinfFiles)){
			//if($all_folder_arry[$val['googlefolderId']['folderLevel']==1]){ //6 -12 -2014
			//echo $all_folder_arry[$val['googlefolderId']]['folderLevel'];
			$foldersfile[] = $folderContentArry;	
		    	//}
		     }
                    
		}
		//pr($foldersfile);

            }
		
		//echo count($foldersfile);
            
            if (isset($foldersfile)) {
                $this->data['user_files_list'] = $foldersfile;
            } else {
                $this->data['user_files_list'] = null;
            }
            //pr($this->data['user_files_list']);
            /* Get only */
        } catch (Exception $e) {
            $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('google_client_not_valid_email') . '</div>');
        }
        
	
        //pre($mergray);	    
	count($this->data['visiblefolders']);
        $this->data['selected'] = 'alldocs';
        $this->load->view('users/alldocs', $this->data);
    }

    public function checkfolderIsexistorNot() {
        $clientid = $this->session->userdata('clientId');
        if (empty($clientid)) {
            return false;
        }
        $allfolders = $this->usermodel->getallfolders($clientid, null);

        $checkcomp = false;
        if (count($allfolders) > 0) {
            $allfolders[0]['googlefolderId'];
            try {
                $client = $this->google_client;
                $client->setAccessToken($this->session->userdata('accessToken'));
                $service = new Google_DriveService($client);
                //pre($allfolders );
                foreach ($allfolders as $folder) {
                    try {
                        $file = $service->files->get($folder['googlefolderId']);
                    } catch (Exception $e) {
                        $file = '';
                    }
                    if ($file->labels->trashed == 1 || empty($file)) {
                        //pr($file);
                        $parentfolder = $this->usermodel->getallfolders($folder['parentId'], 'parentId');
                        $parentId = $parentfolder[0]['googlefolderId'];
                        /* Create a folder */
                        $description = 'new folder in' . $folder['folderName'];
                        $mimeType = "application/vnd.google-apps.folder";
                        $filename = $folder['folderName'];
                        $title = $folder['folderName'];
                        $return = insertFile($service, $title, $description, $parentId, $mimeType, $filename);
                        $googlefolderid = $return->id;
                        $this->usermodel->updategooglefolderkey($folder['id'], $googlefolderid);
                    }
                }
                $checkcomp = true;
            } catch (Exception $e) {
                
            }
        }
        if ($checkcomp) {
            $this->session->set_userdata('checkFold', true);
            //$uid=$this->session->userdata('userId');
            //$this->usermodel->textcode($uid);
        }
    }

    /**
     * @ Function Name		: fileListing
     * @ Function Purpose 	: File list as per user folder
     * @ Function Returns	: 
     */
    public function fileListing($id) {

	//pre($_POST);
        $filesArray = array();
        if (empty($this->_userdata)) {
            $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('username_login_first') . '</div>');
            redirect('users/login');
        }


        $this->data['title'] = $this->lang->line('all_files_lbl');
        $client = $this->google_client;
        $client->setAccessToken($this->session->userdata('accessToken'));
        $service = new Google_DriveService($client);
        $user = $this->session->userdata('email');


        if ($this->session->userdata('userRoleId') == '3') { /* User folder list */
            $user_folders = $this->usermodel->getUserdocumentbyId();
            if (isset($user_folders->folderpermissions) && !empty($user_folders->folderpermissions)) {
                $user_folders_array = json_decode($user_folders->folderpermissions);
                if (!empty($user_folders_array)) {
                    foreach ($user_folders_array as $ky => $val) {
                        $folderId_array[] = $ky;
                    }
                    /* Get user folder list which allot permissons */
                    $this->data['user_folders_list_db'] = $this->usermodel->getuserfolderlist($folderId_array);
                }
            }
        }

        $foldersessionarray = $this->session->userdata('userfolderpermissoin');
        //pre($foldersessionarray);	
        foreach ($this->data['user_folders_list_db'] as $akey => $aval) {
            foreach ($foldersessionarray as $obkey => $obval) {
                if ($aval['id'] == $obkey) {
                    $mergray[$akey] = $aval;
                    $mergray[$akey][] = $obval;
                }
            }
        }
        $this->data['visiblefolders'] = $mergray;

        /* Show all files with folder */
 	if (isset($_GET['search']) && $_GET['search'] != null) {
		//echo 'sarch';
		$this->data['user_file_list'] = getSearchFilesInFolder($service, $id);
	}else{
		//echo 'not search';
        	$this->data['user_file_list'] = getAllFilesInFolder($service, $id);
	}

	$filesArray = $this->data['user_file_list'];	
	
	///pr($this->data['user_file_list']);
	/*
        if (isset($this->data['user_file_list'])) {
            foreach ($this->data['user_file_list'] as $files) {
                $filesArray[] = printFile($service, $files->id);
            }
        }
	*/

        /* Watch file */
        if (isset($_GET['watch']) && $_GET['watch'] != null) {
            $this->data['downloadlink'] = $_GET['watch'];
            //pr($rs);
        }


        /* Search file */
        if (isset($_GET['search']) && $_GET['search'] != null) {
            $foldersarray = $this->input->post('searchfileid');
            //pr($foldersarray);

            foreach ($foldersarray as $srchfvalue) {
                //pre($srchfvalue);
                $fileidarray = explode(',', $srchfvalue);
                if ($fileidarray[1] == $id) {
                    $fileidarrayNew[] = $fileidarray[0];
                }
            }   
	//	pr($fileidarrayNew); 
            foreach ($this->data['user_file_list'] as $fkey => $fvalue) {
                foreach ($fileidarrayNew as $sfvalue) {
                    if ($sfvalue == $fvalue->id) {
                        $searachfilearray[$fkey] = $fvalue;
                    }
                }
            }

            $this->data['search_file_ids'] = $searachfilearray;
            //pr($rs);
            //pr($this->data['search_file_ids']);
        }
        /* end Search */

        /* Recent document */
	/* Recent document code here */
        /*if (isset($id)) {
            $filesdetail = $service->files->get($id);
            
            $array = array(
                'title' => $filesdetail->title,
                'doc_id' => $id,
                'doc_type' => $filesdetail->mimeType,
                'folder_id' => $filesdetail->parents[0]->id,
                'folder_name' => $filesdetail->title,
                'user_id' => $this->session->userdata('userid'),
                'action_description' => 'folder view by user',
            );
            $this->usermodel->saverecentfiles($array);
        }*/
        if (!empty($filesArray)) {
            $this->data['user_file_list'] = $filesArray;
        }
        // pr($this->data['user_file_list']);
        if (isset($id)) {
            $this->data['old_folder_id'] = $id;
        }
        $this->data['service'] = $service;
        $this->data['selected'] = 'alldocs';
        $this->load->view('users/allfiles', $this->data);
    }

    /* Call jquery function */

    public function ajaxsavrfolder($id) {
        $client = $this->google_client;
        $client->setAccessToken($this->session->userdata('accessToken'));
        $service = new Google_DriveService($client);
        $filearrray = retrieveOnlyFiles($service, null);
        foreach ($filearrray as $gfkey => $gfileval) {
            if ($gfileval->id == $id) {
                $filesdetail['filedetail'] = $gfileval;
            }
        }
        $saverecentdocArray = array(
            'title' => $filesdetail['filedetail']->title,
            'doc_id' => $id,
            'user_id' => $this->session->userdata('userid'),
        );
        $qryresponse = $this->usermodel->saverecentfolder($saverecentdocArray);
    }

    public function downloadFile_drive($fileid) {
        $client = $this->google_client;
        $client->setAccessToken($this->session->userdata('accessToken'));
        $service = new Google_DriveService($client);

        $filesdetail = $service->files->get($fileid);
        //pr($filesdetail);



        $prss = downloadFile($service, $filesdetail);
        if ($prss) {
            /* Recent document code here */
            $array = array(
                'title' => $filesdetail->title,
                'doc_id' => $fileId,
                'doc_type' => $filesdetail->mimeType,
                'folder_id' => $filesdetail->parents[0]->id,
                'folder_name' => '',
                'user_id' => $this->session->userdata('userid'),
                'action_description' => 'File Download by user',
            );
            $this->usermodel->saverecentfiles($array);
        }

        $this->load->helper('download');
        force_download($filesdetail->title, $prss);
        redirect('/users/alldocs');
        exit;
    }

    public function previewFile_drive($fileid) {
        $client = $this->google_client;
        $client->setAccessToken($this->session->userdata('accessToken'));
        $service = new Google_DriveService($client);

        $filesdetail = $service->files->get($fileid);


        $prss = downloadFile($service, $filesdetail);

        file_put_contents(APPPATH . '../uploads/temp_' . $filesdetail->title, $prss);

        //$this->load->helper('download');
        //force_download($filesdetail->title, $prss);
        //exit;

        /* Recent document */
        if (isset($fileid)) {
            $array = array(
                'title' => $filesdetail->title,
                'doc_id' => $filesdetail->id,
                'doc_type' => $filesdetail->mimeType,
                'folder_id' => $filesdetail->parents[0]->id,
                'folder_name' => '',
                'user_id' => $this->session->userdata('userid'),
                'action_description' => 'view file',
            );
            $this->usermodel->saverecentfiles($array);
        }
        $this->data['type'] = $filesdetail->mimeType;
        $this->data['file_name'] = 'temp_' . $filesdetail->title;
        $this->load->view('users/file_preview', $this->data);
    }

    /* Delete Ifram file */

    public function delete_preview_file($fname) {
        unlink(APPPATH . '../uploads/' . $fname);
        //return '1';
    }

    /**
     * @ Function Name		: getGoogleAccessToken
     * @ Function Purpose 	: Access gmail user and get access token of client
     * @ Function Returns	: 
     */
    public function getGoogleAccessToken($refreshToken = "") {
        $client = $this->google_client;
        if ($_SERVER['HTTP_HOST'] == "localhost") {
            $url = "http://localhost/numera/users/getGoogleAccessToken";
        } else {
            $url = "http://www.oneandsimple.com/numera/users/getGoogleAccessToken";
        }
        $client->setRedirectUri($url);
        $client->setScopes(array('https://www.googleapis.com/auth/drive'));
        $client->setAccessType('offline');
        if ($refreshToken) {
            $client->setApprovalPrompt('auto');

            try {
                $client->refreshToken($refreshToken);
                $this->session->set_userdata('accessToken', $client->getAccessToken());
                redirect("users/alldocs");
            } catch (Exception $e) {
                redirect("users/login");
                exit;
                // $this->db->update("refresh_token",array("refreshToken" => "")); 	
                // $this->verify_googleaccount();	
            }
        } else {

            redirect("users/login");
            exit;
        }
    }

    public function admininfo() {
        if (empty($this->_userdata)) {
            $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('username_login_first') . '</div>');
            redirect('users/login');
        }
        $this->data['selected'] = 'adminactive';
        //pre($this->session->userdata);
        $this->data['title'] = $this->lang->line('admin_lbl');
        $clientid = $this->session->userdata('clientId');
        $this->data['adminlist'] = $this->usermodel->getloggedinClientDetailbyId($clientid);
        $this->load->view('users/adminlist', $this->data);
        //pr($adminlist);
    }

    function downloadzip($id = null, $name = null) {

        $client = $this->google_client;
        $client->setAccessToken($this->session->userdata('accessToken'));
        $service = new Google_DriveService($client);

        if ($id == null) {
            $id = $this->input->post('folderid');
        }

        if ($this->input->post('folderid')) {
            $folderdetail = $this->usermodel->getallfolders($id, 'getbyId');
            //pre($folderdetail);
            //pr($id);
        }
        $main_folder = $folderdetail[0]['googleFolderName'];
        //$main_folder = $name;
        //$main_folder_id = "0Bx2xsf5uSuWqb1dfVnNvTGdCcW8";
        $main_folder_id = $folderdetail[0]['googlefolderId'];

        /* Recent document code here */
        $array = array(
            'title' => 'my_backup.zip',
            'doc_id' => $main_folder_id,
            'doc_type' => 'folder',
            'folder_id' => $main_folder_id,
            'folder_name' => $main_folder,
            'user_id' => $this->session->userdata('userid'),
            'action_description' => 'Export folder',
        );
        $this->usermodel->saverecentfiles($array);

        //$this->load->library('zip');	
        walk_dir($service, $main_folder_id, $main_folder);
        $this->zip->download('my_backup.zip');
        $this->session->set_flashdata('message', '<div class="alert-success">' . $this->lang->line('file_bkp_msg') . '</div>');
        //$rd = $_SERVER['REQUEST_URI'];


        redirect('users/alldocs');
    }

    function deletegooglefile($folderid, $fileid) {
        $client = $this->google_client;
        $client->setAccessToken($this->session->userdata('accessToken'));
        $service = new Google_DriveService($client);

        $filesdetail = $service->files->get($fileid);

        /* Recent document code here */
        $array = array(
            'title' => $filesdetail->title,
            'doc_id' => $fileid,
            'doc_type' => $filesdetail->mimeType,
            'folder_id' => $folderid,
            'folder_name' => '',
            'user_id' => $this->session->userdata('userid'),
            'action_description' => 'Delete file',
        );
        $this->usermodel->saverecentfiles($array);

        $return = deleteFile($service, $fileid);
        echo $this->session->set_flashdata('message', '<div class="alert-success">' . $this->lang->line('file_delete_mgs') . '</div>');
        redirect('users/fileListing/' . $folderid);
        //return true; 
    }

    /* Change language */

    function changelaunguage($changelaunguage) {
        if (isset($changelaunguage)) {
            if ($changelaunguage == 'portugal') {
                $this->session->set_userdata('language', $changelaunguage);
            } else {
                $changelaunguage = 'english';
                $this->session->set_userdata('language', $changelaunguage);
            }
            /* Update database according to user */
            if ($this->session->userdata('userid') && $this->session->userdata('userid') != '') {
                $active_userid = $this->session->userdata('userid');
                $this->usermodel->setdefaultlanguge($active_userid, $changelaunguage);
            }
        }
        //echo $changelaunguage;
        //return true; 
    }

    function deleteget_google_file_contentgooglefile($fileid) {
        $resultarray = array();
        $client = $this->google_client;
        $client->setAccessToken($this->session->userdata('accessToken'));
        $service = new Google_DriveService($client);
        //$return = deleteFile($service, $fileid);
        $filearrray = retrieveOnlyFiles($service, null);
        foreach ($filearrray as $gfkey => $gfileval) {
            if ($gfileval->id == $fileid) {
                $filesdetail['fdetail'] = $gfileval;
            }
        }

        $folderparentid = $filesdetail['fdetail']->parents[0]->id;

        $subfolderaray = $this->usermodel->getfolderbygoogelfid($folderparentid);

        $subfolderid = $subfolderaray[0]['googlefolderId'];

        //$parentfolderaray =$this->usermodel->getfolderbygoogelfid($subfolderid);

        $folderath = $subfolderaray[0]['googleFolderName'] . '/';

        $ownername = $filesdetail['fdetail']->ownerNames[0];
        $fileextension = $filesdetail['fdetail']->fileExtension;
        $ftitle = $filesdetail['fdetail']->title;
        /* Recent document */
        if (isset($fileid)) {

            //pr($filesdetail);
            /* Recent document code here */
            $array = array(
                'title' => $filesdetail['fdetail']->title,
                'doc_id' => $filesdetail['fdetail']->id,
                'doc_type' => $fileextension,
                'folder_id' => $subfolderid,
                'folder_name' => '',
                'user_id' => $this->session->userdata('userid'),
                'action_description' => 'view file',
            );
            $this->usermodel->saverecentfiles($array);
        }
        //return $resultarray;
        //pr($filesdetail);
        echo '<ul class="tab-field">
		    <?php $folderarray=getviewfolderlist();
			  //pre($folderarray);		
		    ?>
		    <li><i><strong>' . $this->lang->line('file_view_title') . '</strong></i></li>
		    <div id="bothfieldmsg" style="color:#931017;width:82%;text-align: right;font-size: 12px"></div>
		    <li>
			     <span><label for="folderid">' . $this->lang->line('file_rename_lable') . '</label><em>*</em></span>
			     <div class="input-divs">
				    <input type="text" name="filename" value="' . $filesdetail['fdetail']->title . '"/>	
			     </div>
			     <div id="filenamemsg" style="color:#931017;width:82%;text-align: right;font-size: 12px"></div>
		    </li>
		    <li>
		     <span><label for="folderid">' . $this->lang->line('file_date_lable') . '</label><em>*</em></span>
			     <div class="input-divs">
				    <input type="text" name="filepostdate" value="' . $filesdetail['fdetail']->createdDate . '" />	
			     </div>
			     <div id="filepostdatemsg" style="color:#931017;width:82%;text-align: right;font-size: 12px"></div>
		     </li>
		    
		    <li>
		     <span><label for="folderid">' . $this->lang->line('file_repositoryfolder_lable') . '</label><em>*</em></span>
			     <div class="input-divs">
				    <input type="text" name="repositoryfolder" value="' . $folderath . '"/>	
			     </div>
			     <div id="repositoryfoldermsg" style="color:#931017;width:82%;text-align: right;font-size: 12px"></div>
		     </li>
		    <li>
		     <span><label for="folderid">' . $this->lang->line('file_fileowner_lable') . '</label><em>*</em></span>
			     <div class="input-divs">
				    <input type="text" name="fileowner" value="' . $ownername . '"/>	
			     </div>
			     <div id="fileownermsg" style="color:#931017;width:82%;text-align: right;font-size: 12px"></div>
		    </li>
		    <li>
		     <span><label for="folderid">' . $this->lang->line('file_extension_lable') . '</label><em>*</em></span>
			     <div class="input-divs">
				    <input type="text" name="fileextension" value="' . $fileextension . '"/>	
			     </div>
			     <div id="fileextensionmsg" style="color:#931017;width:82%;text-align: right;font-size: 12px"></div>
		    </li>
				    <input type="hidden" name="fileid" value="' . $filesdetail['fdetail']->id . '"/>	
		    </li>
						
		    </ul>';
        exit;
    }

    function get_google_renamefile($fileid) {
        $resultarray = array();
        $client = $this->google_client;
        $client->setAccessToken($this->session->userdata('accessToken'));
        $service = new Google_DriveService($client);
        //$return = deleteFile($service, $fileid);
        $filearrray = retrieveOnlyFiles($service, null);
        foreach ($filearrray as $gfkey => $gfileval) {
            if ($gfileval->id == $fileid) {
                $filesdetail['fdetail'] = $gfileval;
            }
        }
        $filename = $filesdetail['fdetail']->title;
        if (isset($filename)) {
            $farray = explode('.', $filename);
            $file_title = $farray[0];
        }

        //pr($filesdetail);
        echo '<ul class="tab-field">
		    <li><i><strong>' . $this->lang->line('file_rename_title') . '</strong></i></li>
		    <div id="bothfieldmsg" style="color:#931017;width:82%;text-align: right;font-size: 12px"></div>
		    <li>
			     <span><label for="folderid">' . $this->lang->line('file_rename_lable') . '</label><em>*</em></span>
			     <div class="input-divs">
				    <input type="text" name="filename" value="' . $file_title . '"/>	
			     </div>
			     <div id="filenamemsg" style="color:#931017;width:82%;text-align: right;font-size: 12px"></div>
		    </li>
		   
		    <input type="hidden" name="fileid" value="' . $filesdetail['fdetail']->id . '"/>
		    <input type="hidden" name="description" value="' . $filesdetail['fdetail']->description . '"/>
		    <input type="hidden" name="mimeType" value="' . $filesdetail['fdetail']->mimeType . '"/>
		    <input type="hidden" name="headRevisionId" value="' . $filesdetail['fdetail']->headRevisionId . '"/>
		    </li>
						
		    </ul><div class="input-radio" style="float:left">
			<input value="' . $this->lang->line('front_search_sbmt_label') . '" class="sign" type="submit" name="btnsubmit" id="btnsubmit">
		    </div>
	    ';
        exit;
    }

    function googlefilerename() {

        if ($this->input->post('btnsubmit')) {
            $client = $this->google_client;
            $client->setAccessToken($this->session->userdata('accessToken'));
            $service = new Google_DriveService($client);

            $fileId = $this->input->post('fileid');
            $newDescription = $this->input->post('description');
            $newRevision = $this->input->post('headRevisionId');
            $newMimeType = $this->input->post('mimeType');
            $filename = $this->input->post('filename');
            $urlfolderid = trim($this->input->post('urlfolderid'));


            $mimearray = explode('/', $newMimeType);

            $newTitle = $filename . '.' . $mimearray[1];
            $filename = $filename . '.' . $mimearray[1];
            $newFileName = $filename;
            updateFile($service, $fileId, $newTitle, $newDescription, $newMimeType, $newFileName, $newRevision);

            /* Recent document code here */
            $array = array(
                'title' => $newFileName,
                'doc_id' => $fileId,
                'doc_type' => $newMimeType,
                'folder_id' => $urlfolderid,
                'folder_name' => '',
                'user_id' => $this->session->userdata('userid'),
                'action_description' => 'File Rename by user',
            );
            $this->usermodel->saverecentfiles($array);

            $this->session->set_flashdata('message', '<div class="alert-success">' . $this->lang->line('rename_file_msg') . '</div>');

            redirect("users/fileListing/$urlfolderid");
            //pr($_SERVER['REQUEST_URI']);
        }
    }

    function googlemoovfile($oldparentfolder = null) {
        if ($this->input->post('btnsubmit')) {
            $client = $this->google_client;
            $client->setAccessToken($this->session->userdata('accessToken'));
            $service = new Google_DriveService($client);
            if ($this->input->post('folderid')) {
                //pr($oldparentfolder);
                $folderdetail = $this->usermodel->getallfolders($this->input->post('folderid'), 'getbyId');
                $main_folder = $folderdetail[0]['googleFolderName'];
                $moove_folder_id = $folderdetail[0]['googlefolderId'];
                ;
                $fileId = $this->input->post('moovfileid');
                $oldparentid = $this->input->post('oldparentid');

                //$filearrray=retrieveOnlyFiles($service,null);

                insertFileIntoFolder($service, $moove_folder_id, $fileId);

                removeFileFromFolder($service, $oldparentid, $fileId);
                $this->session->set_flashdata('message', '<div class="alert-success">' . $this->lang->line('move_file_msg') . '</div>');

                redirect("users/fileListing/$oldparentid");
            }


            //pr($_SERVER['REQUEST_URI']);
        }
    }

    public function recentdocs() {
        if (empty($this->_userdata)) {
            $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('username_login_first') . '</div>');
            redirect('users/login');
        }
        $this->data['visiblefolders'] = null;
        $this->data['selecttop'] = "recentdocs";
        $this->data['title'] = $this->lang->line('recent_doc_label');
        $this->data['user_folders_list'] = null;
        try {
            $client = $this->google_client;
            $client->setAccessToken($this->session->userdata('accessToken'));
            $service = new Google_DriveService($client);

            if ($this->session->userdata('userRoleId') == '3') { /* User folder list */
                $user_folders = $this->usermodel->getUserdocumentbyId();
                if (isset($user_folders->folderpermissions) && !empty($user_folders->folderpermissions)) {
                    $user_folders_array = json_decode($user_folders->folderpermissions);
                    if (!empty($user_folders_array)) {
                        foreach ($user_folders_array as $ky => $val) {
                            $folderId_array[] = $ky;
                        }
                        /* Get user folder list which allot permissons */
                        $this->data['user_folders_list_db'] = $this->usermodel->getuserfolderlist($folderId_array);
                    }
                }
            } else {
                /* Client folder list */
                /* Get user folder list which allot permissons */
                $clientid = $this->session->userdata('userid');
                $this->data['user_folders_list'] = $this->usermodel->getclientfolderlist($clientid);
            }
            $this->data['user_folders_list'] = retrieveAllFiles($service);
        } catch (Exception $e) {
            $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('google_client_not_valid_email') . '</div>');
        }
        $foldersessionarray = $this->session->userdata('userfolderpermissoin');
        //pre($foldersessionarray);
        if (isset($this->data['user_folders_list_db'])) {
            foreach ($this->data['user_folders_list_db'] as $akey => $aval) {
                foreach ($foldersessionarray as $obkey => $obval) {
                    if ($aval['id'] == $obkey) {
                        $mergray[$akey] = $aval;
                        $mergray[$akey][] = $obval;
                    }
                }
            }
            $this->data['visiblefolders'] = $mergray;
        }

        /* Get Recent Doc list */

        $this->data['recentdoclist'] = $this->usermodel->getrecentdoclist($this->session->userdata('userid'));
        //pr($this->data['recentdoclist']);

        $this->data['selected'] = 'recentdocs';
        $this->load->view('users/recentdocs', $this->data);
    }

    /* Recent uploads list */

    // public function recentuploads(){
    // }



    function download_seledcted_file_zip($id = array()) {
        //$this->_helper->layout()->disableLayout();
        // $this->_helper->viewRenderer->setNoRender(true);
        //pr($id);
        if (isset($id) && count($id) > 0) {
            $client = $this->google_client;
            $client->setAccessToken($this->session->userdata('accessToken'));
            $service = new Google_DriveService($client);


            $CI = & get_instance(); // Get the global CI object
            $CI->load->library('zip');
            if (isset($id)) {
                $idArry = explode(",", $id);
            }

            foreach ($idArry as $id) {
                // getfileobj by id
                $file = $service->files->get($id);
                $name = $file->title;
                $data = downloadFile($service, $file);
                $CI->zip->add_data($name, $data);

                /* Recent document code here */
                $array = array(
                    'title' => $file->title,
                    'doc_id' => $file->id,
                    'doc_type' => $file->mimeType,
                    'folder_id' => $file->parents[0]->id,
                    'folder_name' => '',
                    'user_id' => $this->session->userdata('userid'),
                    'action_description' => 'File Download by user',
                );
                $this->usermodel->saverecentfiles($array);
            }
            $this->zip->download('documents.zip');
            $this->load->helper('download');
            force_download("documents.zip", $data);
            exit;
        } else {
            $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('select_any_file_for_download') . '</div>');
            redirect('users/alldocs');
        }
    }

    public function recentfolders() {
        $this->load->library("pagination");
        //page title
        $this->data['title'] = $this->lang->line('recent_label');
        $this->data['menu'] = '2';
        //pagination configurations
        $this->data['total_row'] = $this->usermodel->getusersrecentlist(null, null, 'folder');

        $config['total_rows'] = count($this->data['total_row']);
        $config['per_page'] = PER_PAGE_RECORD_FRONT; /* DEFINE IN CONFIG/CONSTAANT.PHP */;
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
        if ($this->uri->segment($do_orderby + 1) != 'admin') {
            $sortby = 'id';
        } else {
            $sortby = $this->uri->segment($do_orderby + 1);
        }

        $this->db->order_by($sortby, $this->uri->segment($do_orderby + 2));

        //getting the records and limit setting
        if (ctype_digit($segment_array[$segment_count])) {

            $this->data['page'] = $segment_array[$segment_count];
            $page = $segment_array[$segment_count];
            $this->db->limit($config['per_page'], $segment_array[$segment_count]);
            array_pop($segment_array);
        } else {
            $page = null;
            $this->data['page'] = NULL;
            $this->db->limit($config['per_page']);
        }

        $config['base_url'] = site_url(join("/", $segment_array));
        $config['uri_segment'] = count($segment_array) + 1;

        //initialize pagination
        $this->pagination->initialize($config);
        $this->data['recentdoclist'] = $this->usermodel->getusersrecentlist($config["per_page"], $page, 'folder');
        $this->data["links"] = $this->pagination->create_links();
        //pre($data['recentdoclist']);

        /* Get only folder */
        //$client = $this->google_client;	
        //$client->setAccessToken($this->session->userdata('accessToken'));
        //$service = new Google_DriveService($client);
        //$this->data['user_folders_list'] = printFilesInFolder($service, $this->session->userdata('parentfolderid'));
        //load the view
        $this->load->view('users/recentfolders', $this->data);
    }

    public function recentfiles($folderid = null) {
        $this->load->library("pagination");
        //page title
        $this->data['title'] = $this->lang->line('recent_label');
        $this->data['menu'] = '2';
        //pagination configurations
        $this->data['total_row'] = $this->usermodel->getusersrecentlist(null, null, 'files');

        $config['total_rows'] = count($this->data['total_row']);
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
        if ($this->uri->segment($do_orderby + 1) != 'admin') {
            $sortby = 'id';
        } else {
            $sortby = $this->uri->segment($do_orderby + 1);
        }

        $this->db->order_by($sortby, $this->uri->segment($do_orderby + 2));

        //getting the records and limit setting
        if (ctype_digit($segment_array[$segment_count])) {

            $this->data['page'] = $segment_array[$segment_count];
            $page = $segment_array[$segment_count];
            $this->db->limit($config['per_page'], $segment_array[$segment_count]);
            array_pop($segment_array);
        } else {
            $page = null;
            $this->data['page'] = NULL;
            $this->db->limit($config['per_page']);
        }

        $config['base_url'] = site_url(join("/", $segment_array));
        $config['uri_segment'] = count($segment_array) + 1;

        //initialize pagination
        $this->pagination->initialize($config);
        $this->data['recentfilelist'] = $this->usermodel->getusersrecentlist($config["per_page"], $page, 'files');
        $this->data["links"] = $this->pagination->create_links();
        //pr($this->data['recentfilelist']);

        $foldersessionarray = $this->session->userdata('userfolderpermissoin');
        //pre($foldersessionarray);
        /* Get user folder list which allot permissons */
        $user_folders = $this->usermodel->getUserdocumentbyId();
        if (isset($user_folders->folderpermissions) && !empty($user_folders->folderpermissions)) {
            $user_folders_array = json_decode($user_folders->folderpermissions);
            if (!empty($user_folders_array)) {
                foreach ($user_folders_array as $ky => $val) {
                    $folderId_array[] = $ky;
                }
                /* Get user folder list which allot permissons */
                $this->data['user_folders_list_db'] = $this->usermodel->getuserfolderlist($folderId_array);
            }

            $this->data['user_folders_list_db'] = $this->usermodel->getuserfolderlist($folderId_array);
            foreach ($this->data['user_folders_list_db'] as $akey => $aval) {
                foreach ($foldersessionarray as $obkey => $obval) {
                    if ($aval['id'] == $obkey) {
                        $mergray[$akey] = $aval;
                        $mergray[$akey][] = $obval;
                    }
                }
            }
            $this->data['visiblefolders'] = $mergray;
        }
        /* Get only folder */
        $client = $this->google_client;
        $client->setAccessToken($this->session->userdata('accessToken'));
        $service = new Google_DriveService($client);
        //echo $folderid;die;
        $this->data['user_folders_list'] = printFilesInFolder($service, $folderid);
        //load the view
        $this->load->view('users/recentfiles', $this->data);
    }

    /* public function googdownloadfile($id){
      $client = $this->google_client;
      $client->setAccessToken($this->session->userdata('accessToken'));
      $service = new Google_DriveService($client);

      $google_files = retrieveOnlyFiles($service,null);
      foreach($google_files as $gval){
      if($gval->id==$id){
      $downloadfile=$gval;
      }
      }
      //pr($downloadfile);
      //$return = deleteFile($service, $fileid);
      echo downloadFile($service,$downloadfile);
      echo GetDownloadLinkFile($service, $downloadfile->downloadUrl);
      //$id

      }
     * .

      /* $file = new Google_DriveFile();

      $file->setTitle($_FILES['upld_file']['name']);
      $file->setDescription('This is a '.$_FILES['upld_file']['type'].' document');
      $file->setMimeType($_FILES['upld_file']['type']);
      $service->files->insert(
      $file,
      array(
      'data' => file_get_contents($_FILES['upld_file']['tmp_name']),
      'mimeType' => $_FILES['upld_file']['type']
      )
      ); */

    public function getemailbyrefreshtoken() {
        // pre($this->session->userdata);
        $refreshtoken = $this->session->userdata('sess_refresh_token');
        //$this->usermodel->
    }

    public function executecode() {
        //$this->load->helper(array('form', 'email','cookie','googledrive'));
        $this->load->helper('generate');
        //$zip =  new ZipFile();
        $destination_path = $_GET['destination'];
        $zip_name_with_path = $_GET['zipName'];
        echo $action = $_GET['action'];

        $obj = new ZipFile();
        if (!isset($destination_path) || !isset($zip_name_with_path) || !isset($action)) {
            echo "If you want to extract any file then pass destination path in query string with (destination) parameter <br/>If you want to delete directory then pass destination path in query string with (destination) parameter <br/>If you want to make zip file then pass destination path & zip file path with name in query string with (destination & zipName) parameter";
        } else {
            switch ($action) {
                case 'Delete':
                    $obj->deleteDirectory($destination_path);
                    break;
                case 'Extract':
                    $obj->ExtractZip($destination_path);
                    break;
                case 'Zip':
                    $zipName = $zip_name_with_path;
                    $obj->MakeZip($destination_path, $zipName);
                    break;
                default:
                    echo "Please pass action";
            }
        }
    }

    /* Rubina */

    public function notification() {
        if ($this->session->userdata('loggedInUser')) {
            // get all messages of user
            redirect('/users/messagebox');
        } else {
            redirect('/users/login');
        }
    }


    function messageOutbox() {
        if ($this->session->userdata('loggedInUser')) {
            $this->load->model('usermodel');
            //page title
            $data['title'] = $this->lang->line('outbox');
            $data['submenu'] = '9b';
            $data['outbox_message'] = $this->usermodel->getOutboxMessage();
            $this->load->view('users/message_outbox', $data);
        } else {
            redirect('/users/login');
        }
    }

    function composeMessage() {
        if ($this->session->userdata('loggedInUser')) {

            $this->form_validation->set_rules('user', 'user', 'required|trim');
            $this->form_validation->set_rules('subject', 'subject', 'required|trim');
            $this->form_validation->set_rules('message', 'message', 'required|trim');

            $this->form_validation->set_message('user', $this->lang->line('select_user'));
            $this->form_validation->set_message('subject', $this->lang->line('subject'));
            $this->form_validation->set_message('message', $this->lang->line('message'));

            
            if(isset($_GET['fileid']) && $_GET['fileid']!=''){
                
                $client = $this->google_client;
                $client->setAccessToken($this->session->userdata('accessToken'));
                $service = new Google_DriveService($client);
                /* Show all files with folder */
                //$folderid =$_GET['fldrid'];
                $fileid =$_GET['fileid'];
                $user_file_list = printFile($service, $fileid);
                $data['file_detail']['title']=$user_file_list->title;
                $data['file_detail']['fileId']=$user_file_list->id;
                //pre($user_file_list);
            }

            if ($this->form_validation->run() == false) {
                //page title
                $data['title'] = $this->lang->line('add_message');
                $data['submenu'] = '9c';

                /* Get all client's user list of the login user client */

                $data['users'] = $this->usermodel->getAllUsers_byClientID($this->session->userdata('clientId'),$this->session->userdata('userId'));

               // print_r($clientusers);die;
                //$admin = $this->usermodel->getAdminDetail();

                //$data['users'] = array_merge($admin, $clientusers);

                $this->load->view('users/add_message', $data);
            } else {

                // check for upload file---------------------------upload attached file in folder if any
                $uploaded_data['upload_data']['file_name'] = '';
                if ($_FILES['attach']['name'] != '') {
                    $uploaded_data = $this->do_file_upload('attachment/', 'attach');
                }
                $notification_flag = 0;
		$receiver = $this->input->post('user');
                if($this->input->post('gmailFile')!=''){
                    $uploadfilename=$this->input->post('gmailFile');
                }else{
                     $uploadfilename= $uploaded_data['upload_data']['file_name'];
                }

		/*Get reciever Email Id */
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

                $insert_msg = array('user_id' => $this->session->userdata('userId'),
                    'subject' => $this->input->post('subject'),
                    'message' => $this->input->post('message'),
                    'attachment' => $uploadfilename,
                    'message_type' => 'inbox',
                    'show_in_inbox' => 'y',
                    'created_date' => date('Y-m-d H:i:s'),
                    'notification_flag' => $notification_flag,
                    'receiver' => $receiver
                );
                $insertID = $this->usermodel->addMessage($insert_msg);
		
                if ($insertID) {

                    //$to = 'oneandsimple76@gmail.com';
                    $subject = $this->input->post('subject');
                    $data = 'You have one new message in your numera account.<br/><br/> Please <a href="'.base_url().'">click here </a> to view you message.<br/><br/><b>From : ' .$this->session->userdata('userName').'</b> ';	
		    $dataArray=array(
				'ToEmail'=>$toEmail,
				'subject'=>$subject,
				'userName'=>$toUser,
				'message'=>$data,						
				);	
		    $this->Send_emai_notification($dataArray);
                   
                    $this->session->set_flashdata('message', '<div class="alert-success" style="margin-left:5px;margin-right: 5px;" >' . $this->lang->line('msg_send_success') . '</div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert-error" style="margin-left:5px;margin-right: 5px;">' . $this->lang->line('msg_send_fail') . '</div>');
                }

                redirect('users/messagebox');
            }
        } else {
            redirect('/users/login');
        }
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

    function download_file() {
       
        $filename = $_GET['file'];
        $this->load->helper('download');
        $data = file_get_contents('./uploads/attachment/' . $filename); // Read the file's contents
        $name = $filename;
        force_download($name, $data);
    }

   /******GV*****/
	
    function messagebox() {
        if (empty($this->_userdata)) {
            $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('username_login_first') . '</div>');
            redirect('users/login');
        }
        //pre($this->session->userdata);
        $this->load->model('usermodel');
        $this->load->library('pagination');
        
        //page title
        $this->data['title'] = $this->lang->line('inbox');
        $this->data['submenu'] = '9a';
        
         /*Pagination*/
        $config = array();
        $config["base_url"] = base_url() . "users/messagebox/page/";
        $config['per_page'] = PER_PAGE_RECORD; /*DEFINE IN CONFIG/CONSTAANT.PHP*/;
        $config['full_tag_open'] = '<ul class="pagination m-b-none animated for_animate animation fadeInUp">';
        $config['full_tag_close'] = '</ul>';
        //$config["total_rows"] = count($this->messagemodel->getChatHistory(null,null,null));
        $config["total_rows"] = count($this->usermodel->getInboxMessage($this->session->userdata('userId'),null,null));
        $config["uri_segment"] = 4;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
         /* Get the page number from the URI (/index.php/pagination/index/{pageid}) */
        //$page = $this->uri->segment(4);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) :0;
        //$page = $this->pagination->cur_page;
        //$this->data['chathistory'] = $this->messagemodel->getChatHistory(null,$config["per_page"],$page);
        $this->data['inbox_message'] = $this->usermodel->getInboxMessage($this->session->userdata('userId'),$config["per_page"],$page);
        //echo $this->db->last_query();
        $this->data["links"] = $this->pagination->create_links();
         
         
        //$this->data['inbox_message'] = $this->usermodel->getInboxMessage($this->session->userdata('userId'));
        $this->load->view('users/message_inbox', $this->data);
    }


   function msg_history($mid,$toname,$toid){
        if ($this->session->userdata('loggedInUser') && $toid!='') {

            $this->load->model('usermodel');

            /* Get All msg history */
           
            //page title
            $data['title'] = 'Message History';

            //update flage after read msg
            $this->usermodel->setReadMessage($this->uri->segment(3));

            $data['reply_id'] = $this->uri->segment(3);

            $record = $this->usermodel->getUserReplyDetail($this->uri->segment(3));
            $data['msgto'] = $toid;
            $data['subject'] = $record['subject'];


            $data['message'] = $this->usermodel->getHistoryMsgByUser($this->uri->segment(3),$toname,$toid);
            
            $this->load->view('users/message_history', $data);
        }else{
            redirect('users/messagebox');
        }
    }
	
   function replyMessage(){
       //pr($this->input->post());s
       if ($this->session->userdata('loggedInUser')) {

            $this->form_validation->set_rules('message', 'message', 'required|trim');

            $this->form_validation->set_message('message', $this->lang->line('message'));


            if ($this->form_validation->run() == false) {
                //page title
                $data['title'] = $this->lang->line('add_message');
                $data['submenu'] = '9c';
                $this->load->view('users/message_history', $data);
            } else {

                // check for upload file---------------------------upload attached file in folder if any
                $uploaded_data['upload_data']['file_name'] = '';
                if (@$_FILES['attach']['name'] != '') {
                    $uploaded_data = $this->do_file_upload('attachment/', 'attach');
                }
                //echo  $this->session->userdata('userId');
                $insert_msg = array('user_id' => $this->session->userdata('userId'),
                    'subject' => $this->input->post('subject'),
                    'message' => $this->input->post('message'),
                    'attachment' => $uploaded_data['upload_data']['file_name'],
                    'message_type' => 'inbox',
                    'show_in_inbox' => 'y',
                    'reply_id' => $this->input->post('reply_id'),
                    'receiver' => $this->input->post('user_id'),
                    'user_id' => $this->session->userdata('userId'),
                    'created_date' => date('Y-m-d H:i:s')
                );
                //pr($insert_msg);

		/*Get reciever Email Id */
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

                $insertID = $this->usermodel->addMessage($insert_msg);

                if ($insertID) {

                    $subject = ' Reply-'.$this->input->post('subject');
                    $data = 'You have one new message in your numera account.<br/><br/> Please <a href="'.base_url().'numera">click here </a> to view you message.<br/><br/><b>From : ' .$this->session->userdata('userName').'</b> ';	
		    $dataArray=array(
				'ToEmail'=>$toEmail,
				'subject'=>$subject,
				'userName'=>$toUser,
				'message'=>$data,						
				);	
		    $this->Send_emai_notification($dataArray);
                   
                    $this->session->set_flashdata('message', '<div class="alert-success">' . $this->lang->line('msg_send_success') . '</div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert-error">' . $this->lang->line('msg_send_fail') . '</div>');
                }

                //redirect('users/msg_history/'.$this->input->post('reply_id'), 'refresh');
                redirect('users/messagebox');
            }
        } else {
            redirect('/users/login');
        }
    }  
	
    public function Send_emai_notification($dataArray){
		$from = $this->config->item('adminEmail');
		$to = $dataArray['ToEmail'];
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
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($body);
		$this->email->set_mailtype('html');
		//pr($body);
		$this->email->send();
		return TRUE;
    }	
	 
}

?>
