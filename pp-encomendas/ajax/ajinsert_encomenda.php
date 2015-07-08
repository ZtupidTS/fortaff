<?php
include '../includes/allpageaj.php';

$fields = array();

if($_GET['coberturanova'] != '')
{
	$fields['pp_enc_coberturaoutra'] = dbString(control_post($_GET['coberturanova']));	
}else{
	$fields['pp_enc_coberturaid'] = dbInteger(control_post($_GET['idcobertura']));
}

if($_GET['recheionova'] != '')
{
	$fields['pp_enc_recheiooutra'] = dbString(control_post($_GET['recheionova']));	
}else{
	$fields['pp_enc_recheioid'] = dbInteger(control_post($_GET['idrecheio']));
}

if($_GET['massanova'] != '')
{
	$fields['pp_enc_massaoutra'] = dbString(control_post($_GET['massanova']));	
}else{
	$fields['pp_enc_massaid'] = dbInteger(control_post($_GET['idmassa']));
}

$fields['pp_enc_datedone'] = dbString(control_post($_GET['data']));
$fields['pp_enc_dateenc'] = dbString(date('Y-m-d H:i:s', time() - 3600));
$fields['pp_enc_peso'] = dbString(control_post($_GET['peso']));
$fields['pp_enc_pessoas'] = dbString(control_post($_GET['pessoas']));
$fields['pp_enc_dizeres'] = dbString(control_post($_GET['dizeres']));
$fields['pp_enc_obs'] = dbString(control_post($_GET['obs']));
$fields['pp_enc_clientname'] = dbString(control_post($_GET['nomecliente']));
$fields['pp_enc_clientcontact'] = dbString(control_post($_GET['contacto']));
$fields['pp_enc_obs'] = dbString(control_post($_GET['obs']));
$fields['pp_enc_sendsms'] = dbInteger(control_post($_GET['sendsms']));
$fields['pp_enc_us_id'] = dbInteger($_SESSION['iduser']);

$idencomenda = encomendasInsert($fields);

unset($fields);

insertmodifencomenda($idencomenda, "Criação da encomenda");

echo 'ok';

closeDataBase();
?>