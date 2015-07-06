<?php 
session_start();
include '../includes/test_intruso_co.php';
include '../includes/ligacao.php';
require_once '../funcao/funcao_formulario.php';
$local = control_post($_POST['local']);
$nome_juiz = control_post($_POST['nome_juiz']);

if($_POST['local'] == "" || $_POST['nome_juiz'] == "" || $_POST['preco'] == "" || $_POST['lugares_total'] == "")
{
	mysql_close($conexao);
	$_SESSION["mensagem"] = 'Tem de preencher todos os campos';
	header('Location: altera_prova_co.php');
}else{
	if(!(is_numeric($_POST['preco'])))
	{
		$_SESSION["erro_preco"] = true;
		header('Location: altera_prova_co.php');
	}else{
		$_SESSION["erro_preco"] = false;
		require_once '../funcao/funcao_formulario.php';
		$data = concatenar_data($_POST['ano'], $_POST['mes'], $_POST['dia']);
		$hora_inicio = concatenar_hora($_POST['hora_inicio'], $_POST['minutos_inicio']);
		$duracao = concatenar_hora($_POST['duracao_hora'], $_POST['duracao_minutos']);	
		$preco = arredondar_preco($_POST['preco']);
		mysql_query("UPDATE prova SET cod_modalidade='$_POST[cod_modalidade]', local='$local', data='$data', hora_inicio = '$hora_inicio', duracao = '$duracao', nome_juiz = '$nome_juiz', preco = '$preco', lugares_total = '$_POST[lugares_total]' WHERE cod_prova='$_SESSION[prova_a_alterar]'"); 
		if(mysql_affected_rows() > 0)
		{
			mysql_close($conexao);
			$_SESSION["mensagem"] = 'Prova alterada com sucesso';
			header('Location: altera_prova_co.php');
		}else{
			mysql_close($conexao);
			$_SESSION["mensagem"] = 'Prova não alterada';
			header('Location: altera_prova_co.php');
		}
	}
}
?>