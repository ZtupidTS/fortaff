<?php
	require_once '../includes/utils.php';
	include_once rootPath('includes/html_header.php', 1);
	include_once rootPath('includes/master_header.php', 1);
?>
<?php

	$user = $_POST["user"];
	$password = $_POST["password"];
	$post = array();
	
	$login = rdCheckLogin($user, $password);
	
	if ($login){
		$_SESSION['login'] = delegacaoGetByUser($user);
		header("location: delegacoes/index.php");		
	} else {
		$post['err'] = 1;
		$post['user'] = $user;
		$_SESSION['_POST'] = $post;
		header("location: index.php");
	}
?>
<?php
	include_once rootPath('includes/master_footer.php', 1);
?>