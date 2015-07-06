<?php 
session_start();
include '../includes/test_intruso_co.php';
include '../includes/ligacao.php';
require_once '../funcao/funcao_formulario.php';
$login = control_post($_POST['login']);
$nome_responsavel = control_post($_POST['nome_responsavel']);
$password = control_post($_POST['password']);
$email = control_post($_POST['email']);
#$password2 = control_post($_POST['password2']);


if($_POST['nome_responsavel'] == "" || $_POST['login'] == "" || $_POST['email'] == "")
{
	mysql_close($conexao);
	$_SESSION["mensagem"] = 'Tem de preencher todos os campos';
	header('Location: acrescentar_delegacao_co.php');
}else{
	#teste se login já existe numa delegacao valida
	$erro = true;
	$repeticao_login = mysql_query("SELECT * FROM delegacao where login='$login' and estado_valido != 'X'");
	if(mysql_num_rows($repeticao_login) > 0)
	{
		mysql_close($conexao);
		$erro = false;
		$_SESSION["mensagem"] = 'login já existente, escolha novamente o seu login';
		header('Location: acrescentar_delegacao_co.php');
	}
	$repeticao_mail = mysql_query("SELECT * FROM delegacao where email='$email' and estado_valido != 'X'");
	if(mysql_num_rows($repeticao_mail) > 0)
	{
		mysql_close($conexao);
		$erro = false;
		$_SESSION["mensagem"] = 'Email já existente, verifica o email introduzido';
		header('Location: acrescentar_delegacao_co.php');
	}
	if($erro)
	{
		$prefix_pais = mysql_query("SELECT * FROM pais WHERE nome_pais ='$_POST[nome_pais]'");
		$dados = mysql_fetch_array($prefix_pais);
		require_once '../funcao/funcao_formulario.php';
		$mail = enviamail($email,$login,$password);
		if($mail)
		{
			mysql_close($conexao);
			$_SESSION["mensagem"] = 'Delegação não inserida\nVerifica o email introduzido (ex: meumail@mail.com)';
			header('Location: acrescentar_delegacao_co.php');
		}else{
			mysql_query ("INSERT INTO delegacao (cod_delegacao, nome_pais, nome_responsavel, login, password, estado_valido, email) VALUES ('$dados[prefix_pais]',  '$_POST[nome_pais]',  '$nome_responsavel',  '$login',  '$password', 'V', '$email')");
			mysql_close($conexao);
			$_SESSION["mensagem"] = 'Delegação inserida com êxito\nEmail enviado com sucesso';
			header('Location: acrescentar_delegacao_co.php');
		}
	}
}
?>
