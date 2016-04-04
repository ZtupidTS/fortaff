<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Function Name		: pr
 * @ Function Params	: $data {mixed}, $kill {boolean}
 * @ Function Purpose 	: formatted display of value of varaible
 * @ Function Returns	: foramtted string
 */
function pr($data, $kill = true) {
    $str = "";
    if ($data != '') {
        $str .= str_repeat("=", 25) . " " . ucfirst(gettype($data)) . " " . str_repeat("=", 25);
        $str .= "<pre>";
        if (is_array($data)) {
            $str .= print_r($data, true);
        }
        if (is_object($data)) {
            $str .= print_r($data, true);
        }
        if (is_string($data)) {
            $str .= print_r($data, true);
        }
        $str .= "</pre>";
    } else {
        $str .= str_repeat("=", 22) . " Empty Data " . str_repeat("=", 22);
    }

    if ($kill) {
        die($str .= str_repeat("=", 55));
    }
    echo $str;
}




function pre($data, $kill = true) {
    $str = "";
    if ($data != '') {
        $str .= str_repeat("=", 25) . " " . ucfirst(gettype($data)) . " " . str_repeat("=", 25);
        $str .= "<pre>";
        if (is_array($data)) {
            $str .= print_r($data, true);
        }
        if (is_object($data)) {
            $str .= print_r($data, true);
        }
        if (is_string($data)) {
            $str .= print_r($data, true);
        }
        $str .= "</pre>";
    } else {
        $str .= str_repeat("=", 22) . " Empty Data " . str_repeat("=", 22);
    }

    if ($kill) {
        echo $str .= str_repeat("=", 55);
    }else{
	echo $str;
    }
}

/**
 *
 * @param type $filename
 * @return type 
 */
if (!function_exists('current_file_name')) {
	function current_file_name($filename= '') {
		return basename(str_replace('\\', '/', $filename), ".php");
       
	   // $ext = pathinfo($filename, PATHINFO_EXTENSION);
        // $path = preg_replace('/\.' . preg_quote($ext, '/') . '$/', '', $filename);
        // $array = explode('\\', $path);
        // $len = count($array) - 1;
        // return $array[$len];
    }
}

/**
 *
 * @param type $filename
 * @return type 
 */

 if (!function_exists('current_file_dir')) {
    function current_file_dir($filename='') {
		return basename(dirname(str_replace('\\', '/', $filename))) . '/';

        // $ext = pathinfo($filename, PATHINFO_EXTENSION);
        // $path = preg_replace('/\.' . preg_quote($ext, '/') . '$/', '', $filename);
        // $array = explode('\\', $path);
        // $len = count($array) - 2;
        // if ($array[$len] != 'view') {
            // return $array[$len] . '/';
        // }
        // return;
    }

}
if (!function_exists('navigation_by_level')) {

    function navigation_by_level($level=0) {
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->where('navParentId', $level);
        $CI->db->order_by("order", "asc");
        $result = $CI->db->get("tbl_navigation");
        $result = $result->result();
        return $result;
    }

}
if (!function_exists('objectToArray')) {

    function objectToArray($obj) {
        print_r($obj);
        echo is_object($obj);
        if (is_object($obj)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $obj = get_object_vars($obj);
        }
    }

}

