<?php
include '../includes/allpageaj.php';

$iduser = control_post($_GET['iduser']);
$login = control_post($_GET['login']);
$password = control_post($_GET['password']);

//ver se existe esse users
$table = usersGetByFiltro('pp_us_id = '.dbInteger($iduser).' AND pp_us_password = '.dbString($password), "pp_us_id");

//echo $iduser.' '.$login.' '.$password;

if(mysql_num_rows($table) > 0)
{
	$_SESSION['iduser'] = $iduser;  
	$_SESSION['username'] = $login;
	$_SESSION['expire'] = 15*60*60;//15minute, 3h = 3*60*60
	$_SESSION['last_activity'] = time();
	echo 'ok';
}else{
	echo 'Verifica a palavra passe';
}

closeDataBase();
?>

