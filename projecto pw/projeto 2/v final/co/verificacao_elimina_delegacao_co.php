<?php 
session_start(); 
include '../includes/test_intruso_co.php';
include '../includes/ligacao.php'; 
mysql_query("UPDATE delegacao SET estado_valido = 'X' WHERE cod_delegacao = '$_GET[cod_delegacao]'");
mysql_query("UPDATE equipa SET estado_valido = 'X' WHERE cod_delegacao = '$_GET[cod_delegacao]'");
$equipas = mysql_query("SELECT * FROM equipa WHERE cod_delegacao = '$_GET[cod_delegacao]' and estado_valido = 'X'");
while($dados = mysql_fetch_array($equipas))
{
	mysql_query("UPDATE elemento_in_equipa SET estado_valido = 'X' WHERE cod_equipa = '$dados[cod_equipa]'");
}
mysql_close($conexao);
$_SESSION["mensagem"] = 'Delegação eliminada com sucesso';
# recuperei o url da pagina anterior para o meter no javascript e assim não repetir codigo desnecessario nao funciona no IE
#require_once '../funcao/recupera_url.php';
#$url = recupera_url();
#$url = 'delegacao_co.php';
header('Location: delegacao_co.php');
?>

