<?php 
session_start();
include '../includes/test_intruso_rd.php';
include '../includes/ligacao.php'; 
$el_equipa = mysql_query("SELECT * FROM elemento_in_equipa WHERE cod_elemento_equipa = '$_GET[cod_elemento_equipa]'");
$dados = mysql_fetch_array($el_equipa);
mysql_query("UPDATE elemento_in_equipa SET estado_valido = 'D' WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]'");
mysql_query("UPDATE elemento_equipa SET old_nome = NULL, old_data_nasc = NULL, old_sexo = NULL WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]'");
$sera_atleta = mysql_query("SELECT * FROM atleta WHERE cod_elemento_equipa = '$_GET[cod_elemento_equipa]'");
if(mysql_num_rows($sera_atleta) > 0)
{
	mysql_query("UPDATE atleta SET old_peso = NULL, old_altura = NULL, old_grupo_sanguineo = NULL WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]'");
}else{
	mysql_query("UPDATE auxiliar SET old_funcao = NULL, old_habilit = NULL WHERE cod_elemento_equipa = '$dados[cod_elemento_equipa]'");
}
mysql_close($conexao);
$_SESSION["mensagem"] = 'Elemento no estado pendente.\nAguardando validação do Comité';
# recuperei o url da pagina anterior para o meter no javascript e assim não repetir codigo desnecessario
#require_once '../funcao/recupera_url.php'; nao funciona no ie
#$url = recupera_url();
#$url = 'atletas_rd.php';
header('Location: atletas_rd.php');
?>


