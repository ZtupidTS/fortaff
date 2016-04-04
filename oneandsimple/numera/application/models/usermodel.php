<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* * * Users Model Class
 *
 * @package Numera
 * @subpackage Frontend
 */

class Usermodel extends CI_Model {

    /**
     * @ Function Name	: checkUserCredential
     * @ Function Purpose 	: check the user credential submitted from login form
     * @ Function Returns	: 
     */
    public function checkUserCredential($username, $password) {
        //$result = $this->db->get_where('users', array('userName' => $username,'userPassword' => $password,'userRoleId !='=>'1'));
        //die($this->db->last_query());
        $this->db->from('users AS usr');
        $this->db->join('user_details AS udetail', 'udetail.userId = usr.id', 'INNER');
        $this->db->where(array('usr.userName' => $username, 'usr.userPassword' => $password, 'usr.userRoleId !=' => '1'));
        //$this->db->where("usr.userRoleId =".$roleid);
        $result = $this->db->get();
        return $result->row_array();
    }

    /* Check user password is exist or not */

    function checkusrpwdxist($pwd, $id) {
        $result = $this->db->get_where('users', array('userPassword' => $pwd, 'id' => $id, 'userRoleId !=' => '1'));
        //die($this->db->last_query());
        return $result->row_array();
    }

    /* check user status */

    function userstatus($username) {
        $result = $this->db->get_where('users', array('userName' => $username, 'userStatus' => 'inactive', 'userRoleId !=' => '1'));
        //die($this->db->last_query());
        return $result->row_array();
    }

    /**
     * @ Function Name	: checkClientCredential
     * @ Function Purpose 	: check the client credential submitted from login form
     * @ Function Returns	: 
     */
    public function checkClientCredential($username, $password) {
        $result = $this->db->get_where('google_login_detail', array('email' => $username, 'password' => $password));
        //die($this->db->last_query());
        return $result->row_array();
    }

    /* Check user name is exist or not */

    function checkUserexist($usr) {
        $result = $this->db->get_where('users', array('userName' => $usr, 'userRoleId !=' => '1'));
        //die($this->db->last_query());
        return $result->row_array();
    }

    /* Get google email by id */

    function getGoogleEmailbyId($clientid) {
        $this->db->select('email');
        $result = $this->db->get_where('google_login_detail', array('userId' => $clientid));
        //die($this->db->last_query());
        return $result->row_array();
    }

    /* update users upassword */

    function updatepassword($userId = null, $newpwd = null) {
        $save = array(
            'userPassword' => $newpwd,
        );
        $result = $this->db->update('users', $save, array('id' => $userId));
        return $result;
    }

    /* update users Languge */

    function setdefaultlanguge($userId = null, $language = null) {
        $save = array(
            'userlanguage' => $language,
        );
        $this->db->update('users', $save, array('id' => $userId, 'userRoleId' => '3'));
    }

    /**
     * @ Function Name	: getUserDetailByUsername
     * @ Function Purpose 	: get the detail of user as per username
     * @ Function Returns	: array
     */
    public function getUserDetailByUsername($username) {
        if (empty($username)) {
            return FALSE;
        }
        $this->db->where('usrEmail', $username);
        $user_details = $this->db->get('tbl_users')->row();
        return $user_details;
    }

