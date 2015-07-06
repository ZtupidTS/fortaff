<?php
session_start();
include '../includes/ligacao.php';
require_once '../funcao/funcao_formulario.php';
$login = control_post($_POST['login']);

$db_verify = mysql_query("SELECT * FROM delegacao WHERE login = '$login' and estado_valido != 'X'");
if(mysql_num_rows($db_verify) < 1)
{
	$_SESSION['mensagem'] = 'Login e/ou palavra passe errado';
	header('Location: area_reservada.php');	
}else{
	while($dados = mysql_fetch_array($db_verify))
	{
		if($dados['login'] == $login && $dados['password'] == $_POST['password'])
		{
			if($dados['cod_delegacao'] == 'co')
			{
				$_SESSION["login_utilizador"] = $dados["login"];
				$_SESSION["cod_delegacao_utilizador"] = $dados['cod_delegacao'];
				$_SESSION["password_utilizador"] = $dados['password'];
				$_SESSION['nome_utilizador'] = $dados['nome_responsavel'];
				$_SESSION['ultimo_acesso'] = $dados['ultimo_acesso'];
				header('Location: ../co/area_gestao_co.php');
			}else{
				$_SESSION["login_utilizador"] = $dados["login"];
				$_SESSION["nome_responsavel"] = $dados["nome_responsavel"];
				$_SESSION["cod_delegacao_utilizador"] = $dados['cod_delegacao'];
				$_SESSION["password_utilizador"] = $dados['password'];
				$_SESSION["nome_pais"] = $dados['nome_pais'];
				$_SESSION['ultimo_acesso'] = $dados['ultimo_acesso'];
				header('Location: ../rd/area_gestao_rd.php');
			}//faz o test de co ou rd e redirecciona para as paginas corectas
		}else{
			$_SESSION['mensagem'] = 'Login e/ou palavra passe errado';
			header('Location: area_reservada.php');
		}//se login ou password errado volta a pagina area_reservada
	}//fim do while
}
mysql_close($conexao);	
?>