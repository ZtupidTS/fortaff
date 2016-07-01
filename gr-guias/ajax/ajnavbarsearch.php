<?php
include '../includes/allpageaj.php';


$return = grepGetByGrNumber(dbInteger($_POST['gr']));

if($return)
{
	//print_r($return); 
	echo $return['id'];
}else{
	echo 'nok';
}

closeDataBase();
?>