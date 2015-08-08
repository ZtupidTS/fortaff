<?php
include '../includes/allpageaj.php';

$fields = array();
$fields['id'] = dbInteger($_POST['id']);
//echo " | " . $_POST['art_ean'] . " ! ";
if(strlen($_POST['cl_telefone']) > 0)
{
	$fields['cl_telefone'] = dbInteger($_POST['cl_telefone']);	
}
if(strlen($_POST['art_acessor']) > 0)
{
	$fields['art_acessor'] = dbString($_POST['art_acessor']);	
}
if(strlen($_POST['art_numserie']) > 0)
{
	$fields['art_numserie'] = dbString($_POST['art_numserie']);	
}
if(strlen($_POST['obs']) > 0)
{
	$fields['obs'] = dbString($_POST['obs']);	
}
if(strlen($_POST['art_ean']) > 0)
{
	$fields['art_ean'] = dbInteger($_POST['art_ean']);	
}
if(strlen($_POST['art_anomalia']) > 0)
{
	$fields['art_anomalia'] = dbString($_POST['art_anomalia']);	
}
if(strlen($_POST['cl_morada']) > 0)
{
	$fields['cl_morada'] = dbString($_POST['cl_morada']);	
}

//print_r($fields);

grepUpdate($fields);
/*if($_SESSION['mySql_objects']['error'])
{
	print_r($_SESSION['mySql_objects']['errorObj']);	
}*/
unset($fields);

if(isset($_POST['why']))
{
	$fields2 = array();
	$fields2['gr_id'] = $_POST['id'];
	$fields2['us_id'] = $_SESSION['iduser'];
	$fields2['modif_date'] = dbString(date('Y-m-d H:i:s', time() - 3600));
	$fields2['modif_text'] = dbString($_POST['why']);

	modifgrInsert($fields2);
	unset($fields2);
}

echo 'ok';
closeDataBase();
?>