function walk_dir_folder_view($parent_id,$levelStr,$action){
		
		$levelStrs = $levelStr;
		
		global $options;
		
		$ci =& get_instance();
    		
		//echo $parent_id;
		$clientid = $ci->session->userdata('clientId');
		$viewfolderarray = $ci->session->userdata('userfolderpermissoin');
		
		
		$query = "select * from folder_master where userId =$clientid and parentId = ". $parent_id;
		$flieRes = $ci->db->query($query);
		$fileList = $flieRes->result_array();
		//pr($fileList);
		if(!empty($fileList)){
			foreach($fileList as $file){
				    //pre($fileList);
				  
				    if($action=='viewadd'){
					
					if(!empty($viewfolderarray->$file['id']->Viewfolder) && $viewfolderarray->$file['id']->Viewfolder == "accept" && !empty($viewfolderarray->$file['id']->Createfile) && $viewfolderarray->$file['id']->Createfile == "accept"){
					    if($levelStr == ""){
						$options .= "<option value=".$file['id'].">".$file['folderName']."</option>";
					    }
					    else{
						$options .= "<option value=".$file['id'].">".$levelStr."|__".$file['folderName']."</option>";    
					    }
					    $levelStrs = $levelStr."&nbsp;&nbsp;&nbsp;&nbsp;";
					}
				    }elseif($action=='viewmove'){
					if(!empty($viewfolderarray->$file['id']->Viewfolder) && $viewfolderarray->$file['id']->Viewfolder == "accept" && !empty($viewfolderarray->$file['id']->moovefile) && $viewfolderarray->$file['id']->moovefile == "accept"){
					    if($levelStr == ""){
						$options .= "<option value=".$file['id'].">".$file['folderName']."</option>";
					    }
					    else{
						$options .= "<option value=".$file['id'].">".$levelStr."|__".$file['folderName']."</option>";    
					    }
					    $levelStrs = $levelStr."&nbsp;&nbsp;&nbsp;&nbsp;";
					}
				    }elseif($action=='export'){
					if(!empty($viewfolderarray->$file['id']->Viewfolder) && $viewfolderarray->$file['id']->Viewfolder == "accept"){
					    if($levelStr == ""){
					    $options .= "<option value=".$file['id'].">".$file['folderName']."</option>";
					    }
					    else{
						$options .= "<option value=".$file['id'].">".$levelStr."|__".$file['folderName']."</option>";    
					    }
					    $levelStrs = $levelStr."&nbsp;&nbsp;&nbsp;&nbsp;";
					}
				    }
				walk_dir_folder_view($file['id'],$levelStrs,$action);	
			}
		}
		//pre($options);
		return $options ;
	}

/*Get user logged view folder array*/

function getviewfolderlist()
{
    $ci =& get_instance();
    $viewfolderarray = $ci->session->userdata('userfolderpermissoin');
    //pre($viewfolderarray);
    
    foreach($viewfolderarray as $ky=>$val)
    {
	if(@$val->Viewfolder=='accept')
	{
	    $folderkeyarray[]=$ky;
	    
	}
    }
    if(isset($folderkeyarray)){
	//pre($folderkeyarray);
	$folderids=implode(',',$folderkeyarray);
	if(!empty($folderids)){
	//pre($folderids);
	$ci->db->select("id,folderName,googlefolderId");
	$ci->db->where("id IN (" .$folderids. ")", "", FALSE);
	$result = $ci->db->get("folder_master");
	//echo $this->db->last_query();//die;
	return $result->result_array();
	}else {
	    return 0;
	}
    }
}

/*function getviewfolderlist()
{
    $ci =& get_instance();
    $viewfolderarray = $ci->session->userdata('userfolderpermissoin');
    //pre($viewfolderarray);
    foreach($viewfolderarray as $ky=>$val)
    {
	if(@$val->Viewfolder=='accept')
	{
	    $folderkeyarray[]=$ky;
	    
	}
    }
    if(isset($folderkeyarray)){
	//pre($folderkeyarray);
	$folderids=implode(',',$folderkeyarray);
	if(!empty($folderids)){
	//pre($folderids);
	$ci->db->select("id,folderName,googlefolderId");
	$ci->db->where("id IN (" .$folderids. ")", "", FALSE);
	$result = $ci->db->get("folder_master");
	//echo $this->db->last_query();//die;
	return $result->result_array();
	}else {
	    return 0;
	}
    }
}*/


function getviewfolderMove()
{
    $ci =& get_instance();
    $viewfolderarray = $ci->session->userdata('userfolderpermissoin');
    //pre($viewfolderarray);
    foreach($viewfolderarray as $ky=>$val)
    {
	if(@$val->Viewfolder=='accept' && @$val->moovefile=='accept')
	{
	    $folderkeyarray[]=$ky;
	    
	}
    }
    if(isset($folderkeyarray)){
	//pre($folderkeyarray);
	$folderids=implode(',',$folderkeyarray);
	if(!empty($folderids)){
	//pre($folderids);
	$ci->db->select("id,folderName");
	$ci->db->where("id IN (" .$folderids. ")", "", FALSE);
	$result = $ci->db->get("folder_master");
	//echo $this->db->last_query();//die;
	return $result->result_array();
	}else {
	    return 0;
	}
    }
}



