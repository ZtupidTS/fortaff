<?php
#este script vai permitir esconder os bot�es no caso de j� estarmos a menos de 30 dias dos JO
$data_abertura = mysql_query("SELECT * FROM evento WHERE descricao = 'Abertura'");
$dados = mysql_fetch_array($data_abertura);
#converte a data recebida do mysql em segundos referente � data (timestamp do php)
$data_mysql = strtotime($dados['data']);
#chama a fun��o que vai converter e retornar o valor da diferen�a
require_once '../funcao/funcao_diff_data.php';
$data_devolvida = diff_data($data_mysql);
?>