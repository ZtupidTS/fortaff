<?php 
session_start();
include '../includes/test_intruso_co.php';
include '../includes/ligacao.php';

$equipa = mysql_query("SELECT * FROM equipa WHERE cod_equipa='$_POST[cod_equipa]'");
$dados = mysql_fetch_array($equipa);
#verifica se foi acrescentar
if($dados['estado_valido'] == 'A')
{
	mysql_query("UPDATE equipa SET estado_valido = 'X' WHERE cod_equipa = '$dados[cod_equipa]'");
	mysql_query("UPDATE elemento_in_equipa SET estado_valido = 'X' WHERE cod_equipa = '$dados[cod_equipa]'");
	$elemento = mysql_query("SELECT * FROM elemento_in_equipa WHERE cod_equipa = '$dados[cod_equipa]' and estado_valido = 'X'");
	while($dados_elemento = mysql_fetch_array($elemento))
	{
		mysql_query("UPDATE elemento_equipa SET old_nome = NULL, old_data_nasc = NULL, old_sexo = NULL WHERE cod_elemento_equipa = '$dados_elemento[cod_elemento_equipa]'");
		$sera_atleta = mysql_query("SELECT * FROM atleta WHERE cod_elemento_equipa = '$dados_elemento[cod_elemento_equipa]'");
		if(mysql_num_rows($sera_atleta) > 0)
		{
			mysql_query("UPDATE atleta SET old_peso = NULL, old_altura = NULL, old_grupo_sanguineo = NULL WHERE cod_elemento_equipa = '$dados_elemento[cod_elemento_equipa]'");
		}else{
			mysql_query("UPDATE auxiliar SET old_funcao = NULL, old_habilit = NULL WHERE cod_elemento_equipa = '$dados_elemento[cod_elemento_equipa]'");
		}
	}	
	mysql_close($conexao);
	header('Location: equipas_co.php');
}
#verifica se foi modificar
if($dados['estado_valido'] == 'M')
{
	#aqui verificou se ao cancelar a alteraчуo da modalidade se jс existe uma equipa dessa delegaчуo com essa modalidade, caso sim "elimina" a equipa
	$equipa = mysql_query("SELECT * FROM equipa WHERE cod_delegacao = '$dados[cod_delegacao]' and '$dados[ref_cod_modalidade]' = cod_modalidade");
	if(mysql_num_rows($equipa) > 0)
	{
		mysql_query("UPDATE equipa SET estado_valido = 'X', ref_cod_modalidade = NULL WHERE cod_equipa = '$dados[cod_equipa]'");
		mysql_query("UPDATE elemento_in_equipa SET estado_valido = 'X' WHERE cod_equipa = '$dados[cod_equipa]'");
		mysql_close($conexao);
		header('Location: equipas_co.php');
	}else{
		mysql_query("UPDATE equipa SET estado_valido = 'V', cod_modalidade = ref_cod_modalidade, ref_cod_modalidade = NULL WHERE cod_equipa='$_POST[cod_equipa]'");
		mysql_close($conexao);
		header('Location: equipas_co.php');
	}
}
#test se foi alterar
if($dados['estado_valido'] == 'D')
{
	mysql_query("UPDATE equipa SET estado_valido = 'V', ref_cod_modalidade = NULL WHERE cod_equipa = '$dados[cod_equipa]'");
	mysql_close($conexao);
	header('Location: equipas_co.php');
}
?>