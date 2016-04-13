<?php

class Adminmodel extends CI_Model {

    var $title = '';
    var $content = '';
    var $date = '';

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function getLoginResult($username, $password) {
        $result = $this->db->get_where('users', array('userName' => $username, 'userPassword' => $password, 'userRoleId' => '1'));
        return $result->row_array();
    }

    /* Check user name is exist or not */

    function checkUserexist($usr) {
        $result = $this->db->get_where('users', array('userName' => $usr, 'userRoleId' => '1'));
        return $result->row_array();
    }

    /* Check user name exist or not by jquery */

    function checkUser_jquery($usr) {
        $this->db->select('userName');
        $result = $this->db->get_where('users', array('userName' => $usr));
        return $result->row_array();
    }

    /* Check user password is exist or not */

    function checkusrpwdxist($pwd) {
        $result = $this->db->get_where('users', array('userPassword' => $pwd, 'userRoleId' => '1'));
        return $result->row_array();
    }

    /* Count total number of user rows and get all user according the roles */

    function totolNumberofuser($roleid, $task = null) {
        $this->db->select('id,userEmail,userName');
        $result = $this->db->get_where('users', array('userRoleId' => $roleid));
        if ($task == 'client') {
            return $result->result_array();
        } else {
            return $result->num_rows();
        }

        //echo $this->db->last_query();die;
    }

    /* Check admin email is exist or not */

    function checkusremail($str) {
        $result = $this->db->get_where('users', array('userEmail' => $str, 'userRoleId' => '1'));
        return $result->row_array();
    }

    /* update upassword */

    function updatepassword($userId = null, $newpwd = null) {
        $save = array(
            'userPassword' => $newpwd,
        );
        $result = $this->db->update('users', $save, array('id' => $userId));
        //echo $this->db->last_query();
        //die('welcome');
        return $result;
    }

    /* Get user detail by Id from users table */

    function getuserDetail($uid = null, $roleid = null) {
        $result = $this->db->get_where('users', array('id' => $uid, 'userRoleId' => "$roleid"));
        return $result->row_array();
    }

    /* Get User detail by Id from users_detail table */

    function getuserDetailbyId($id = null) {
        $result = $this->db->get_where('user_details', array('id' => $id));
        return $result->row_array();
    }

    /* Get user complete detail by Id from users table */

