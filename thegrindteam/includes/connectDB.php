<?php
$conexao = mysql_connect('localhost', 'u305473976_root', 'thegrindteam');
#$conexao = mysql_connect('mysql.1freehosting.com', 'u305473976_root', 'thegrindteam');
if (!$conexao) 
{
    die('Not connect to DB: ' . mysql_error());
}

$db_selected = mysql_select_db("u305473976_tgt", $conexao);
?>