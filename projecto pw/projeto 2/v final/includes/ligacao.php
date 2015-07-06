<?php
$conexao = mysql_connect('localhost', 'pwjre_root','jre123456');
if (!$conexao) {
    die('Não foi possível conectar: ' . mysql_error());
}
$db_selected = mysql_select_db("pwjre_jo2012", $conexao);
?>