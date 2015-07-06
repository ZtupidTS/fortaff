<?php 
session_start();
require_once '../funcao/funcao_formulario.php';
$local = control_post($_POST['local']);
$nome_juiz = control_post($_POST['nome_juiz']);

#variaveis para voltar a preencher o formulario
$_SESSION['lugares_total'] = $_POST['lugares_total'];
$_SESSION['preco'] = $_POST['preco'];
$_SESSION['prova_nome_juiz'] = $nome_juiz;
$_SESSION['prova_local'] = $local;
$_SESSION['dia'] = $_POST['dia'];
$_SESSION['mes'] = $_POST['mes'];
$_SESSION['ano'] = $_POST['ano'];
include '../includes/test_intruso_co.php';
if($_POST['local'] == "" || $_POST['nome_juiz'] == "" || $_POST['preco'] == "" || $_POST['lugares_total'] == "")
{
	$_SESSION["mensagem"] = 'Tem de preencher todos os campos';
	header('Location: acrescentar_prova_co.php');
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
		$preco = arredondar_preco($_SESSION['preco']);
		include '../includes/ligacao.php';
		mysql_query("INSERT INTO prova (cod_modalidade, local, data, hora_inicio, duracao, nome_juiz, preco, lugares_total, estado_valido, sexo) VALUES ('$_POST[cod_modalidade]', '$_SESSION[prova_local]', '$data', '$hora_inicio', '$duracao', '$_SESSION[prova_nome_juiz]', '$preco', '$_SESSION[lugares_total]', 'V', '$_POST[sexo]')");
		if (mysql_affected_rows() > 0)
		{
			$_SESSION["mensagem"] = 'Inserção da prova com sucesso';
			mysql_close($conexao);
			header('Location: acrescentar_prova_co.php');
		}else{
			$_SESSION["mensagem"] = 'Inserção da prova sem sucesso';
			mysql_close($conexao);
			header('Location: acrescentar_prova_co.php');
		}	
	}
}?>
