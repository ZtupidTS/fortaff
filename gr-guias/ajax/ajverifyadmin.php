<?php
include '../includes/allpageaj.php';

$data = getLoginAdmin(dbString($_POST['pass']));

//echo mysql_num_rows($data);

if(mysql_num_rows($data) > 0)
{
	$_SESSION['username'] = "Admin";
	$_SESSION['iduser'] = 9;
	echo 'ok';	
}else{
	echo 'nok';
}


closeDataBase();

?>