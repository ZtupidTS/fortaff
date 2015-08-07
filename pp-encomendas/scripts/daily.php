<?php
session_start();
include 'C:/xampp/htdocs/pp-encomendas_dev/includes/database/mysql.php';
include 'C:/xampp/htdocs/pp-encomendas_dev/includes/conf.php';

include $_SESSION['pp_bolo_mail_send_daily'];
include $_SESSION['pp_cobertura_mail_send_daily'];
include $_SESSION['pp_encomendas_mail_send_daily'];
include $_SESSION['pp_massa_mail_send_daily'];
include $_SESSION['pp_recheio_mail_send_daily'];
include $_SESSION['pp_users_mail_send_daily'];
include $_SESSION['view_nossosbolos_mail_send_daily'];
include $_SESSION['include_function'];


//dia actual 
$date_atual = date('Y-m-d');
$date_mais8 = date("Y-m-d", strtotime($date_atual . ' + 8 days'));


//Estado dos sms

//aqui vou atualizar o estado das sms antes
/*$where = 'status_sms  != 1 AND date_tocliente IS NULL AND date_sms IS NOT NULL';
$table = grepGetByFiltro($where, 'date_in');
if(mysql_num_rows($table) > 0)
{
	while($data = mysql_fetch_array($table))
	{
		//$versms = verifysms($data['sms_id']);
		//$status = $versms->body->MessageInfo->DeliveryStatus;
		$result = getreportegoi($data['sms_id']);
	
		$sent = intval($result['SENT']);
		$delivered =  intval($result['DELIVERED']);
		$not_delivered = intval($result['NOT_DELIVERED']);
		$invalid = intval($result['INVALID']);
		
		$continu = true;
		$status = 0;
		
		if(($delivered - $not_delivered - $invalid) > 0)
		{
			$texto = "SMS enviado e recebido pelo cliente";
			$continu = false;
			$status = 1;			
		}
		
		if(($not_delivered - $delivered - $invalid) > 0 && $continu)
		{
			$texto = "SMS enviado mas esta pendente";
			$continu = false;
			$status = 2;
		}
		
		if(($invalid - $delivered - $not_delivered) > 0 && $continu)
		{
			$texto = "SMS não entregue";
			$continu = false;
			$status = 3;
		}
		
		if($continu)
		{
			$texto = "SMS ainda não processado";
			//echo "SMS ainda não processado";
			$continu = false;
			$status = 0;
		}
		
		//insiro na DB
		$fields = array();
		$fields['id'] = dbInteger($data['id']);
		$fields['date_sms'] = dbString(date('Y-m-d H:i:s', time() - 3600));
		$fields['status_sms'] = dbString($status);
		grepUpdate($fields);
		unset($fields);
		//agora a tabela modif
		insertmodifgr($data['id'], $texto);
		/*switch($status){
			case 1:
				$texto = "SMS enviado e recebido pelo cliente";
				break;
			case 2:
				$texto = "SMS enviado mas esta pendente";
				break;
			case 3:
				$texto = "SMS não entregue";
				break;
			default:
				$texto = "Verificar script da noite";
				break;
		}
		
		
		
		
		
	}	
}
unset($where);
unset($table);
unset($data);*/

$textmail = '<html><body>';
//$titulo = "Indiferenciado";
//$numerowhile = 0;


$table = encomendasGetByFiltro("pp_enc_datedone >= ".dbString($date_atual)." AND pp_enc_datedone <= ".dbString($date_mais8). " AND pp_enc_datalevantamento is NULL AND pp_enc_enable = 1", "pp_enc_datedone");

