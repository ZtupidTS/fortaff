<?php 
session_start();
include '../includes/ligacao.php';
require_once '../funcao/funcao_formulario.php';
$email = control_post($_POST['email']);

if($email == "")
{
	mysql_close($conexao);
	$_SESSION["mensagem"] = 'Tem de preencher o campo do E-mail';
	header('Location: recuperar_password.php');
}else{
	$mail_existe = mysql_query("SELECT * FROM delegacao where email='$email' and estado_valido != 'X'");
	if(mysql_num_rows($mail_existe) > 0)
	{
		$dados = mysql_fetch_array($mail_existe);
		#gera nova password
		include '../includes/gerirpassword_co.php';
		$login = $dados['login'];
		require_once '../funcao/funcao_formulario.php';
		$mail = enviamail($email,$login,$password);
		if($mail)
		{
			mysql_close($conexao);
			$_SESSION["mensagem"] = 'Email não enviado, volta a tentar';
			header('Location: recuperar_password.php');
		}else{
			mysql_query("UPDATE delegacao SET password = '$password' WHERE email='$email' and estado_valido != 'X'");
			mysql_close($conexao);
			$_SESSION["mensagem"] = 'Email enviado com sucesso';
			header('Location: recuperar_password.php');
		}
	}else{
		mysql_close($conexao);
		$_SESSION["mensagem"] = 'Esse email não existe na base dados';
		header('Location: recuperar_password.php');
	}
}
?>
