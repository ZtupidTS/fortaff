<?php
#este script vai permitir filtrar as equipas e atletas a acrscentar numa prova a menos de 10 dias
$data_prova = mysql_query("SELECT * FROM prova WHERE cod_prova = '$dados[cod_prova]' and sexo = '$dados[sexo]'");
$data = mysql_fetch_array($data_prova);
#converte a data recebida do mysql em segundos referente р data (timestamp do php)
$data_mysql = strtotime($data['data']);
#chama a funчуo que vai converter e retornar o valor da diferenчa
require_once '../funcao/funcao_diff_data.php';
$data_devolvida_limit10 = diff_data($data_mysql);
?>