function getList($tableName, $selectString, $orderingVar, $whereConditionVar, $likeConditionArray, $customConditionVar, $joinTableVar, $whereNotIn=array(),$groupby=array()) {
	
	$args = func_get_args();
	//pr($args);
	
    $CI = & get_instance();
    $CI->db->start_cache();
    $CI->db->select($selectString,FALSE);
    $CI->db->from($tableName);    
    foreach ($joinTableVar as $joinKey => $joinArray) {
        if ((isset($joinArray['tableName']) && ( $joinArray['tableName'] != "")) && (isset($joinArray['joinCondition']) && ( $joinArray['joinCondition'] != "")) && (isset($joinArray['joinType']) && ( $joinArray['joinType'] != ""))) {
            $CI->db->join($joinArray['tableName'], $joinArray['joinCondition'], $joinArray['joinType']);
        } elseif ((isset($joinArray['tableName']) && ( $joinArray['tableName'] != "")) && (isset($joinArray['joinCondition']) && ( $joinArray['joinCondition'] != ""))) {
            $CI->db->join($joinArray['tableName'], $joinArray['joinCondition']);
        } elseif ((isset($joinArray['tableName']) && ( $joinArray['tableName'] != ""))) {
            $CI->db->join($joinArray['tableName'], FALSE);
        }
    }
    foreach ($customConditionVar as $filterKey => $filterVal) {
        if ((isset($filterVal['parameter1']) && ($filterVal['parameter1'] != "")) && (isset($filterVal['parameter2']) && ($filterVal['parameter2'] != "")) && (isset($filterVal['parameter3']) && ($filterVal['parameter3'] != ""))) {
            $CI->db->where($filterVal['parameter1'], $filterVal['parameter2'], $filterVal['parameter3']);
        } elseif ((isset($filterVal['parameter1']) && ($filterVal['parameter1'] != "")) && (isset($filterVal['parameter2']) && ($filterVal['parameter2'] != "") )) {
            $CI->db->where($filterVal['parameter1'], $filterVal['parameter2']);
        } elseif (isset($filterVal['parameter1']) && ($filterVal['parameter1'] != "")) {
            $CI->db->where($filterVal['parameter1']);
        }
    }

    foreach ($whereConditionVar as $filterKey => $filterVal) {
        if ($filterVal != "") {
            if (count($joinTableVar) > 0) {
                if ($CI->db->field_exists($filterKey, $tableName)) {
                    $CI->db->where($tableName . "." . $filterKey, $filterVal);
                } else {
                    foreach ($joinTableVar as $joinKey => $joinArray) {
                        if (isset($joinArray['tableName']) && ( $joinArray['tableName'] != "") && $CI->db->field_exists($filterKey, $joinArray['tableName'])) {
                            $CI->db->where($joinArray['tableName'] . "." . $filterKey, $filterVal);
                            break;
                        }
                    }
                }
            } else {
                $CI->db->where($filterKey, $filterVal);
            }
        }
    }
    foreach ($whereNotIn as $filterKey => $filterVal) {
        if ($filterVal != "") {
            if (count($joinTableVar) > 0) {
                if ($CI->db->field_exists($filterKey, $tableName)) {
                    $CI->db->where_not_in($tableName . "." . $filterKey, $filterVal);
                } else {
                    foreach ($joinTableVar as $joinKey => $joinArray) {
                        if (isset($joinArray['tableName']) && ( $joinArray['tableName'] != "") && $CI->db->field_exists($filterKey, $joinArray['tableName'])) {
                            $CI->db->where_not_in($joinArray['tableName'] . "." . $filterKey, $filterVal);
                            break;
                        }
                    }
                }
            } else {
                $CI->db->where_not_in($filterKey, $filterVal);
            }
        }
    }
    foreach ($likeConditionArray as $filterKey => $filterVal) {
        if ($filterVal != "") {
            if (count($joinTableVar) > 0) {
                if ($CI->db->field_exists($filterKey, $tableName)) {
                    $CI->db->like($tableName . "." . $filterKey, $filterVal);
                } else {
                    foreach ($joinTableVar as $joinKey => $joinArray) {
                        if (isset($joinArray['tableName']) && ( $joinArray['tableName'] != "") && $CI->db->field_exists($filterKey, $joinArray['tableName'])) {
                            $CI->db->like($joinArray['tableName'] . "." . $filterKey, $filterVal);
                            break;
                        }
                    }
                }
            } else {
                $CI->db->like($filterKey, $filterVal);
            }
        }
    }
    /* Code for Pagination */
    $config['pgn'] = $orderingVar['pgn'];
    $config['ipp'] = $orderingVar['ipp'];
    $config['totalRows'] = $CI->db->count_all_results();
    if(isset($groupby) && !empty($groupby)){
    	$CI->db->group_by($groupby['field']);
    	if(isset($groupby['having']) && !empty($groupby['having'])){
    		$CI->db->having($groupby['having']);
    	}
    }
    $CI->db->order_by($orderingVar["sortBy"], $orderingVar["orderBy"]);
    $offset = $orderingVar['ipp'] * ($orderingVar['pgn'] - 1);
    $CI->db->limit($config['ipp'], $offset);
    $result = $CI->db->get()->result();
    //debug_var($CI->db->last_query());
    $CI->db->flush_cache();
    $CI->db->stop_cache();
    $CI->activepagination->setPaginationVariable($config);
    $CI->db->flush_cache();
    /* ends up here */
    return $result;
}

