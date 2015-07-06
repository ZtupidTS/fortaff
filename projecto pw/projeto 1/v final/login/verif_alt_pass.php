<?php 
session_start();
include '../includes/ligacao.php';
require_once '../funcao/funcao_formulario.php';
$old_password = control_post($_POST['old_password']);
$login = control_post($_POST['login']);
$password = control_post($_POST['password']);
$password2 = control_post($_POST['password2']);

$test = true;
if($old_password == "" || $login == "" || $password == "" || $password2 == "")
{
	mysql_close($conexao);
	$test = false;
	$_SESSION["mensagem"] = 'Tem de preencher todos os campos';
	header('Location: alterar_password.php');
}
if($password != $password2)
{
	mysql_close($conexao);
	$test = false;
	$_SESSION["mensagem"] = 'As password tem de coincidir';
	header('Location: alterar_password.php');
}
if($test)
{
	$existe = mysql_query("SELECT * FROM delegacao where login='$login' and password = '$old_password' and estado_valido != 'X'");
	if(mysql_num_rows($existe) > 0)
	{
		$dados = mysql_fetch_array($existe);
		require_once '../funcao/funcao_formulario.php';
		$email = $dados['email'];
		$mail = enviamail($email,$login,$password);
		if($mail)
		{
			mysql_close($conexao);
			$_SESSION["mensagem"] = 'Email não enviado sucesso, volta a tentar';
			header('Location: alterar_password.php');
		}else{
			mysql_query("UPDATE delegacao SET password = '$password' WHERE login='$login' and password = '$old_password' and estado_valido != 'X'");
			mysql_close($conexao);
			$_SESSION["mensagem"] = 'Email enviado com sucesso';
			header('Location: alterar_password.php');
		}
	}else{
		mysql_close($conexao);
		$_SESSION["mensagem"] = 'Esse login e/ou E-mail passe não existe';
		header('Location: alterar_password.php');
	}
}
?>
