<?php 
session_start();
include '../includes/test_intruso_rd.php';
include '../includes/ligacao.php';
require_once '../funcao/funcao_formulario.php';
$nome = control_post($_POST['nome']);

if($_POST['nome'] == "")
{
	mysql_close($conexao);
	$_SESSION["mensagem"] = 'Tem de preencher o campo do nome do atleta';
	header('Location: alt_atleta_rd.php');
}else{
	$data_nasc = $_POST['ano'].'-'.$_POST['mes'].'-'.$_POST['dia'];
	mysql_query("UPDATE elemento_equipa SET old_nome = nome, old_data_nasc = data_nasc, old_sexo = sexo, nome = '$nome', data_nasc = '$data_nasc', sexo = '$_POST[sexo]' WHERE cod_elemento_equipa = '$_POST[cod_elemento_equipa]'");
	$query1 = mysql_affected_rows();
	mysql_query("UPDATE atleta SET old_peso = peso, old_altura = altura, old_grupo_sanguineo = grupo_sanguineo, peso = '$_POST[peso]', altura = '$_POST[altura]', grupo_sanguineo = '$_POST[grupo_sanguineo]' WHERE cod_elemento_equipa = '$_POST[cod_elemento_equipa]'");
	$query2 = mysql_affected_rows();
	mysql_query("UPDATE elemento_in_equipa SET estado_valido = 'M' WHERE cod_equipa = '$_SESSION[cod_equipa]' and cod_elemento_equipa = '$_POST[cod_elemento_equipa]'");
	if (($query1 + $query2) > 0)
	{
		$_SESSION["mensagem"] = 'Alteraчуo do atleta com sucesso';
		mysql_close($conexao);
		header('Location: alt_atleta_rd.php');
	}else{
		$_SESSION["mensagem"] = 'Alteraчуo do atleta sem sucesso';
		mysql_close($conexao);
		header('Location: alt_atleta_rd.php');
	}
}	
?>