    function getuserFullDetail($uid = null, $roleid = null) {
        $this->db->select('udetail.id,udetail.userId as userId,usr.userlanguage,usr.userName,usr.userEmail,usr.userImage,usr.userPhone,usr.userRoleId,usr.oneNsimpleUsr,
				  usr.userStatus,udetail.fname,udetail.lname,udetail.profession,udetail.clientId as clientId,
				  usrclnt.userName as clientname');
        $this->db->from('users AS usr');
        $this->db->where("usr.id = $uid");
        $this->db->where("usr.userRoleId =" . $roleid);
        $this->db->join('user_details AS udetail', 'udetail.userId = usr.id', 'INNER');
        $this->db->join('users AS usrclnt', 'usrclnt.id = udetail.clientId', 'INNER');
        $this->db->join('users_permission AS upermission', 'upermission.userId = usr.id', 'left');
        $result = $this->db->get();
        //echo $this->db->last_query();die;
        return $result->row_array();
    }

    /* Get Client detail by Id from client_details table */

    function getclientDetail($uid = null) {
        if ($uid) {
            $this->db->select('cdetail.*, gglClientDtl.email,gglClientDtl.password');
            $this->db->from('client_details AS cdetail');
            $this->db->join('google_login_detail AS gglClientDtl', 'gglClientDtl.userId = cdetail.userId ', 'LEFT');
            $this->db->where("cdetail.userId = $uid");
            $result = $this->db->get();
            //$result = $this->db->get_where('client_details', array('userId' => $uid));
            return $result->row_array();
        }
    }

    function saveUser($task = null, $arrayval = null) {
        //pr($this->input->post());
        $save = array();
        if ($this->session->userdata('loggedInAdmin') && $task == 'admin') {
            $id = $this->session->userdata('id');
        } else {
            if (isset($arrayval) && count($arrayval) > 0) {
                $id = $arrayval['clientinfo']['id'];
                //echo $id;
            } else {
                $id = $this->input->post('id');
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

        if ($uploaded_data['error'] == '') {
		if(@$this->input->post('oneNsimpleUsr')=='accept'){
            		$isNumerausr = 'y';
		}else{
		    	$isNumerausr = 'n';
		}
            $saveuser = array(
                'userName' => $this->input->post('userName'),
                'userName' => $this->input->post('userName'),
                'userEmail' => $this->input->post('userEmail'),
                'userPhone' => $this->input->post('userPhone'),
                'userImage' => $uploaded_data['upload_data']['file_name'],
		'oneNsimpleUsr' => $isNumerausr,
                'userlanguage' => trim($this->input->post('userlanguage')),
                'userUpdateDate' => date('Y-m-d H:i:s')
            );
            $saveadmin = array(
                'userName' => $this->input->post('userName'),
                'userEmail' => $this->input->post('userEmail'),
                'userPhone' => $this->input->post('userPhone'),
                'adminFooterTxt' => $this->input->post('adminFooterTxt'),
                'userUpdateDate' => date('Y-m-d H:i:s')
            );
            if ($id) { /* Update tables */
                //pr($_POST);
                if (isset($_FILES['userImage']['name']) && !empty($_FILES['userImage']['name'])) {
                    $result = $this->db->get_where('users', array('id' => $id));
                    $imageDetail = $result->row_array();
                    if ($imageDetail['userImage'] !== 'no-image.gif' && $task != 'admin') {
                        unlink('./uploads/users/' . $imageDetail['userImage']);
                    }
                }
                if ($task == 'client') {
                    /* $saveclient = array(					
                      'userName'=>$this->input->post('userName'),
                      'userEmail'=>$this->input->post('userEmail'),
                      'userPhone'=>$this->input->post('userPhone'),
                      'userImage'=>$uploaded_data['upload_data']['file_name'],
                      'userUpdateDate'=>date('Y-m-d H:i:s')
                      ); */
                    $saveclient = $arrayval['clientinfo'];
                    $this->db->update(TBL_USERS, $saveclient, array('id' => $id));
                } elseif ($task == 'user') {
                    //$fname= $this->input->post('fname');
                    //$lname= $this->input->post('lname');
                    ///$fullname= $fname.' '.$lname;
                    if ($this->input->post('newuserPassword') != null) {
                        $saveuser = array_merge($saveuser, array('userPassword' => md5($this->input->post('newuserPassword'))));
                    }
                    $userId = $this->input->post('userId');
                    $this->db->update(TBL_USERS, $saveuser, array('id' => $userId));
                    //die($this->db->last_query());
                } else { /* For admin only */
                    $this->db->update(TBL_USERS, $saveadmin, array('id' => $id));
                }

                /* Save data in client details */
                /* update client information */
                if ($task == 'client')/* For Client Detail table */ {
                    /* $save_client=array(
                      'userId'=>$id ,
                      'companyName'=>$this->input->post('companyName'),
                      'clientAddress'=>$this->input->post('clientAddress'),
                      'accountManager'=>$this->input->post('accountManager'),
                      'accountType'=>$this->input->post('accountType'),

                      );
                     */
                    $save_client = $arrayval['clientDetail'];
                    $save_client = array_merge($save_client, array('userId' => $id));
                    //pr($save_client);
                    if ($id) {
                        $this->db->update('client_details', $save_client, array('userId' => $id));
                    } else {
                        $this->db->insert('client_details', $save_client);
                    }

                    /* Save Client Google id and password into google_login_detail table` */
                    //=$arrayval['googleloginDetail'];
                    //echo $id;
                    //pr($arrayval);
                    if ($arrayval['googleloginDetail']['password']) {
                        $save_client_googlelogin = array(
                            'userId' => $id,
                            'email' => $arrayval['googleloginDetail']['email'],
                            'password' => $arrayval['googleloginDetail']['password'],
                        );
                    } else {
                        $save_client_googlelogin = array(
                            'userId' => $id,
                            'email' => $arrayval['googleloginDetail']['email'],
                        );
                    }
                    if ($id) {
                        //$this->db->update('google_login_detail`',$save_client_googlelogin,array('userId'=>$id));
                        //die($this->db->last_query());
                    } else {
                        $this->db->insert('google_login_detail`', $save_client_googlelogin);
                    }

                    /* Get client id from from  */
                    $result = $this->db->get_where('client_details', array('userId' => $id));
                    $clientarray = $result->row_array();
                    $client_id = $clientarray['id'];

                    /* Update table client_contact_person */
                    //$clientcontactpersonlist = $this->input->post('cp');
                    $clientcontactpersonlist = $arrayval['clientContactperson_single']['cp'];
                    if (is_array($clientcontactpersonlist) && count($clientcontactpersonlist) > 0) {
                        foreach ($clientcontactpersonlist as $val) {
                            $save_client_contactperson_array = array(
                                'name' => $val['personname'],
                                'profession' => $val['personprofession'],
                                'email' => $val['personemail'],
                                'phone' => $val['personphone'],
                            );
                            if (isset($val['id'])) {
                                $this->db->update('client_contact_persons', $save_client_contactperson_array, array('id' => $val['id']));
                            } else {
                                $save_client_contactperson_array = array_merge($save_client_contactperson_array, array('clientId' => $client_id));
                                $this->db->insert('client_contact_persons', $save_client_contactperson_array);
                            }
                        }
                    }
                    /* Update table client service */
                    //$clientservicearraylist = $this->input->post('services');
                    $clientservicearraylist = $arrayval['clientservicearraylist']['services'];
                    if (is_array($clientservicearraylist) && count($clientservicearraylist) > 0) {
                        foreach ($clientservicearraylist as $val) {
                            $save_client_service_array = array(
                                'serviceName' => $val['serviceName'],
                                'serviceDescription' => $val['serviceName'],
                                'startingDate' => $val['startingDate'],
                                'endingDate' => $val['endingDate'],
                            );
                            if (isset($val['id'])) {
                                $this->db->update('client_contract_services', $save_client_service_array, array('id' => $val['id']));
                            } else {
                                $save_client_service_array = array_merge($save_client_service_array, array('clientId' => $client_id));
                                $this->db->insert('client_contract_services', $save_client_service_array);
                            }
                        }
                    }
                    //die($this->db->last_query());
                }

                /* if user id is exist then update else add new user of client */
                if ($task == 'user') {
                    $save_user = array(
                        'fname' => $this->input->post('fname'),
                        'lname' => $this->input->post('lname'),
                        'profession' => $this->input->post('profession'),
                        'clientId' => $this->input->post('clientid'),
                    );
                    if ($id) {
                        $this->db->update('user_details', $save_user, array('userId' => $id));
                    } else {
                        $this->db->insert('user_details', $save_user);
                    }


                    /* update user users_permission table */
                    $permissionnamevalue = json_encode($this->input->post('pid'));
                    $permissionarray = array(
                        'permissionId' => $permissionnamevalue,
                        'userPerDate' => date('Y-m-d H:i:s'),
                    );
                    if ($id) {
                        $this->db->update('users_permission', $permissionarray, array('userId' => $id));
                    } else {
                        $this->db->insert('users_permission', $permissionarray);
                    }
                    //die($this->db->last_query());
                    /* update user users_folder_permission */
                    //pr($this->input->post('folderpermission'));
                    $folderpersmission = json_encode($this->input->post('folderpermission'));
                    $folderpermissionarray = array(
                        'folderpermissions' => $folderpersmission,
                        'userPerDate' => date('Y-m-d H:i:s'),
                    );
                    if ($id) {
                        $this->db->update('users_folder_permission', $folderpermissionarray, array('userId' => $id));
                    } else {
                        $this->db->insert('users_folder_permission', $folderpermissionarray);
                    }
                }
                return 'update';
            } else { /* Inter into tables */
                if ($task == 'client') {
                    /* $save = array(
                      'userPassword'=>md5($this->input->post('userPassword')),
                      'userRoleId'=>'2',
                      'userUpdateDate'=>date('Y-m-d H:i:s'),
                      'userCreateDate'=>date('Y-m-d H:i:s'),
                      ); */
                    //pr($saveclient);
                    unset($arrayval['clientinfo']['id']);
                    $saveclient = $arrayval['clientinfo'];
                    /* 'userImage'=>$uploaded_data['upload_data']['file_name'], */
                    $this->db->insert(TBL_USERS, $saveclient);
                    $insertId = $this->db->insert_id();

                    /* Add default folder list for all user and client in folder_master table */
                    //for($i=1; $i<=1;$i++)	//Create default 4 folder for each users and clients
                    //{
                    $clientfolderid = $arrayval['googlefolderId'];
                    $save_bothuser_folder = array(
                        'userId' => $insertId,
                        'folderName' => $saveclient['userName'],
                        'googleFolderName' => $saveclient['userName'],
                        'googlefolderId' => $clientfolderid,
                    );
                    $this->db->insert('folder_master', $save_bothuser_folder);
                    //}
                } elseif ($task == 'user') { /* Add user information for client */
                    $save = array(
                        'userPassword' => md5($this->input->post('userPassword')),
                        'userRoleId' => '3',
                        'userCreateDate' => date('Y-m-d H:i:s')
                    );
                    $saveuser = array_merge($saveuser, $save);
                    $this->db->insert(TBL_USERS, $saveuser);
                    $insertId = $this->db->insert_id();
                } else {
                    /* Add Admin information */
                    $saveadmin = array(
                        'userName' => $this->input->post('userName'),
                        'userEmail' => $this->input->post('userEmail'),
                        'userPhone' => $this->input->post('userPhone'),
                        'userUpdateDate' => date('Y-m-d H:i:s'),
                        'userCreateDate' => date('Y-m-d H:i:s')
                    );
                    $this->db->insert(TBL_USERS, $saveadmin);
                    $insertId = $this->db->insert_id();
                }


                /* save client information */
                if ($task == 'client') {
                    /* $save_client=array(
                      'userId'=>$insertId ,
                      'companyName'=>$this->input->post('companyName'),
                      'clientAddress'=>$this->input->post('clientAddress'),
                      'accountManager'=>$this->input->post('accountManager'),
                      'accountType'=>$this->input->post('accountType'),
                      );
                     */
                    $save_client = $arrayval['clientDetail'];
                    $save_client = array_merge($save_client, array('userId' => $insertId));
                    if ($id) {
                        $this->db->update('client_details', $save_client, array('userId' => $id));
                    } else {
                        $this->db->insert('client_details', $save_client);
                        $insertclientId = $this->db->insert_id();
                    }

                    /* Save Client Google id and password into google_login_detail table` */
                    /* $save_client_googlelogin=array(
                      'userId'=>$insertId ,
                      'email'=>$this->input->post('googleemail'),
                      'password'=>$this->input->post('googlepassword'),
                      );
                     */
                    $save_client_googlelogin = $arrayval['googleloginDetail'];
                    //if($arrayval['noupdate']!='noupdate')
                    //{
                    $save_client_googlelogin = array_merge($save_client_googlelogin, array('userId' => $insertId));
                    if ($id) {
                        $this->db->update('google_login_detail`', $save_client_googlelogin, array('userId' => $id));
                    } else {
                        $this->db->insert('google_login_detail`', $save_client_googlelogin);
                    }
                    //}
                    $client_email = $arrayval['googleloginDetail']['email'];

                    $result = $this->db->get_where('refresh_token', array('emailId' => $client_email));
                    $clientrefreshtokenRow = $result->num_rows();
                    //$clientrefreshtokenRow=$result->row();
                    if (count($clientrefreshtokenRow) > 0) {
                        $this->db->update('refresh_token', array('userId' => $insertId), array('emailId' => $client_email));
                    }

                    /* Add record client_contact_persons */
                    /* $save_client_contactperson=array(
                      'clientId'=>$insertclientId ,
                      'name'=>$this->input->post('personname'),
                      'profession'=>$this->input->post('personprofession'),
                      'email'=>$this->input->post('personemail'),
                      'phone'=>$this->input->post('personphone'),
                      'createDate'=>date('Y-m-d H:i:s'),
                      );
                     */
                    $save_client_contactperson = $arrayval['clientContactperson'];
                    $save_client_contactperson = array_merge($save_client_contactperson, array('clientId' => $insertclientId));
                    /* Insert record */
                    $this->db->insert('client_contact_persons', $save_client_contactperson);

                    /* Inser More record in contact person */

                    /* $clientcontactpersonlist = $this->input->post('cp'); */
                    $clientcontactpersonlist = $arrayval['clientContactperson_single']['cp'];
                    //$clientcontactpersonlist=array_merge($clientcontactpersonlist,array('clientId'=>$insertclientId));
                    if (is_array($clientcontactpersonlist) && count($clientcontactpersonlist) > 0) {
                        foreach ($clientcontactpersonlist as $val) {
                            $save_client_contactperson_array = array(
                                'clientId' => $insertclientId,
                                'name' => $val['personname'],
                                'profession' => $val['personprofession'],
                                'email' => $val['personemail'],
                                'phone' => $val['personphone'],
                                'createDate' => date('Y-m-d H:i:s'),
                            );
                            $this->db->insert('client_contact_persons', $save_client_contactperson_array);
                        }
                    }


                    /* Add record in client_contract_services table */
                    /* $save_client_services=array(
                      'clientId'=>$insertclientId ,
                      'serviceName'=>$this->input->post('serviceName'),
                      'serviceDescription'=>$this->input->post('serviceDescription'),
                      'serviceUpload'=>$this->input->post('serviceUpload'),
                      'startingDate'=>$this->input->post('startingDate',
                      'endingDate'=>$this->input->post('endingDate'),
                      ); */
                    $save_client_services = $arrayval['save_client_services_one'];
                    $save_client_services = array_merge($save_client_services, array('clientId' => $insertclientId));
                    /* Insert record */
                    $this->db->insert('client_contract_services', $save_client_services);

                    /* Add more client service */
                    //$clientservicearraylist = $this->input->post('services');
                    $clientservicearraylist = $arrayval['clientservicearraylist']['services'];
                    if (is_array($clientservicearraylist) && count($clientservicearraylist) > 0) {
                        foreach ($clientservicearraylist as $val) {
                            $save_client_service_array = array(
                                'clientId' => $insertclientId,
                                'serviceName' => $val['serviceName'],
                                'serviceDescription' => $val['serviceName'],
                                'startingDate' => $val['startingDate'],
                                'endingDate' => $val['endingDate'],
                            );
                            $this->db->insert('client_contract_services', $save_client_service_array);
                        }
                    }
                    /* Unset complete client session */
                    $this->session->unset_userdata('$saveclientSessionArray');
                }

                if ($task == 'user') {
                    $save_user = array(
                        'userId' => $insertId,
                        'fname' => $this->input->post('fname'),
                        'lname' => $this->input->post('lname'),
                        'profession' => $this->input->post('profession'),
                        'clientId' => $this->input->post('clientid'),
                    );
                    if ($id) {
                        $this->db->update('user_details', $save_user, array('userId' => $id));
                    } else {
                        $this->db->insert('user_details', $save_user);
                    }

                    /* Add Client Permission */
                    $permissionnamevalue = json_encode($this->input->post('pid'));
                    $permissionarray = array(
                        'permissionId' => $permissionnamevalue,
                        'userId' => $insertId,
                        'userPerDate' => date('Y-m-d H:i:s'),
                    );
                    /* Insert record */
                    $this->db->insert('users_permission', $permissionarray);




                    /* Add Client Folder Permission */
                    $folderpersmission = json_encode($this->input->post('folderpermission'));
                    $folderpermissionarray = array(
                        'folderpermissions' => $folderpersmission,
                        'userId' => $insertId,
                        'userPerDate' => date('Y-m-d H:i:s'),
                    );
                    /* Insert record */
                    $this->db->insert('users_folder_permission', $folderpermissionarray);
                }
                $returnarray = array('add' => 'add', 'clientId' => $insertclientId);
                return $returnarray;
            }
        } else {
            return $uploaded_data;
        }
    }

    function do_file_upload($path, $fileName) {
        $config['upload_path'] = './uploads/' . $path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->load->library('upload', $config);
        $this->upload->do_upload($fileName);
        return array('error' => $this->upload->display_errors(), 'upload_data' => $this->upload->data());
    }

    /* Get all Type of User and Client */

    function getUserlist($uclientid = null, $type = null, $limit = null, $start = null) {

        if ($type == 'client') {
            if ($uclientid) {
                $this->db->where('userClientId', $uclientid);
            } else {
                $this->db->where('userRoleId', '2');

                /* filter record */
                if ($this->input->post('clientsearch')) {
                    $serchby = $this->input->post('searchby');
                    $searchvalue = $this->input->post('searchvalue');
                    if ($serchby == 'userName') {
                        $this->db->like('usr.userName', "$searchvalue");
                        $this->db->or_like("gld.email", $searchvalue);
                    } else {
                        $this->db->like($serchby, "$searchvalue");
                    }
                }
            }
            if ($limit && $start) {
                $this->db->limit($limit, $start);
            } else {
                $this->db->order_by("id", "desc");
            }
            //$result = $this->db->get(TBL_USERS);				
            //die($this->db->last_query());
            //return $result->result_array();
            $this->db->select('usr.*,clntdetail.accountType,clntdetail.companyName,gld.email as loginemail');
            $this->db->from('users as usr');
            $this->db->join('google_login_detail as gld', 'usr.id=gld.userId', 'left');
            $this->db->join('client_details as clntdetail', 'usr.id=clntdetail.userId', 'inner');
            //echo ($this->db->last_query());
            $result = $this->db->get();
            return $result->result_array();
        }

        if ($type == 'users') {
            if ($uclientid) {
                $this->db->where('userClientId', $uclientid);
            } else {
                /* filter record */
                if ($this->input->post('clientsearch')) {
                    $serchby = $this->input->post('searchby');
                    $searchvalue = $this->input->post('searchvalue');
                    /* Get client Id by user name */
                    if ($serchby === 'udetails.clientId') {
                        $this->db->like('clntusr.userName', "$searchvalue");
                        $this->db->or_like("clntusr.userEmail", $searchvalue);
                    } elseif ($serchby == 'udetails.fname') {
                        $this->db->like('udetails.fname', "$searchvalue");
                        $this->db->or_like("udetails.lname", $searchvalue);
                    } else {
                        $this->db->like($serchby, strtolower($searchvalue));
                    }
                }
            }
            if ($limit && $start) {
                $this->db->limit($limit, $start);
            }
            //$this->db->where('userRoleId', '3');				
            //$this->db->where('cservice.clientId', "$uclientid");
            $this->db->select('udetails.*,usr.userImage, usr.userName as usrlgn_name,usr.userEmail,usr.userStatus,usr.userCreateDate,clntusr.userName as clientName,clntusr.userEmail as clientemail');
            $this->db->from('user_details as udetails ');
            $this->db->join('users as usr', 'usr.id=udetails.userId and usr.userRoleId=3', 'INNER');
            $this->db->join('users as clntusr', 'clntusr.id=udetails.clientId and usr.userRoleId=3', 'INNER');
            $result = $this->db->get();

            //$result = $this->db->get(TBL_USERS);				
            //echo ($this->db->last_query());
            return $result->result_array();
        }
    }

    /**
     * @ Function Name	: deleteusers_clients
     * @ Function Params	: $id {Array}
     * @ Function Purpose 	: delete users and client  by id also if users then delete from user_detail , user_permission and users tables,
     * 			  if client then delete from client_contact_person, contract_serivce, client_detail, user_persmission.googl_login_detail and users tables.	
     * @ Function Returns	: 
     */
    function deleteusers_clients($id) {
        //pr($id);
        $this->db->select("userRoleId,userImage");
        $this->db->where("id IN (" . $id . ")", "", FALSE);
        $result = $this->db->get("users");
        $rowarray = $result->row_array();
        if ($rowarray) {

            if ($rowarray['userImage'] !== 'no-image.gif') {
                unlink('./uploads/users/' . $rowarray['userImage']);
            }
            if ($rowarray['userRoleId'] == 3) /* For all Users */ {
                $this->db->where("userId IN (" . $id . ")", "", FALSE); /* delete user_details table */
                $this->db->delete('user_details');

                $this->db->where("userId IN (" . $id . ")", "", FALSE); /* delete user permission table */
                $this->db->delete('users_permission');

                $this->db->where("userId IN (" . $id . ")", "", FALSE); /* delete users_folder_permission table */
                $this->db->delete('users_folder_permission');


                $this->db->where("id IN (" . $id . ")", "", FALSE); /* delete user permission table */
                $this->db->delete('users');
                return true;
            }
            if ($rowarray['userRoleId'] == 2) /* For All Clients */ {
                $this->db->select("id");
                $this->db->where("userId IN (" . $id . ")", "", FALSE);
                $result = $this->db->get("client_details");
                $clientarray = $result->row_array();

                /* Delete user of under the cient */
                /* Get sub user id from client id */

                $this->db->select("userId");
                $this->db->where("clientId IN (" . $id . ")", "", FALSE);
                $result = $this->db->get("user_details");
                $subuserid_array = $result->result_array();
                if (isset($subuserid_array) && count($subuserid_array) > 0) {

                    foreach ($subuserid_array as $subusers) {
                        $userid_array[] = $subusers['userId'];

                        $this->db->where("userId IN (" . $subusers['userId'] . ")", "", FALSE); /* delete user permission table */
                        $this->db->delete('users_permission');

                        $this->db->where("userId IN (" . $subusers['userId'] . ")", "", FALSE); /* delete users_folder_permission table */
                        $this->db->delete('users_folder_permission');

                        $this->db->where("userId IN (" . $subusers['userId'] . ")", "", FALSE); /* delete user_details table */
                        $this->db->delete('user_details');


                        $this->db->where("id IN (" . $subusers['userId'] . ")", "", FALSE); /* delete user permission table */
                        $this->db->delete('users');
                    }
                }
                if ($clientarray)
                    ; {
                    $clntid = $clientarray['id'];
                    $this->db->where("clientId IN (" . $clntid . ")", "", FALSE); /* delete client_contract_services table */
                    $this->db->delete('client_contract_services');

                    $this->db->where("clientId IN (" . $clntid . ")", "", FALSE); /* delete client_contact_persons table */
                    $this->db->delete('client_contact_persons');
                }
                $this->db->where("userId IN (" . $id . ")", "", FALSE); /* delete google_login_detail table */
                $this->db->delete('google_login_detail');

                $this->db->where("userId IN (" . $id . ")", "", FALSE); /* delete folder_master table */
                $this->db->delete('folder_master');

                $this->db->where("userId IN (" . $id . ")", "", FALSE); /* delete users_permission table */
                $this->db->delete('users_permission');


                $this->db->where("userId IN (" . $id . ")", "", FALSE); /* delete user_details table */
                $this->db->delete('client_details');

                $this->db->where("id IN (" . $id . ")", "", FALSE); /* delete user permission table */
                $this->db->delete('users');
                return true;
            }
        }
    }

    /**
     * @ Function Name	: status
     * @ Function Params	: $id {Array/integer}, $status {active/inactive}
     * @ Function Purpose 	: delete users by id
     * @ Function Returns	: 
     */
    function status($id, $status) {
        $data = array('userStatus' => $status,);
        $this->db->where("id IN ('" . $id . "')", '', false);
        //$this->db->update('users', $data);
        return $this->db->update('users', $data);
        //echo $this->db->last_query();
        //die;
    }

    /**
     * @ Function Name	: savecontactperson
     * @ Function Params	: $id {Array/integer}
     * @ Function Purpose 	: delete users by id
     * @ Function Returns	: 
     */
    function savecontactperson($cpid = null, $userid = null, $array = null) {
        if ($cpid) {
            return $this->db->update('client_contact_persons', $array, array('id' => $cpid));
        } else {
            return $this->db->insert('client_contact_persons', $array);
        }
    }

    /**
     * @ Function Name	: getClientdetails
     * @ Function Params	: $id {Array/integer}
     * @ Function Purpose 	: get Client details for client_details tables
     * @ Function Returns	: 
     */
    function getClientdetails($userId) {

        $result = $this->db->get_where('client_details', array('userId' => $userId));
        //echo $this->db->last_query();die;
        return $result->row_array();
    }

    /**
     * @ Function Name	: getContactpersonlist
     * @ Function Params	: clientId {Array/integer}
     * @ Function Purpose 	: get Contact person list for client_contact_persons table
     * @ Function Returns	: 
     */
    /* Get all Type of User and Client */
    function getContactpersonlist($uclientid = null, $type = null, $limit = null, $start = null) {

        /* filter record */
        if ($this->input->post('clientsearch')) {
            $serchby = $this->input->post('searchby');
            $searchvalue = $this->input->post('searchvalue');

            $this->db->where($serchby, "$searchvalue");
        }
        if ($limit && $start) {
            $this->db->limit($limit, $start);
        }
        $this->db->where('clientId', "$uclientid");
        $result = $this->db->get('client_contact_persons');
        return $result->result_array();
        //echo $result->result_array();
        //echo $this->db->last_query();
    }

    /**
     * @ Function Name	: getcontact_person_detail
     * @ Function Params	: contactpersonId {Array/integer}
     * @ Function Purpose 	: get Contact person list for client_contact_persons table
     * @ Function Returns	: 
     */
    function getcontact_person_detail($cpid) {
        $result = $this->db->get_where('client_contact_persons', array('clientId' => $cpid));
        return $result->result_array();
    }

    /**
     * @ Function Name	: contactpersondelete
     * @ Function Params	: $userid,$cpid  {Array/integer}
     * @ Function Purpose 	: Delete contact person information
     * @ Function Returns	: 
     */
    function contactpersondelete($userid = null, $cpid = null) {
        if ($userid && $cpid) {
            $this->db->where("id IN (" . $cpid . ")", "", FALSE);
            return $this->db->delete('client_contact_persons');
        }
    }

    /**
     * @ Function Name	: savecontactperson
     * @ Function Params	: $id {Array/integer}
     * @ Function Purpose 	: delete users by id
     * @ Function Returns	: 
     */
    function saveclientService($csid = null, $userid = null, $array = null) {

        /* if($_FILES['userImage']['name']!=''){
          $uploaded_data = $this->do_file_upload('users/','userImage');
          } */
        if ($csid) {
            return $this->db->update('client_contract_services', $array, array('id' => $csid));
        } else {
            return $this->db->insert('client_contract_services', $array);
        }
    }

    /**
     * @ Function Name	: getclientservicelist
     * @ Function Params	: $uclientid, $type, $limit, $start  {Array/integer}
     * @ Function Purpose 	: Get all clients service and indivisual client service
     * @ Function Returns	: 
     */
    function getclientservicelist($uclientid = null, $type = 'client', $limit = null, $start = null) {
        /* filter record */
        if ($this->input->post('clientsearch')) {
            $serchby = $this->input->post('searchby');
            $searchvalue = $this->input->post('searchvalue');

            $this->db->where($serchby, "$searchvalue");
        }
        if ($limit && $start) {
            $this->db->limit($limit, $start);
        }
        if ($uclientid) {
            $this->db->where('cservice.clientId', "$uclientid");
            $this->db->select('cservice.*,user.userName,user.id as usrid');
            $this->db->from('client_contract_services AS cservice');
            $this->db->join('client_details AS cdetail', 'cservice.clientId = cdetail.id', 'INNER');
            $this->db->join('users AS user', 'cdetail.userId = user.id', 'INNER');
            $result = $this->db->get();
            //return $result->result_array();
            //$result = $this->db->get('client_contract_services');				
            //echo $this->db->last_query();die;
            //die('if');
            return $result->result_array();
        } else {
            $this->db->select('cservice.*,user.userName,user.id as usrid');
            $this->db->from('client_contract_services AS cservice');
            $this->db->join('client_details AS cdetail', 'cservice.clientId = cdetail.id', 'INNER');
            $this->db->join('users AS user', 'cdetail.userId = user.id', 'INNER');
            //$this->db->group_by('cservice.clientId');
            $result = $this->db->get();
            return $result->result_array();
        }
    }

    /**
     * @ Function Name	: getclient_service_detail
     * @ Function Params	: contactpersonId {Array/integer}
     * @ Function Purpose 	: get Contact person list for client_contact_persons table
     * @ Function Returns	: 
     */
    function getclient_service_detail($clientId) {
        $result = $this->db->get_where('client_contract_services', array('clientId' => $clientId));
        return $result->result_array();
    }

    /**
     * @ Function Name	: contactpersondelete
     * @ Function Params	: $clntid,$serviceid  {Array/integer}
     * @ Function Purpose 	: Delete of client service.
     * @ Function Returns	: 
     */
    function cservicedelete($clntid = null, $serviceid = null) {
        if ($clntid && $serviceid) {
            $this->db->where('clientId', "$clntid");
            $this->db->where("id IN (" . $serviceid . ")", "", FALSE);
            return $this->db->delete('client_contract_services');
        }
    }

    /**
     * @ Function Name	: getallpermissions
     * @ Function Params	: $userId {Array/integer}
     * @ Function Purpose 	: get all permission list.
     * @ Function Returns	: 
     */
    function getallpermissions($usrId = null) {
        $result = $this->db->get('users_permission_master');
        return $result->result_array();
    }

    /**
     * @ Function Name	: getallfolders
     * @ Function Params	: $userId {Array/integer}
     * @ Function Purpose 	: get all Default folder list.
     * @ Function Returns	: 
     */
    function getallfolders($userid, $task) {

        //echo $userid; echo '<br/>'.$task;
        if ($task == '' && $userid) {
            $result = $this->db->get_where('folder_master', array('userId' => "$userid"));
        } elseif ($task == 'getbychildefolder' && $userid) {
            $result = $this->db->get_where('folder_master', array('userId' => "$userid", 'parentId !=' => "0"));
        } elseif ($task == 'getbyId' && $userid != '') {
            $this->db->select('userId,parentId,folderName,id,googleFolderName,googlefolderId,folderLevel');
            $result = $this->db->get_where('folder_master', array('id' => "$userid"));
            //echo $this->db->last_query();die;
        } elseif ($task == 'byuserId' && $userid != '') {
            $this->db->select('userId,parentId,folderName,id,googleFolderName,googlefolderId,folderLevel');
            $result = $this->db->get_where('folder_master', array('userid' => "$userid"));
            //echo $this->db->last_query();die;
        } else {
            $result = $this->db->get('folder_master');
        }

        return $result->result_array();
    }

    /**
     * @ Function Name	: savefolder
     * @ Function Params	: $id {Array/integer}
     * @ Function Purpose 	: delete users by id
     * @ Function Returns	: 
     */
    function savefolder($array) {

        if (isset($array['id']) && $array['id'] != null) {
            $this->db->update('folder_master', $array, array('id' => $array['id']));
            $this->session->unset_userdata('folderArrayset');
            return 'update';
        } else {
            $this->db->insert('folder_master', $array);
            $this->session->unset_userdata('folderArrayset');
            return 'add';
        }
    }

    /**
     * @ Function Name	: deletefolder
     * @ Function Params	: $id {Array/integer}
     * @ Function Purpose 	: delete folder by id
     * @ Function Returns	: 
     */
    function deletefolder($deletefolderArray) {
        $folderId = $deletefolderArray['id'];
        if (isset($folderId)) {
            $this->db->where("id IN (" . $folderId . ")", "", FALSE); /* delete user_details table */
            $this->db->delete('folder_master');
            return 'delete';
        }
    }

    function allfolders_pagination($id, $limit = null, $start = null) {

        if ($limit && $start) {
            $this->db->limit($limit, $start);
        } else {
            $this->db->order_by("id", "asc");
        }
        $this->db->select('folder.*, usr.userName as clientName');
        $this->db->from('folder_master as folder');
        $this->db->join('users as usr', 'usr.id=folder.userId', 'INNER');
        $this->db->where('folder.userId', $id);
        $result = $this->db->get();
        //echo $this->db->last_query();//die;
        return $result->result_array();
    }

    /**
     * @ Function Name	: getallpermissions
     * @ Function Params	: $userId {Array/integer}
     * @ Function Purpose 	: get all permission list.
     * @ Function Returns	: 
     */
    function getuserpermissions($userId = null) {
        $result = $this->db->get_where('users_permission', array('userId' => "$userId"));
        return $result->row_array();
    }

    /* Get client folder permissions */

    function getclientfolderPermission($userId = null) {
        $result = $this->db->get_where('users_folder_permission', array('userId' => "$userId"));
        //die($this->db->last_query());
        return $result->row_array();
    }

    /**
     * @ Function Name	: savepermissions
     * @ Function Params	: $userId {Array/integer}
     * @ Function Purpose 	: get all permission list.
     * @ Function Returns	: 
     */
    function savepermissions($perid, $userId, $permissionarray) {
        if ($perid) {
            return $this->db->update('users_permission', $permissionarray, array('userId' => $userId, 'id' => $perid));
        } else {
            return $this->db->insert('users_permission', $permissionarray);
        }
    }

    /**
     * @ Function Name	: getclientallfolders
     * @ Function Params	: $id {Array/integer}
     * @ Function Purpose 	: get all folder list.
     * @ Function Returns	: 
     */
    function getclientallfolders($id) {
        $result = $this->db->get_where('folder_master', array('userId' => $id, 'parentId !=' => '0'));
        return $result->result_array();
    }

    /* first time refresh token */

    public function new_savegooglerefreshToken($accessToken) {

        $clientEmailArray = $this->session->userdata('saveclientSessionArray');
        $clientEmail = $clientEmailArray['googleloginDetail']['email'];

        $result = $this->db->get_where('refresh_token', array('emailId' => $clientEmail));
        $array = $result->num_rows();

        $save = array('refreshToken' => $accessToken);

        if ($array > 0) {
            $result = $this->db->update('refresh_token', $save, array('emailId' => $clientEmail));
            $this->session->unset_userdata('tokenArray');
            //die($this->db->last_query());
            return $result;
        } else {
            $result = $this->db->insert('refresh_token', $save = array_merge($save, array('emailId' => $clientEmail)));
            $this->session->unset_userdata('tokenArray');
            //die($this->db->last_query());
            return $result;
        }
    }

    /* Get all refresh token */

    public function getAllrefreshToken($accessToken = null) {

        $result = $this->db->get('refresh_token');
        return $refreshTokenarray = $result->result_array();
    }

    /**
     * @ Function Name	: savegooglerefreshToken
     * @ Function Purpose 	: Save client google refresh token
     * @ Function Returns	: array
     */
    public function savegooglerefreshToken($accessToken) {
        /* Check user refresh token is exist or not */
        $userEmail_array = $this->session->userdata('tokenArray');
        $userEmail = $userEmail_array['clientEmailid'];

        $clientid_array = $this->session->userdata('tokenArray');
        $clientid = $clientid_array['gmlclientid'];

        $result = $this->db->get_where('refresh_token', array('userId' => $clientid));
        $array = $result->num_rows();

        $save = array('refreshToken' => $accessToken, 'emailId' => $userEmail,);

        if ($array > 0) {
            $result = $this->db->update('refresh_token', $save, array('userId' => $clientid));
            $this->session->unset_userdata('tokenArray');
            //die($this->db->last_query());
            return $result;
        } else {
            $result = $this->db->insert('refresh_token', $save = array_merge($save, array('userId' => $clientid)));
            $this->session->unset_userdata('tokenArray');
            //die($this->db->last_query());
            return $result;
        }
    }

    /* Get google email by id */

    function getGoogleEmailbyId($clientid) {
        $this->db->select('email');
        $result = $this->db->get_where('google_login_detail', array('userId' => $clientid));
        return $result->row_array();
    }

    /* Get google client refresh token  by Email */

    public function getAccesrefreshToken($email) {
        $result = $this->db->get_where('refresh_token', array('emailId' => $email));
        $array = $result->row_array();
        return $array;
    }

    /* Get Existing Numera Email and Password */

    public function getNumeraEmailDetail($task = null) {

        if ($task == "addEdit") {
            $id = $this->input->post('numeraEmailId');
            ///pr($this->input->post('numeraEmailId'));
            $dataArray = array(
                'numeraEmail' => $this->input->post('numeraEmail'),
                'numeraPassword' => $this->input->post('numeraPassword'),
            );

            if ($id) {
                $result = $this->db->update('numera_email', $dataArray, array('id' => $id));
                return 'Eupdate';
            } else {
                $result = $this->db->insert('numera_email', $dataArray);
                return 'Eadd';
            }
        } else {
            $result = $this->db->get('numera_email');
            $array = $result->row_array();
            //die($this->db->last_query());
            return $array;
        }
    }

    public function checkUserFolderexist($str, $clientid) {
        $result = $this->db->get_where('folder_master', array('userId' => $clientid, 'folderName' => $str));
        return $result->result_array();
    }

    /* public function getInboxMessage() {
      $this->db->select("m.id,userName,userEmail,subject,message,attachment,created_date");
      $this->db->from("manage_message m");
      $this->db->join("users u","u.id = m.user_id");
      $this->db->where("message_type", "inbox");
      $this->db->order_by("m.id", "DESC");
      $query = $this->db->get();
      return $query->result_array();
      } */

      public function getAllInboxCount() {
		$this->db->select('id');
		$this->db->from('manage_message');
		$this->db->where("message_type", "inbox");
		return $result = $this->db->get()->num_rows();
      }

    public function getPaginatedInboxMsg($limit, $start) {
        $this->db->select("m.id,m.user_id,m.notification_flag,userName,userEmail,subject,message,attachment,created_date");
        $this->db->from("manage_message m");
        $this->db->join("users u", "u.id = m.user_id");
        $this->db->where("m.reply_id", 0);
        //$this->db->where("m.receiver", 0);
        $this->db->limit($limit, $start);
        $this->db->order_by("m.id", "DESC");

        $query = $this->db->get();
        return $query->result_array();
    }

    /*public function getOutboxMessage() {
        $this->db->select("m.id,userName,userEmail,subject,message,attachment,created_date");
        $this->db->from("manage_message m");
        $this->db->join("users u", "u.id = m.user_id");
        $this->db->where("message_type", "outbox");
        $this->db->order_by("m.id", "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }*/
    
        public function getAllOutboxCount() {
        $this->db->select('id');
        $this->db->from('manage_message');
        $this->db->where("message_type", "outbox");
        return $result = $this->db->get()->num_rows();
    }
	
   /*Set message Is Readed or Not*/	
    	function set_message_readed($msgId) {
		$save = array(
		    'notification_flag' => '1',
		);
		$result = $this->db->update('manage_message', $save, array('id' => $msgId));
		//return $result;
    	}

    public function getPaginatedOutboxMsg($limit, $start) {
        $this->db->select("m.id,userName,userEmail,subject,message,attachment,created_date");
        $this->db->from("manage_message m");
        $this->db->join("users u", "u.id = m.user_id");
        $this->db->where("message_type", "outbox");
        $this->db->limit($limit, $start);
        $this->db->order_by("m.id", "DESC");

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getMessage($msgID) {
        $this->db->select("subject,message,created_date");
        $result = $this->db->get_where('manage_message', array('id' => $msgID));
        return $result->row_array();
    }

    public function addMessage($dataArray) {
        $result = $this->db->insert('manage_message', $dataArray);
        return $this->db->insert_id();
        ;
    }

    /* get all users */

    function getAllUsers() {
        $this->db->select('u.id,userEmail,fname,lname');
        $this->db->join('user_details as ud', 'ud.userId=u.id', 'INNER');
        $result = $this->db->get_where('users as u', array('u.userRoleId' => 3));                    // userRoleId = 3 for users
        return $result->result_array();
    }

    /* get all users by client ID */

    function getAllUsers_byClientID($clientid) {
        $this->db->select('u.id,userEmail,fname,lname');
        $this->db->join('user_details as ud', 'ud.userId=u.id', 'INNER');
        $result = $this->db->get_where('users as u', array('ud.clientId' => $clientid));
        return $result->result_array();
    }

    // get email of particular user
    function getUserEmailByID($id) {
        $result = $this->db->get_where('users', array('id' => $id));
        $userinfo['email'] = $result->row()->userEmail;
        $userinfo['username'] = $result->row()->userName;
        return $userinfo;
    }

    function getUserReplyDetail($id){
        $this->db->select('user_id,subject');
        $this->db->where('id',$id);
        $this->db->from('manage_message');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $records = $query->row_array();
            return $records;
        } else {
            return false;
        } 
    }

    //get All message by user ID
    function getHistoryMsgByUser($id){
        $this->db->select('ud.*,mm.*');
        $this->db->where('mm.reply_id',$id);
        $this->db->join("manage_message mm", "ud.userId = mm.user_id");
        $this->db->from('user_details ud');
        $this->db->order_by('mm.id', 'ASC');
        $this->db->order_by('mm.created_date', 'ASC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $records = $query->result_array();
            return $records;
        } else {
            return false;
        } 
    }


}

?>
