<?php
include '../includes/allpage.php';

$iduser = control_post($_POST['iduser']);

$_SESSION['iduser'] = $iduser;       
$user = loginGet($iduser);


if($user['password'] == $_POST['password'])
{
	$_SESSION['username'] = $user['name'];
	//$_SESSION['expire'] = time() + (15 * 60);
	$_SESSION['expire'] = 15*60*60;//15minute, 3h = 3*60*60
	$_SESSION['last_activity'] = time();
	echo 'ok';	
}else{
	echo 'Verificar password';
}

closeDataBase();
?>

