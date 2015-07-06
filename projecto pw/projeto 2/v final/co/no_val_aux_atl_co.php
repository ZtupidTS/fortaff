<?php 
session_start();
include '../includes/test_intruso_co.php';
include '../includes/ligacao.php';

$el_equipa = mysql_query("SELECT * FROM elemento_in_equipa WHERE cod_elemento_equipa ='$_POST[cod_elemento_equipa]' and cod_equipa = '$_POST[cod_equipa]'");
$dados = mysql_fetch_array($el_equipa);
#recupera a url da pagina anterior e vou usar isso tambem para as query do mysql
$path_part = pathinfo($_SERVER['HTTP_REFERER']);
#se o url da pagina anterior contem atle a minha variavel fica com atleta senão com auxiliar
if(strpos($path_part['basename'], 'atleta') === false)
{
	$atle_ou_aux = 'auxiliar';
}else{
	$atle_ou_aux = 'atleta';
}
#se não validar as alterações volta a por as antigas
if($dados['estado_valido'] == 'A')
{
	mysql_query("UPDATE elemento_in_equipa SET estado_valido = 'X' WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]' and cod_equipa = '$_POST[cod_equipa]'");
	mysql_query("UPDATE elemento_equipa SET old_nome = NULL, old_data_nasc = NULL, old_sexo = NULL WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]'");
	if($atle_ou_aux == 'atleta')
	{
		mysql_query("UPDATE $atle_ou_aux SET old_peso = NULL, old_altura = NULL, old_grupo_sanguineo = NULL WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]'");
	}else{
		mysql_query("UPDATE $atle_ou_aux SET old_funcao = NULL, old_habilit = NULL WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]'");
	}
	mysql_close($conexao);
	header('Location:  '.$path_part['basename']);
}
#se não validar o eliminar
if($dados['estado_valido'] == 'D')
{
	mysql_query("UPDATE elemento_in_equipa SET estado_valido = 'V' WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]' and cod_equipa = '$_POST[cod_equipa]'");
	mysql_query("UPDATE elemento_equipa old_nome = NULL, old_data_nasc = NULL, old_sexo = NULL WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]'");
	if($atle_ou_aux == 'atleta')
	{
		mysql_query("UPDATE $atle_ou_aux SET old_peso = NULL, old_altura = NULL, old_grupo_sanguineo = NULL WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]'");
	}else{
		mysql_query("UPDATE $atle_ou_aux SET old_funcao = NULL, old_habilit = NULL WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]'");
	}
	mysql_close($conexao);
	header('Location:  '.$path_part['basename']);
}
#para não validar as alterações
if($dados['estado_valido'] == 'M')
{
	mysql_query("UPDATE elemento_in_equipa SET estado_valido = 'V' WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]' and cod_equipa = '$_POST[cod_equipa]'");
	mysql_query("UPDATE elemento_equipa SET nome = old_nome, data_nasc = old_data_nasc, sexo = old_sexo, old_nome = NULL, old_data_nasc = NULL, old_sexo = NULL WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]'");
	if($atle_ou_aux == 'atleta')
	{
		mysql_query("UPDATE $atle_ou_aux SET peso = old_peso, altura = old_altura, grupo_sanguineo = old_grupo_sanguineo, old_peso = NULL, old_altura = NULL, old_grupo_sanguineo = NULL WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]'");
	}else{
		mysql_query("UPDATE $atle_ou_aux SET funcao = old_funcao, habilit_literarias = old_habilit, old_funcao = NULL, old_habilit = NULL WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]'");
	}
	mysql_close($conexao);
	header('Location:  '.$path_part['basename']);
}
?>