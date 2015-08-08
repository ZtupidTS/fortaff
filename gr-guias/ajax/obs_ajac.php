<?php
include '../includes/allpageaj.php';

//$_GET['name_startsWith']
//echo $_POST['valor'];

$where = "";
$db_column = $_GET['type'];
$orderby = $db_column;

switch ($_GET['type']) {
  case "id":
    $where .= $_GET['type'] . " = " . $_GET['write_search'];
    break;
  case "art_type":
    $where .= $_GET['type'] . " LIKE " .  dbString("%" . $_GET['write_search'] . "%");
    break;  
  case "art_marca":
    $where .= $_GET['type'] . " LIKE " .  dbString("%" . $_GET['write_search'] . "%");
    break;  
  case "cl_name":
    $where .= $_GET['type'] . " LIKE " .  dbString("%" . $_GET['write_search'] . "%");
    break;
  case "cl_telefone":
    $where .= $_GET['type'] . " LIKE " .  dbString("%" . $_GET['write_search'] . "%");
    break;
    /*if(is_numeric($_GET['write_search']) && strlen($_GET['write_search']) > 8)
    {
        $where .= $_GET['type'] . " = " . dbInteger($_GET['write_search']);
    }else{
        $where .= $_GET['type'] . " = 999999999";
    }
    break;*/
  case "status_sms":
  	switch(strtoupper($_GET['write_search'])){
	  	case "E":
	  		$where .= $_GET['type'] . " = 1";
	  		break;
	  	case "P":
	  		$where .= $_GET['type'] . " = 2";
	  		break;
	  	case "N":
	  		$where .= $_GET['type'] . " = 3";
	  		break;
	  }
    break;
}

$where .= " AND gr_enable = 1";

$result = grepGetByDistinct($where, $db_column);



//$result = executeReader("SELECT cl_name from grep where cl_name LIKE " . dbString("%" . $_GET['write_search'] . "%") . "GROUP BY cl_name");
//print_r($result);

//$result = mysql_fetch_array($result);

//echo $result;
//print_r($result);
$array = array();
while($data = mysql_fetch_array($result))
{
	array_push($array, $data[$db_column]);
}
//print_r($array);
echo json_encode($array);
closeDataBase();
?>