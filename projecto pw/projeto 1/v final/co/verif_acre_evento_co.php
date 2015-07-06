<?php 
session_start();
include '../includes/test_intruso_co.php';
include '../includes/ligacao.php';
require_once '../funcao/funcao_formulario.php';
$designacao = control_post($_POST['designacao']);
$descricao = control_post($_POST['descricao']);

#variaveis para voltar a preencher o formulario
$_SESSION['lugares_total'] = $_POST['lugares_total'];
$_SESSION['preco'] = $_POST['preco'];
$_SESSION['designacao'] = $designacao;
$_SESSION['descricao'] = $descricao;
$_SESSION['dia'] = $_POST['dia'];
$_SESSION['mes'] = $_POST['mes'];
$_SESSION['ano'] = $_POST['ano'];


if($_POST['designacao'] == "" || $_POST['descricao'] == "" || $_POST['preco'] == "" || $_POST['lugares_total'] == "")
{
	$_SESSION["mensagem"] = 'Tem de preencher todos os campos';
	mysql_close($conexao);
	header('Location: acrescentar_evento_co.php');
}else{
	if(!(is_numeric($_SESSION['preco'])))
	{
		$_SESSION["erro_preco"] = true;
		mysql_close($conexao);
		header('Location: acrescentar_evento_co.php');
	}else{
		$_SESSION["erro_preco"] = false;
		require_once '../funcao/funcao_formulario.php';
		$data = concatenar_data($_POST['ano'], $_POST['mes'], $_POST['dia']);
		$hora_inicio = concatenar_hora($_POST['hora_inicio'], $_POST['minutos_inicio']);
		$duracao = concatenar_hora($_POST['duracao_hora'], $_POST['duracao_minutos']);	
		$preco = arredondar_preco($_SESSION['preco']);
		mysql_query("INSERT INTO evento (designacao, descricao, data, hora, duracao_estimada, preco, lugares_total, lugares_reservados, estado_valido) VALUES ('$designacao', '$descricao', '$data', '$hora_inicio', '$duracao', '$preco', '$_SESSION[lugares_total]', 0, 'V')");
		if (mysql_affected_rows() > 0)
		{
			$_SESSION["mensagem"] = 'Inserção do evento com sucesso';
			mysql_close($conexao);
			header('Location: acrescentar_evento_co.php');
		}else{
			$_SESSION["mensagem"] = 'Inserção do evento sem sucesso';
			mysql_close($conexao);
			header('Location: acrescentar_evento_co.php');
		}	
	}
}?>
