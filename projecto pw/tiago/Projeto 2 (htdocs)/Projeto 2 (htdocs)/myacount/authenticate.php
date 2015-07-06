<?php
	require_once '../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
?>
<?php
	$user = $_POST["user"];
	$password = $_POST["password"];
	$post = array();
	
	$success = vsCheckLogin($user, $password);
	
	if ($success){
		$_SESSION['login_vs'] = visitanteGetByEmail($user);	
	} else {
		$post['err'] = 1;
		$post['user'] = $user;
		$_SESSION['_POST'] = $post;
	}
	header("location: /pw606/public/index.php");
	exit();
?>
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>