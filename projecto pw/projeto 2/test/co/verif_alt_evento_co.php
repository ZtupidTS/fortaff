<?php 
session_start();
include '../includes/test_intruso_co.php';
include '../includes/ligacao.php';
require_once '../funcao/funcao_formulario.php';
$descricao = control_post($_POST['descricao']);
$designacao = control_post($_POST['designacao']);

if($_POST['designacao'] == "" || $_POST['descricao'] == "" || $_POST['preco'] == "" || $_POST['lugares_total'] == "")
{
	mysql_close($conexao);
	$_SESSION["mensagem"] = 'Tem de preencher todos os campos';
	header('Location: altera_evento_co.php');
}else{
	if(!(is_numeric($_SESSION['preco'])))
	{
		$_SESSION["erro_preco"] = true;
		header('Location: acrescentar_prova_co.php');
	}else{
		$_SESSION["erro_preco"] = false;
		require_once '../funcao/funcao_formulario.php';
		$data = concatenar_data($_POST['ano'], $_POST['mes'], $_POST['dia']);
		$hora_inicio = concatenar_hora($_POST['hora_inicio'], $_POST['minutos_inicio']);
		$duracao = concatenar_hora($_POST['duracao_hora'], $_POST['duracao_minutos']);	
		$preco = arredondar_preco($_POST['preco']);
		mysql_query("UPDATE evento SET designacao='$designacao', descricao='$descricao', data='$data', hora_inicio = '$hora_inicio', duracao = '$duracao', preco = '$preco', lugares_total = '$_POST[lugares_total]' WHERE cod_evento='$_SESSION[evento_a_alterar]'"); 
		if(mysql_affected_rows() > 0)
		{
			mysql_close($conexao);
			$_SESSION["mensagem"] = 'Evento alterado com sucesso';
			header('Location: altera_evento_co.php');
		}else{
			mysql_close($conexao);
			$_SESSION["mensagem"] = 'Evento não alterada';
			header('Location: altera_evento_co.php');
		}
	}
}
?>