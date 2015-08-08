<?php
include '../includes/allpageaj.php';

$iduser = control_post($_POST['iduser']);

$_SESSION['iduser'] = $iduser;       
$user = loginGet($iduser);

$_SESSION['username'] = $user['us_name'];
//$_SESSION['expire'] = time() + (15 * 60);
$_SESSION['expire'] = 15*60*60;//15minute, 3h = 3*60*60
$_SESSION['last_activity'] = time();
echo 'ok';

closeDataBase();
?>

