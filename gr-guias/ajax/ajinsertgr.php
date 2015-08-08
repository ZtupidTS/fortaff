<?php
include '../includes/allpageaj.php';

$fields = array();

$fields['cl_name'] = dbString($_POST['cl_name']);
$fields['cl_localidade'] = dbString($_POST['cl_localidade']);
$fields['cl_morada'] = dbString($_POST['cl_morada']);
$fields['cl_codpostal'] = codpostalToMysql($_POST['cl_codpostal']);
$fields['cl_telefone'] = dbInteger($_POST['cl_telefone']);
$fields['art_marca'] = dbString($_POST['art_marca']);
$fields['art_modelo'] = dbString($_POST['art_modelo']);
//$fields['art_numserie']= dbString($_POST['art_numserie']);
$fields['art_type']= dbString($_POST['art_type']);
$fields['art_garantie']= dbInteger($_POST['art_garantie']);
$fields['art_orcamento'] = dbInteger($_POST['art_orcamento']);
$fields['id_user'] = $_SESSION['iduser'];
$fields['date_in'] = dbString(date('Y-m-d H:i:s', time() - 3600));
$fields['gr_enable'] = dbInteger(1);
$fields['id_section'] = dbInteger($_POST['id_section']);

if(isset($_POST['art_anomalia']))
{
    $fields['art_anomalia'] = dbString($_POST['art_anomalia']);
}
if(isset($_POST['art_numserie']))
{
    $fields['art_numserie']= dbString($_POST['art_numserie']);
}
if(isset($_POST['art_acessor']))
{
    $fields['art_acessor'] = dbString($_POST['art_acessor']);
}
if(isset($_POST['obs']))
{
    $fields['obs'] = dbString($_POST['obs']);
}
if(isset($_POST['art_estetic']))
{
    $fields['art_estetic'] = dbString($_POST['art_estetic']);
}
if(isset($_POST['art_numtalao']))
{
    $fields['art_numtalao'] = dbString($_POST['art_numtalao']);
}
if(isset($_POST['art_valor']))
{
    $fields['art_valor'] = dbFloat($_POST['art_valor']);
}
if(isset($_POST['art_dategar']))
{
    $fields['art_dategar'] = dbString(inverte_data($_POST['art_dategar']));
}
if(isset($_POST['art_ean']))
{
    $fields['art_ean'] = dbInteger($_POST['art_ean']);
}

$fields['id'] = grepInsert($fields);

$_SESSION['lastidinsert'] = $fields['id'];

//print_r($fields);

unset($fields);

insertmodifgr($_SESSION['lastidinsert'], "Criação da guia");

if(isset($_POST['tal_filename']))
{
    	$postfilename = $_POST['tal_filename'];
    	$postfilename = str_ireplace("\\", "/", $postfilename);
    	$file_new = explode("/", $postfilename);
    	foreach ($file_new as $v)
    	{
		if(strpos($v, ".") !== false)
		{
			$filefinal = explode(".", $v);
			rename('../uploads/' . $filefinal[0] . "." . $filefinal[1], '../uploads/' . $_SESSION['lastidinsert'] . '.' . $filefinal[1]);
			//agora vou guardar isso na DB			
			$fields = array();
			$fields['id'] = $_SESSION['lastidinsert'];
			$fields['url_talao'] = dbString('uploads/' . $_SESSION['lastidinsert'] . '.' . $filefinal[1]);
			grepUpdate($fields);
			unset($fields);
		}
	}   
}

echo 'ok';

closeDataBase();
?>