function is_date($str) {
    try {
        $dt = new DateTime(trim($str));
    } catch (Exception $e) {
        return false;
    }
    $month = $dt->format('m');
    $day = $dt->format('d');
    $year = $dt->format('Y');
    if (checkdate($month, $day, $year)) {
        return true;
    } else {
        return false;
    }
}

function str_rand($length = 8, $seeds = 'alphanum') {
    // Possible seeds
    $seedings['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
    $seedings['numeric'] = '0123456789';
    $seedings['alphanum'] = '-abcdefghijklmnopqrstuvwqyz-0123456789-';
    $seedings['hexidec'] = '0123456789abcdef';

    // Choose seed
    if (isset($seedings[$seeds])) {
        $seeds = $seedings[$seeds];
    }

    // Seed generator
    list($usec, $sec) = explode(' ', microtime());
    $seed = (float) $sec + ((float) $usec * 100000);
    mt_srand($seed);

    // Generate
    $str = '';
    $seeds_count = strlen($seeds);

    for ($i = 0; $length > $i; $i++) {
        $str .= $seeds{mt_rand(0, $seeds_count - 1)};
    }

    return strtoupper($str);
}
/**
* Method to authorise exess
*/
function authorize(){
    $ci =& get_instance();
    $id = $ci->session->userdata("uid");
    if($id == ""){
		$ci->session->set_flashdata("message","<div class='alert-error'>Please login first to access internal pages.</div>");
        redirect("users/login");
    }
}

function isAdminAuthorize(){
    $ci =& get_instance();
    $id = $ci->session->userdata("loggedInAdmin");
    if($id == ""){
		$ci->session->set_flashdata("message","<div class='alert-error'>Please login first to access internal pages.</div>");
        redirect("admin");
    }
}
/**
 * Method to get user details by Id
 */
    function get_user($id)
    {
	$ci =& get_instance();
	//$id = $ci->session->userdata("uid");
	$ci->db->select("*");
	$ci->db->where("id",$id,true);
	$res = $ci->db->get("users");
	    return $res->row();
	
    }

/** 
    *Method to get Footer Text for admin footer.
**/
    function get_adminFooter()
    {
	$ci =& get_instance();
	//$id = $ci->session->userdata("uid");
	$ci->db->select("adminFooterTxt");
	$ci->db->where("userRoleId",'1',true);
	$res = $ci->db->get("users");
	return $res->row();
    }
    
/** 
    *Method to get Footer Text for admin footer.
**/
    function saverecentfolder($id)
    {
	$ci =& get_instance();
	@$folderdetail=$ci->usermodel->getrecentfolders($id);
	if(@$folderdetail){
	    $saverecentdocArray=array(
		'title'	=>$folderdetail['folderName'],
		'doc_id'=>$id,
		'user_id'=>$ci->session->userdata('userid'),
	    );
	    return $qryresponse=$ci->usermodel->saverecentfolder($saverecentdocArray);
	}
	
    }
    
    /**
	* @ Function Name	: walk_dir_folder
	* @ Function Purpose 	: Veiw tree sturcture
	* @ Function Returns	: 
	*/
	
	function walk_dir_folder($parent_id,$levelStr,$clientid,$task){
		$ci =& get_instance();
    		global $options;
		//echo $parent_id;
		$query = "select * from folder_master where userId =$clientid and parentId = ". $parent_id;
		$flieRes = $ci->db->query($query);
		$fileList = $flieRes->result_array();
		//pre($fileList);
		//pre($fileList);
		if(!empty($fileList)){
			foreach($fileList as $eky=>$file){
			    if($task=='list')
			    {
				    //pre($fileList);
				    //$options=array();
				    /*if($levelStr == ""){
					$options[$eky]=$file;
					$options[$eky]['folderName']= $file['folderName'].'("Root Folder")';
				    }
				    else{
					$options[$eky]=$file;
					$options[$eky]['folderName']= $levelStr."|__".$file['folderName'];
				    }*/
				    
				     if($levelStr == ""){
					$options[$file['id']] = $file['folderName'].'("Root Folder")';
				    }
				    else{
					$options[$file['id']] = $levelStr."|__".$file['folderName'];    
				    }
				    
			    }else{
				    //pre($fileList);
				    if($levelStr == ""){
					$options .= "<option value=".$file['id'].">".$file['folderName'].'("Root Folder")'."</option>";
				    }
				    else{
					$options .= "<option value=".$file['id'].">".$levelStr."|__".$file['folderName']."</option>";    
				    }
				}	
				$levelStrs = $levelStr."&nbsp;&nbsp;&nbsp;&nbsp;";
				walk_dir_folder($file['id'],$levelStrs,$clientid,$task);	
			}
		}
		//pr($options);
		return $options ;
	}
    
    
    
    //$footerText = get_adminFooter();
    //pr($footerText);

/**
 * Convert number into word
 */

    function convertNumberToWordsForIndia($number){
        //A function to convert numbers into Indian readable words with Cores, Lakhs and Thousands.
        $words = array(
        '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five',
        '6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten',
        '11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen',
        '16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty',
        '30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy',
        '80' => 'eighty','90' => 'ninty');
       
        //First find the length of the number
        $number_length = strlen($number);
        //Initialize an empty array
        $number_array = array(0,0,0,0,0,0,0,0,0);       
        $received_number_array = array();
       
        //Store all received numbers into an array
        for($i=0;$i<$number_length;$i++){    $received_number_array[$i] = substr($number,$i,1);    }

        //Populate the empty array with the numbers received - most critical operation
        for($i=9-$number_length,$j=0;$i<9;$i++,$j++){ $number_array[$i] = $received_number_array[$j]; }
        $number_to_words_string = "";       
        //Finding out whether it is teen ? and then multiplying by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
        for($i=0,$j=1;$i<9;$i++,$j++){
            if($i==0 || $i==2 || $i==4 || $i==7){
                if($number_array[$i]=="1"){
                    $number_array[$j] = 10+$number_array[$j];
                    $number_array[$i] = 0;
                }       
            }
        }
       
        $value = "";
        for($i=0;$i<9;$i++){
            if($i==0 || $i==2 || $i==4 || $i==7){    $value = $number_array[$i]*10; }
            else{ $value = $number_array[$i];    }           
            if($value!=0){ $number_to_words_string.= $words["$value"]." "; }
            if($i==1 && $value!=0){    $number_to_words_string.= "Trillions "; }
            if($i==3 && $value!=0){    $number_to_words_string.= "Millions ";    }
            if($i==5 && $value!=0){    $number_to_words_string.= "Thousand "; }
            if($i==6 && $value!=0){    $number_to_words_string.= "Hundred &amp; "; }
        }
        if($number_length>9){ $number_to_words_string = "Sorry This does not support more than 99 Crores"; }
        return ucwords(strtolower($number_to_words_string));
    }
?>
