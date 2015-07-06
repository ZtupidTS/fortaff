<?php
session_start();
include '../includes/ligacao.php';

if(isset($_POST['login']) && isset($_POST['password']))
{
	require_once '../funcao/funcao_formulario.php';
	$login = control_post($_POST['login']);
	$psw = control_post($_POST['password']);
	
	$db = mysql_query("SELECT * FROM visitante WHERE login = '$login' and password = '$psw'");
	if(mysql_num_rows($db) < 1)
	{
		$_SESSION['mensagem'] = 'Login e/ou palavra passe errado';
		header('Location: login.php');
	}else{
		$dados = mysql_fetch_array($db);
		$_SESSION['nome_vis'] = $dados['nome'];
		$_SESSION['email_vis'] = $dados['email'];
		$_SESSION['apelido_vis'] = $dados['apelido'];
		$_SESSION['nif_vis'] = $dados['nif'];
		$_SESSION['morada_vis'] = $dados['morada'];
		$_SESSION['telemovel_vis'] = $dados['telemovel'];
		$_SESSION['login_vis'] = $dados['login'];
		$_SESSION['ult_acesso'] = $dados['ult_acesso'];
		$_SESSION['id_vis'] = $dados['id_visitante'];
		header('Location: perfil.php');
	}
}

?>