    /**
     * @ Function Name	: getloggedinUserDetailbyId
     * @ Function Purpose 	: get the detail of user as per user Id
     * @ Function Returns	: array
     */
    public function getloggedinUserDetailbyId($userid) {
        if ($userid) {
            $this->db->select('udetail.id,udetail.userId as userId,usr.userName,usr.userEmail,usr.userImage,usr.userPhone,usr.userRoleId,
				  usr.userStatus,udetail.fname,udetail.lname,udetail.profession,udetail.clientId as clientId,
				  usrclnt.userName as clientname, usrfoldrpermission.*');
            $this->db->from('users AS usr');
            $this->db->where("usr.id = $userid");
            //$this->db->where("usr.userRoleId =".$roleid);
            $this->db->join('user_details AS udetail', 'udetail.userId = usr.id', 'INNER');
            $this->db->join('users AS usrclnt', 'usrclnt.id = udetail.clientId', 'INNER');
            $this->db->join('users_permission AS upermission', 'upermission.userId = usr.id', 'left');
            $this->db->join('users_folder_permission AS usrfoldrpermission', 'usrfoldrpermission.userId = usr.id', 'left');
            $result = $this->db->get();
            //echo $this->db->last_query();die;
            return $result->row_array();
        }
    }

     /**
     * @ Function Name	: getUserDetails
     * @ Function Purpose 	: get the detail of user as per user Id
     * @ Function Returns	: array
     */
      public function getUserDetails($id){
	   $this->db->select('userName,userEmail');		
	   $array = array('id' => "$id");
	   $this->db->where($array);
	   $result = $this->db->get('users');
	   $result_array = $result->row();
	   //die($this->db->last_query());
	   return $result_array;
      }	

    /**
     * @ Function Name	: getloggedinClientDetailbyId
     * @ Function Purpose 	: get the detail of client as per user Id
     * @ Function Returns	: array
     */
    public function getloggedinClientDetailbyId($clientid) {
        if (isset($clientid)) {
            $this->db->select('cdetail.*, gglClientDtl.email,gglClientDtl.password,clientusr.userName as userName,clientusr.userEmail as clientEmail,clientusr.userImage,clientusr.userPhone as clientphone,clientusr.userRoleId as clientrole,clientusr.userStatus as clientstatus, clientusr.userCreateDate as registerdate,clientusr.userUpdateDate as updatedate');
            $this->db->from('client_details AS cdetail');
            $this->db->join('users AS clientusr', 'clientusr.id = cdetail.userId ', 'INNER');
            $this->db->join('google_login_detail AS gglClientDtl', 'gglClientDtl.userId = cdetail.userId ', 'LEFT');
            $this->db->where("cdetail.userId = $clientid");
            $result = $this->db->get();
            //$result = $this->db->get_where('client_details', array('userId' => $uid));
            return $result->row_array();
        }
    }

    /**
     * @ Function Name	: resetPassword
     * @ Function Purpose 	: update the password of user
     * @ Function Returns	: boolean
     */
    public function resetPassword($user_id) {
        $password = $this->input->post('password');

        $where = array('usrId' => $user_id);
        $update_data = array('usrPassword' => md5($password), 'usrUniqueCode' => '');
        if ($this->db->update('tbl_users', $update_data, $where)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @ Function Name	: update
     * @ Function Purpose 	: update the customer profile
     * @ Function Returns	: boolean
     */
    public function update($task) {
        $return = FALSE;
        //pr($_POST);
        if (@$_FILES['userImage']['name'] != '') {
            $uploaded_data = $this->do_file_upload('users/', 'userImage');
        } else {
            if ($this->input->post('userImage_old')) {
                $uploaded_data['upload_data']['file_name'] = $this->input->post('userImage_old');
            } else {
                $uploaded_data = array('error' => '', 'upload_data' => array('file_name' => 'no-image.gif'));
            }
        }
        if ($task == 'user') {
            $id = $this->session->userdata('userid');
            $updateuser = array(
                'userName' => $this->input->post('userName'),
                'userEmail' => $this->input->post('userEmail'),
                'userPhone' => $this->input->post('userPhone'),
                'userImage' => $uploaded_data['upload_data']['file_name'],
                'userUpdateDate' => date('Y-m-d H:i:s')
            );
            $updateuser_detail = array(
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'profession' => $this->input->post('profession'),
            );
            $where_udetail = array('userId' => $id);
            $this->db->update('user_details', $updateuser_detail, $where_udetail);

            /* Remove old image */
            if (isset($_FILES['userImage']['name']) && !empty($_FILES['userImage']['name'])) {
                $result = $this->db->get_where('users', array('id' => $id));
                $imageDetail = $result->row_array();
                if ($imageDetail['userImage'] !== 'no-image.gif' && $task != 'admin') {
                    unlink('./uploads/users/' . $imageDetail['userImage']);
                }
            }
        }
        $where = array('id' => $id);
        if ($this->db->update('users', $updateuser, $where)) {
            return 'update';
        } else {
            return 'noupdate';
        }
    }

    function do_file_upload($path, $fileName) {
        $config['upload_path'] = './uploads/' . $path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->load->library('upload', $config);
        $this->upload->do_upload($fileName);
        return array('error' => $this->upload->display_errors(), 'upload_data' => $this->upload->data());
    }

    /**
     * @ Function Name		: checkOldPassword
     * @ Function Purpose 	: check the old password of users before updating new password
     * @ Function Returns	: boolean
     */
    public function checkOldPassword() {
        $user_id = $this->session->userdata('uid');
        $old = $this->input->post('oldpassword');

        $this->db->select('usrPassword');
        $this->db->where('usrId', $user_id);
        $detail = $this->db->get('tbl_users')->row();
        if ($detail->usrPassword == md5($old)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function currentUser() {
        $this->db->select("usrFirstName,usrLastName,usrEmail");
        $this->db->where('usrId', $this->session->userdata('uid'));
        $this->db->from('tbl_users');
        return $this->db->get()->row_array();
    }

    /**
     * @ Function Name		: getUserDetailsByEmail
     * @ Function Purpose 	: get the detail of user as per email
     * @ Function Returns	: array
     */
    public function getUserDetailsByEmail($email) {
        $array = array('userEmail' => $email, 'userStatus' => 'active', 'userRoleId !=' => '1');
        $this->db->where($array);
        $result = $this->db->get('users');
        $user_details = $result->row();
        //die($this->db->last_query());
        return $user_details;
    }

    /**
     * @ Function Name	: getUserGoogleidbyemail
     * @ Function Purpose 	: get the detail of google_login_detail`  as email
     * @ Function Returns	: array
     */
    public function getUserGoogleidbyemail($email, $id) {
        $array = array('userId' => "$id");
        $this->db->where($array);
        $result = $this->db->get('google_login_detail` ');
        $user_details = $result->row();
        //die($this->db->last_query());
        return $user_details;
    }

    /**
     * @ Function Name	: getUserdocumentbyId
     * @ Function Purpose 	: get the detail of doucments by id
     * @ Function Returns	: array
     */
    public function getUserdocumentbyId() {
        $userid = $this->session->userdata('userId');
        $array = array('userId' => "$userid");
        $this->db->where($array);
        $result = $this->db->get('users_folder_permission` ');
        $user_folders = $result->row();
        //die($this->db->last_query());
        return $user_folders;
    }

    /**
     * @ Function Name	: getuserfolderlist
     * @ Function Purpose 	: get user folder list which alloted by client.
     * @ Function Returns	: array
     */
    public function getuserfolderlist($folderId_array) {
        //$array = array('userId'=>"$userid");
        $this->db->where_in('id', $folderId_array);
        $result = $this->db->get('folder_master');
        $folderslist = $result->result_array();
        //pre($folderslist);
        //die($this->db->last_query());
        return $folderslist;
    }

    /* Get client parent folder */

    public function getclientparentfolder($clientid) {
        //$array = array('userId'=>"$userid");
        $array = array('userId' => "$clientid", 'parentId' => 0);
        $this->db->where($array);
        $result = $this->db->get('folder_master');
        $folderslist = $result->row_array();
        //die($this->db->last_query());
        return $folderslist;
    }

    /**
     * @ Function Name	: getuserfolderlist
     * @ Function Purpose 	: get user folder list which alloted by client.
     * @ Function Returns	: array
     */
    public function getrecentfolders($googlefolderid) {
        $this->db->where_in('googlefolderId', $googlefolderid);
        $result = $this->db->get('folder_master');
        return $recentfolders = $result->row_array();
        //die($this->db->last_query());
    }

    /**
     * @ Function Name	: saverecentfolder
     * @ Function Purpose 	: get user folder list which alloted by client.
     * @ Function Returns	: array
     */
    public function saverecentfolder($recentsaveArray) {
        $googlefolderid = $recentsaveArray['doc_id'];
        $this->db->where_in('doc_id', $googlefolderid);
        $result = $this->db->get('recent_docs');
        $recentfolders = $result->row_array();
        $recentsaveArray = array_merge($recentsaveArray, array('visitedate' => date("Y-m-d H:i:s", time())));
        if (count($recentfolders) > 0) {
            $result = $this->db->update('recent_docs', $recentsaveArray, array('doc_id' => $googlefolderid));
            return 'update';
        } else {
            $result = $this->db->insert('recent_docs', $recentsaveArray);
            return 'add';
        }
        //die($this->db->last_query());
    }

    /**
     * @ Function Name	: saverecentfiles
     * @ Function Purpose 	: save all recent opration for file, like upload, delete,edit etc.
     * @ Function Returns	: array
     */
    public function saverecentfiles($array) {
        @$googlefolderid = $array['doc_id'];
        $this->db->where_in('doc_id', $googlefolderid);
        $result = $this->db->get('recent_docs');
        $recentfolders = $result->row_array();
        //pr($array);
        $array = array_merge($array, array('visitedate' => date("Y-m-d H:i:s", time())));
        if (count($recentfolders) > 0) {
            $result = $this->db->update('recent_docs', $array, array('doc_id' => $googlefolderid));
            return 'update';
        } else {
            $result = $this->db->insert('recent_docs', $array);
            return 'add';
        }
        //die($this->db->last_query());
    }

    /**
     * @ Function Name	: getrecentdoclist
     * @ Function Purpose 	: get user folder list which alloted by client.
     * @ Function Returns	: array
     */
    public function getrecentdoclist($id) {
        $this->db->where_in('user_id', $id);
        $result = $this->db->get('recent_docs');
        //die($this->db->last_query());
        return $result->result_array();
    }

    /**
     * @ Function Name	: getclientfolderlist
     * @ Function Purpose 	: get user folder list which alloted by admin.
     * @ Function Returns	: array
     */
    public function getclientfolderlist($clientid) {
        //$array = array('userId'=>"$userid");
        $this->db->where_in('userId', $clientid);
        $result = $this->db->get('folder_master` ');
        $folderslist = $result->result_array();
        //die($this->db->last_query());
        return $folderslist;
    }

    /**
     * @ Function Name	: savegooglerefreshToken
     * @ Function Purpose 	: Save client google refresh token
     * @ Function Returns	: array
     */
    public function savegooglerefreshToken($clientid, $accessToken) {
        //$userEmail = $this->session->userdata('email');
        $result = $this->db->get_where('google_login_detail', array('userId' => $clientid));
        $result_clientArray = $result->row_array();
        $userEmail = $result_clientArray['email'];

        /* Check user refresh token is exist or not */
        $result = $this->db->get_where('refresh_token', array('userId' => $clientid));
        $array = $result->num_rows();
        $save = array('refreshToken' => $accessToken,
            'emailId' => $userEmail,
        );

        if ($array > 0) {
            $result = $this->db->update('refresh_token', $save, array('userId' => $clientid));
            return $result;
        } else {
            $result = $this->db->insert('refresh_token', $save = array_merge($save, array('userId' => $clientid)));
            return $result;
        }
    }

    public function getAccesrefreshToken($email) {
        $result = $this->db->get_where('refresh_token', array('emailId' => $email));
        $array = $result->row_array();
        return $array;
    }

    /**
     * @ Function Name	: getallfolders
     * @ Function Params	: $userId {Array/integer}
     * @ Function Purpose 	: get all Default folder list.
     * @ Function Returns	: 
     */
    function getallfolders($userid, $task) {

        if ($task == '' && $userid) {
            $this->db->order_by("folderLevel", "asc");
            $result = $this->db->get_where('folder_master', array('userId' => "$userid"));
            //echo $this->db->last_query();die;
        } elseif ($task == 'getbyId' && $userid != '') {
            $this->db->select('userId,parentId,folderName,id,googleFolderName,googlefolderId,folderLevel');
            $result = $this->db->get_where('folder_master', array('id' => "$userid"));
            //echo $this->db->last_query();die;
        } elseif ($task == 'parentId' && $userid != '') {
            $this->db->select('userId,parentId,folderName,id,googleFolderName,googlefolderId,folderLevel');
            $result = $this->db->get_where('folder_master', array('id' => "$userid"));
            //echo $this->db->last_query();die;
        } else {
            $result = $this->db->get('folder_master');
        }

        return $result->result_array();
    }

    function getfolderbygoogelfid($userid) {
        $this->db->select('userId,parentId,folderName,id,googleFolderName,googlefolderId');
        $result = $this->db->get('folder_master');
        return $result->result_array();
    }

    /* Get user recent doc list */

    function getusersrecentlist($limit = null, $start = null, $show = null) {

        if ($limit && $start) {
            $this->db->limit($limit, $start);
        } else {
            $this->db->order_by("id", "desc");
        }
        $this->db->select('*');
        $this->db->from('recent_docs');
        //$this->db->join('users as usr', 'usr.id=folder.userId', 'INNER');
        if ($show == 'folder') {
            $this->db->where(array('user_id' => $this->session->userdata('userid'), 'doc_type' => 'application/vnd.google-apps.folder'));
        } else {
            $this->db->where(array('user_id' => $this->session->userdata('userid'), 'doc_type !=' => 'application/vnd.google-apps.folder'));
        }

        $result = $this->db->get();
        //echo $this->db->last_query();die;
        return $result->result_array();
    }

    /* update google folder key */

    function updategooglefolderkey($folderid = null, $newkey = null) {
        $save = array(
            'googlefolderId' => $newkey,
        );
        $this->db->update('folder_master', $save, array('id' => $folderid));
        //return $result;
    }

    /* Test code is working or not */
    /* 	function textcode($id){
      $save = array(
      'adminFooterTxt'=>'codeworking',
      );
      $this->db->update('users',$save,array('id'=>$id));
      }
     */


    /* Rubina */
    /* get notification count of login user */

    function getNotificationCountByUserid($id) {
        $result = $this->db->get_where('manage_message', array('receiver' => $id, 'notification_flag' => 0));
        return $result->num_rows();
    }

    public function getInboxMessage($userid ,$limit, $start) {
        
            if($limit !='' && $start !=''){
                        $this->db->limit($limit, $start);		
            }
            $this->db->select('msg.*,rcvrusr.userName as rcvruserName,rcvrrole.roleName as rcvrRole,sndrbusr.id as senderuserId,sndrrole.roleName as sndrRole,sndrbusr.userName as sendername');
            $this->db->from('manage_message AS msg');
            $this->db->join('users AS sndrbusr', 'sndrbusr.id = msg.user_id', 'INNER'); //To
            $this->db->join('users_role AS sndrrole', 'sndrrole.id = sndrbusr.userRoleId', 'INNER'); //To

            $this->db->join('users AS rcvrusr', 'rcvrusr.id = msg.receiver', 'INNER'); //To
            $this->db->join('users_role AS rcvrrole', 'rcvrrole.id = rcvrusr.userRoleId', 'INNER'); //From
            //$this->db->or_where(array('msg.user_id'=>$userid,'msg.receiver'=>$userid));
            //$where = "(msg.user_id='".$userid."' and msg.receiver='".$userid."') or (msg.receiver='".$userid."' and msg.user_id='".$userid."') and msg.show_in_inbox='y'"; 
            $where = "(msg.user_id='".$userid."' or msg.receiver='".$userid."') and msg.show_in_inbox='y'"; 
            $this->db->where($where);
            //$this->db->where(array('msg.user_id'=>$userid,'msg.receiver'=>$userid));
            //$this->db->where(array('msg.show_in_inbox'=>'y'));
            
            //$this->db->or_where(array('chatusr.from'=>$loggedinAuthId,'chatusr.to'=>$loggedinAuthId));
            //$this->db->where(array('chatusr.ch_isDelete'=>'1'));    
            
            $this->db->order_by("msg.id", "desc");
            //$this->db->group_by('msg.receiver'); 
            //$this->db->group_by('msg.user_id'); 
            //$this->db->group_by('msg.show_in_inbox'); 
            //$this->db->where(array('chatusr.ch_isDelete'=>'1'));    
            $result = $this->db->get();
            //pr($result);
            //die($this->db->last_query());
            return $result->result_array();
        
        return $record;
    }

    public function getOutboxMessage() {
        $this->db->select("*");
        $this->db->from("manage_message");
        $this->db->where("message_type", "inbox");
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function addMessage($dataArray) {
       // pre($dataArray);
        /*set N for all old message message*/
        $updateArray = array(
            'show_in_inbox' => 'n',
        );
        $where = "(user_id='".$dataArray['user_id']."' and receiver='".$dataArray['receiver']."') OR (receiver='".$dataArray['user_id']."' and user_id='".$dataArray['receiver']."') "; 
        //pr($where);
        $this->db->update('manage_message', $updateArray, $where);
        //die($this->db->last_query());
        $result = $this->db->insert('manage_message', $dataArray);
	 
        
        
        return $this->db->insert_id();
    }

    function getUserReplyDetail($id){
        $this->db->select('user_id,subject,receiver');
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
   
    function getAllUsers_byClientID($clientid,$uid) {
        $this->db->select('u.id,userEmail,fname,lname');
        $this->db->join('user_details as ud', 'ud.userId=u.id', 'INNER');
        $result = $this->db->get_where('users as u', array('ud.clientId' => $clientid,'userId !=' => $uid));
        
        //die($this->db->last_query());
        return $result->result_array();
    }

    function getHistoryMsgByUser($id,$byuname,$otheruid){
        //echo $usrid;
        $loggedinUid = $this->session->userdata('userid');
        $this->db->select('msg.*,rcvrusr.userName as rcvruserName,rcvrrole.roleName as rcvrRole,sndrbusr.id as senderuserId,sndrrole.roleName as sndrRole,sndrbusr.userName as sendername');
        $this->db->from('manage_message AS msg');
        $this->db->join('users AS sndrbusr', 'sndrbusr.id = msg.user_id', 'INNER'); //To
        $this->db->join('users_role AS sndrrole', 'sndrrole.id = sndrbusr.userRoleId', 'INNER'); //To
        $this->db->join('users AS rcvrusr', 'rcvrusr.id = msg.receiver', 'INNER'); //To
        $this->db->join('users_role AS rcvrrole', 'rcvrrole.id = rcvrusr.userRoleId', 'INNER'); //From
        $where = "(msg.user_id='".$loggedinUid."' and msg.receiver='".$otheruid."') or (msg.receiver='".$loggedinUid."' and msg.user_id='".$otheruid."') and msg.show_in_inbox!='y'"; 
        $this->db->where($where);    
        
//        $this->db->select('ud.*,mm.*');
//        $this->db->from('user_details ud');
//        $this->db->join("manage_message mm", "ud.userId = mm.user_id",'INNER');
//        $this->db->where('mm.reply_id',$id);
//        $this->db->order_by('mm.id', 'ASC');
//        $this->db->order_by('mm.created_date', 'ASC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $records = $query->result_array();
            return $records;
        } else {
            return false;
        } 
    }
	
    function setReadMessage($reply_id){
        $save = array(
            'notification_flag' => 0,
        );
        $result = $this->db->update('manage_message', $save, array('reply_id' => $reply_id));
        return $result;
    } 
}
?>

