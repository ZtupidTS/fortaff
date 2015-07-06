<?php 
session_start();
include '../includes/ligacao.php';
require_once '../funcao/funcao_formulario.php';
$email = control_post($_POST['email']);

if($email == "")
{
	mysql_close($conexao);
	$_SESSION["mensagem"] = 'Tem de preencher o campo do E-mail';
	header('Location: recup_password.php');
}else{
	$mail_existe = mysql_query("SELECT * FROM visitante where email='$email'");
	if(mysql_num_rows($mail_existe) > 0)
	{
		$dados = mysql_fetch_array($mail_existe);
		#gera nova password
		require_once '../funcao/funcao_formulario.php';
		$mail = enviamail($email,$dados['login'],$dados['password']);
		header('Location: registo_ok.php');
	}else{
		mysql_close($conexao);
		$_SESSION["mensagem"] = 'Esse email não existe na base dados';
		header('Location: recup_password.php');
	}
}
?>