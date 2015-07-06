<?php
include '../includes/allpage.php';

$data = getLoginAdmin(dbString($_POST['pass']));

if(count($data) > 0)
{
	$_SESSION['username'] = "Admin";
	$_SESSION['iduser'] = 2;
	echo 'ok';	
}else{
	echo 'nok';
}


closeDataBase();

?>