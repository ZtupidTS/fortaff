<?php 
session_start();
include '../includes/test_intruso_rd.php';
include '../includes/ligacao.php'; 
$equipa = mysql_query("SELECT * FROM equipa WHERE cod_equipa = '$_GET[cod_equipa]'");
$dados = mysql_fetch_array($equipa);
mysql_query("UPDATE equipa SET estado_valido = 'D' WHERE cod_equipa = '$dados[cod_equipa]'");
mysql_close($conexao);
$_SESSION["mensagem"] = 'Equipa no estado eliminada.\nAguarda validação do comité.';
# recuperei o url da pagina anterior para o meter no javascript e assim não repetir codigo desnecessario
#require_once '../funcao/recupera_url.php';
#$url = recupera_url();
header('Location: area_gestao_rd.php');
?>



