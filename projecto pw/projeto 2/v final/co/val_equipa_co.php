<?php 
session_start();
include '../includes/test_intruso_co.php';
include '../includes/ligacao.php';

$equipa = mysql_query("SELECT * FROM equipa WHERE cod_equipa='$_POST[cod_equipa]'");
$dados = mysql_fetch_array($equipa);
#verifica se foi alterar ou acrescentar
if($dados['estado_valido'] == 'A')
{
	mysql_query("UPDATE equipa SET estado_valido = 'V', ref_cod_modalidade = NULL WHERE cod_equipa='$_POST[cod_equipa]'");
	mysql_close($conexao);
	header('Location: equipas_co.php');	
}
#verifica se foi eliminar
if($dados['estado_valido'] == 'D')
{
	$cod_prova = mysql_query("SELECT * FROM eq_acrescentado_a_prova WHERE cod_modalidade = '$_POST[cod_modalidade]' and cod_equipa = '$_POST[cod_equipa]'");
	$dados = mysql_fetch_array($cod_prova);
	mysql_query("UPDATE classificacao_prova SET estado_valido_classificado = 'X' WHERE cod_prova = '$dados[cod_prova]' and cod_do_classificado = '$_POST[cod_equipa]'");
	mysql_query("UPDATE equipa SET estado_valido = 'X' WHERE cod_equipa='$_POST[cod_equipa]'");
	mysql_query("UPDATE elemento_in_equipa SET estado_valido = 'X' WHERE cod_equipa='$_POST[cod_equipa]'");
	mysql_close($conexao);
	header('Location: equipas_co.php');
}
#verifica se alterou
if($dados['estado_valido'] == 'M')
{
	$modalidade = mysql_query("SELECT * FROM equipa WHERE cod_equipa = '$_POST[cod_equipa]'");
	$dados_modalidade = mysql_fetch_array($modalidade);
	$tipo = mysql_query("SELECT * FROM tipo_prova WHERE cod_modalidade = '$dados_modalidade[ref_cod_modalidade]'");
	$dados_tipo = mysql_fetch_array($tipo);
	$cod_prova = $dados_tipo['cod_prova'];
	if($dados_tipo['tipo'] == 'I')
	{
		$elemento = mysql_query("SELECT * FROM elemento_in_equipa WHERE cod_equipa = '$_POST[cod_equipa]' and estado_valido != 'X'");
		while($dados_elemento = mysql_fetch_array($elemento))
		{
			mysql_query("UPDATE classificacao_prova SET estado_valido_classificado = 'X' WHERE cod_prova = $cod_prova and cod_do_classificado = $dados_elemento[cod_elemento_equipa]");
		}
	}else{
		mysql_query("UPDATE classificacao_prova SET estado_valido_classificado = 'X' WHERE cod_prova = $cod_prova and cod_do_classificado = '$_POST[cod_equipa]'");
	}
	mysql_query("UPDATE equipa SET estado_valido = 'V', ref_cod_modalidade = NULL WHERE cod_equipa='$_POST[cod_equipa]'");
	mysql_close($conexao);
	header('Location: equipas_co.php');
}
?>