while ($row = foreachRow($table))
{
	$textmail .= '<h2> Encomenda Nº ' . $row['pp_enc_id'] . '</h2>';
	
	$textmail .= 'Data do levantamento da encomenda: '.$row['pp_enc_datedone'].'<br/>';
	$textmail .= 'Nome do cliente: '.$row['pp_enc_clientname'].'<br/>';
	$textmail .= 'Contacto do cliente: '.$row['pp_enc_clientcontact'].'<br/>';
	$textmail .= 'Data de criação da encomenda: '.$row['pp_enc_dateenc'].'<br/>';
	if($row['pp_enc_idbolonosso'] == '')
	{
		$textmail .= 'Fez a selecção através de um bolo nosso: Não<br/>';
	}else{
		$textmail .= 'Fez a selecção através de um bolo nosso: Sim<br/>';
		$bolonosso = boloGetById($row['pp_enc_idbolonosso']);
		$textmail .= '<img height="150" width="250" src="../'.$bolonosso['pp_bolo_urlimage'].'"/><br/>';
		
	}
	
	$textmail .= '<h4>Composição:</h4>';
	if($row['pp_enc_coberturaid'] == '')
	{
		$textmail .= 'Cobertura: '.$row['pp_enc_coberturaoutra'].'<br/>';
	}else{
		$data_cob = coberturaGetById($row['pp_enc_coberturaid']);
		$textmail .= 'Cobertura: '.$data_cob['pp_cobertura_designacao'].'<br/>';
	}
	if($row['pp_enc_recheioid'] == '')
	{
		$textmail .= 'Recheio: '.$row['pp_enc_recheiooutra'].'<br/>';
	}else{
		$data_cob = recheioGetById($row['pp_enc_recheioid']);
		$textmail .= 'Recheio: '.$data_cob['pp_recheio_designacao'].'<br/>';
	}
	if($row['pp_enc_massaid'] == '')
	{
		$textmail .= 'Massa: '.$row['pp_enc_massaoutra'].'<br/>';
	}else{
		$data_cob = massaGetById($row['pp_enc_massaid']);
		$textmail .= 'Massa: '.$data_cob['pp_massa_designacao'].'<br/>';
	}
	
	$textmail .= '<h4>Outros:</h4>';
	if($row['pp_enc_peso'] != '')
	{
		$textmail .= 'Peso: '.$row['pp_enc_peso'].' Kg <br/>';
	}
	if($row['pp_enc_pessoas'] != '')
	{
		$textmail .= 'Pessoas: '.$row['pp_enc_pessoas'].'<br/>';
	}
	if($row['pp_enc_dizeres'] != '')
	{
		$textmail .= 'Dizeres: '.$row['pp_enc_dizeres'].'<br/>';
	}
	if($row['pp_enc_obs'] != '')
	{
		$textmail .= 'Observações: '.$row['pp_enc_obs'].'<br/>';
	}
	
		

	

	//isso vai para o mail
	/*$where = 'status_sms  != 1 AND date_sms IS NOT NULL AND date_tocliente IS NULL AND id_section = '.$numerowhile;
	$table = grepGetByFiltro($where, 'date_in');

	$textmail .= 'SMS enviados que não foram entregue ao cliente: <br/>';
	if(mysql_num_rows($table) > 0)
	{
		while($data = mysql_fetch_array($table))
		{
			//aqui vou ir buscar o numero do fornecedor
			$reparador = '';
			if($data['rep_id'] > 0)
			{
				$data_rep = reparadorGetById($data['rep_id']);
				$reparador = $data_rep['rep_name'];
			}else{
				$reparador = 'Não foi enviado mail ao reparador ainda';
			}
			$textmail .= 'GR nº' . $data['id'] . ' - Data entrada: ' . $data['date_in'] . ' - ' . $data['cl_name'] . ' - ' . $data['art_marca'] . ': ' . $data['art_type'] . ' - ' . $reparador . '<br/>';
		}	
	}else{
		$textmail .= 'Não existe nenhum. <br/>';
		
	}*/	
}


$textmail .= '<br/>';
$textmail .= '!!!! Muito importante, caso deixam de receber esse mail diario, avisar-me !!!!';
$textmail .= '</body></html>';

echo $textmail;

//echo 'd';
/*enviamaildiary($textmail);*/
//echo 'd';
closeDataBase();
?>