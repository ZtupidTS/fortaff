<?php 
session_start();
include '../includes/test_intruso_co.php';
include '../includes/ligacao.php'; 
mysql_query("UPDATE modalidade SET estado_valido = 'X' WHERE cod_modalidade = '$_GET[cod_modalidade]'");
mysql_query("UPDATE equipa SET estado_valido = 'X' WHERE cod_modalidade = '$_GET[cod_modalidade]'");
$equipas = mysql_query("SELECT * FROM equipa WHERE cod_modalidade = '$_GET[cod_modalidade]'");
while($dados = mysql_fetch_array($equipas))
{
	mysql_query("UPDATE elemento_in_equipa SET estado_valido = 'X' WHERE cod_equipa = '$dados[cod_equipa]'");
}
mysql_close($conexao);
$_SESSION["mensagem"] = 'Modalidade eliminada com sucesso';
# recuperei o url da pagina anterior para o meter no javascript e assim não repetir codigo desnecessario
#require_once '../funcao/recupera_url.php';
#$url = recupera_url();
header('Location: modalidade_co.php');
?>
