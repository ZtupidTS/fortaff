<?php 
session_start();
include '../includes/test_intruso_co.php';
include '../includes/ligacao.php';
require_once '../funcao/funcao_formulario.php';
$login = control_post($_POST['login']);
$nome_responsavel = control_post($_POST['nome_responsavel']);
$email = control_post($_POST['email']);
include '../includes/gerirpassword_co.php';

$igualdade = true;
$login_igual = mysql_query("SELECT * FROM delegacao WHERE login = '$login' and cod_delegacao != '$_SESSION[delegacao_a_alterar]' and estado_valido != 'X'");
if(mysql_num_rows($login_igual) > 0)
{
	mysql_close($conexao);
	$igualdade = false;
	$_SESSION["mensagem"] = 'Já existe um login igual';
	header('Location: altera_delegacao_co.php');
}
$mail_igual = mysql_query("SELECT * FROM delegacao WHERE email = '$email' and cod_delegacao != '$_SESSION[delegacao_a_alterar]' and estado_valido != 'X'");
if(mysql_num_rows($mail_igual) > 0)
{
	mysql_close($conexao);
	$igualdade = false;
	$_SESSION["mensagem"] = 'Email já existente';
	header('Location: altera_delegacao_co.php');
}
if($igualdade)
{
	require_once '../funcao/funcao_formulario.php';
	$mail = enviamail($email,$login,$password);
	if($mail)
	{
		mysql_close($conexao);
		$_SESSION["mensagem"] = 'Verifica o email introduzido (ex: meumail@mail.com)';
		header('Location: altera_delegacao_co.php');
	}else{
		mysql_query("UPDATE delegacao SET nome_responsavel='$nome_responsavel', login='$login', password='$password', estado_valido = 'V', email = '$email' WHERE cod_delegacao='$_SESSION[delegacao_a_alterar]' and estado_valido != 'X'"); 
		mysql_close($conexao);
		$_SESSION["mensagem"] = 'Delegação alterada com sucesso\nEmail enviado com sucesso';
		header('Location: altera_delegacao_co.php');
	}
}
?>
