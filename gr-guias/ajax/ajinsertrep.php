<?php
include '../includes/allpageaj.php';

$fields = array();

$fields['rep_name'] = dbString($_POST['rep_name']);
$fields['rep_enable'] = 1;

if(isset($_POST['rep_morada']))
{
    $fields['rep_morada'] = dbString($_POST['rep_morada']);
}
if(isset($_POST['rep_email']))
{
    $fields['rep_email'] = dbString(strtolower($_POST['rep_email']));
}
if(isset($_POST['rep_email2']))
{
    $fields['rep_email2'] = dbString(strtolower($_POST['rep_email2']));
}
if(isset($_POST['rep_telefone1']))
{
    $fields['rep_telefone1'] = dbInteger($_POST['rep_telefone1']);
}
if(isset($_POST['rep_nome1']))
{
    $fields['rep_nome1'] = dbString($_POST['rep_nome1']);
}
if(isset($_POST['rep_telefone2']))
{
    $fields['rep_telefone2'] = dbInteger($_POST['rep_telefone2']);
}
if(isset($_POST['rep_nome2']))
{
    $fields['rep_nome2'] = dbString($_POST['rep_nome2']);
}

$fields['id'] = reparadorInsert($fields);


//aqui vou inserir na tabela modificação.
$fields2 = array();
$fields2['rep_id'] = $fields['id'];
$fields2['us_id'] = $_SESSION['iduser'];
$fields2['modif_date'] = dbString(date('Y-m-d H:i:s', time() - 3600));
$fields2['modif_text'] = dbString("Criação do reparador");

modifrepInsert($fields2);
unset($fields);
unset($fields2);

echo 'ok';

closeDataBase();
?>