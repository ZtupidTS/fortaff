<?php
include '../includes/allpageaj.php';

$fields = array();
$fields['rep_id'] = $_POST['rep_id'];
if(isset($_POST['rep_telefone1']))
{
	$fields['rep_telefone1'] = dbInteger($_POST['rep_telefone1']);
}
if(isset($_POST['rep_telefone2']))
{
	$fields['rep_telefone2'] = dbInteger($_POST['rep_telefone2']);
}
if(isset($_POST['rep_email']))
{
	$fields['rep_email'] = dbString($_POST['rep_email']);
}
if(isset($_POST['rep_email2']))
{
	$fields['rep_email2'] = dbString($_POST['rep_email2']);
}
if(isset($_POST['rep_morada']))
{
	$fields['rep_morada'] = dbString($_POST['rep_morada']);
}
if(isset($_POST['rep_nome2']))
{
	$fields['rep_nome2'] = dbString($_POST['rep_nome2']);
}
if(isset($_POST['rep_nome1']))
{
	$fields['rep_nome1'] = dbString($_POST['rep_nome1']);
}

reparadorUpdate($fields);
unset($fields);

if(isset($_POST['why']))
{
	$fields2 = array();
	$fields2['rep_id'] = $_POST['rep_id'];
	$fields2['us_id'] = $_SESSION['iduser'];
	$fields2['modif_date'] = dbString(date('Y-m-d H:i:s', time() - 3600));
	$fields2['modif_text'] = dbString($_POST['why']);

	modifrepInsert($fields2);
	unset($fields2);
}

echo 'ok';
closeDataBase();
?>