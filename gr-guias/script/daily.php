<?php
session_start();
include 'C:/xampp/htdocs/gr-guias/includes/database/mysql.php';
include 'C:/xampp/htdocs/gr-guias/includes/conf.php';

include $_SESSION['dblogin_mail_send_daily'];
include $_SESSION['dbgrep_mail_send_daily'];
include $_SESSION['dbmodifgr_mail_send_daily'];
include $_SESSION['dbmodifreparador_mail_send_daily'];
include $_SESSION['dbreparador_mail_send_daily'];
include $_SESSION['dbsection_mail_send_daily'];


include $_SESSION['include_function'];
//require 'C:/xampp/htdocs/gr-guias/sms/bootstrap.php';
//openDataBase("localhost", "gr", "root", "fafedis");



//tenho de fazer para 15 dias, 30 dias, e o estado das sms, depois mandar o mail com isso.

//dia actual =< 15 dias sem mandar ao fornecedor
$date_atual = date("Y-m-d");
$date_menos15 = date("Y-m-d", strtotime($date_atual . ' - 15 days'));
$date_menos30 = date("Y-m-d", strtotime($date_atual . ' - 25 days'));

//Estado dos sms

//aqui vou atualizar o estado das sms antes
$where = 'status_sms  != 1 AND date_tocliente IS NULL AND date_sms IS NOT NULL';
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
		}*/
		
		
		
		
		
	}	
}
unset($where);
unset($table);
unset($data);

$textmail = '<html><body>';
//$titulo = "Indiferenciado";
//$numerowhile = 0;

$tablesection = sectionGetAll();
while ($sec = foreachRow($tablesection))
{
	$titulo = $sec['sec_name'];
	$numerowhile = $sec['sec_id'];
	
	$where = 'date_in  >= ' . dbString($date_menos15) . ' AND date_torep IS NULL AND date_tocliente IS NULL AND id_section = '.$numerowhile;
	$table = grepGetByFiltro($where, 'date_in');
	
	$textmail .= '<h2>' . $titulo . '</h2><br/>';
	$textmail .= 'Reparação pendentes <= a 15 dias que ainda não foram levantadas pelo reparador: <br/>';
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
		$textmail .= 'Não existe nenhuma. <br/>';
		
	}
	$textmail .= '<br/>';
	unset($where);
	unset($table);
	unset($data);

	//dia actual =< 15 dias levantadas pelo fornecedor
	$where = 'date_in  >= ' . dbString($date_menos15) . ' AND date_torep IS NOT NULL AND date_tocliente IS NULL AND id_section = '.$numerowhile;
	$table = grepGetByFiltro($where, 'date_in');

	$textmail .= 'Reparação pendentes <= a 15 dias que já foram levantadas pelo reparador: <br/>';
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
		$textmail .= 'Não existe nenhuma. <br/>';
		
	}
	$textmail .= '<br/>';
	unset($where);
	unset($table);
	unset($data);

	//reparações que já atingiram 30 dias e ainda não foram entregue ao cliente
	$where = 'date_in  <= ' . dbString($date_menos30) . ' AND date_tocliente IS NULL AND id_section = '.$numerowhile;
	$table = grepGetByFiltro($where, 'date_in');

	$textmail .= 'Reparação pendentes >= a 25 dias ou que ainda não foram entregue ao cliente: <br/>';
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
			$textmail .= 'GR nº' . $data['id'] . ' - Data entrada: ' . $data['date_in'] . ' - ' . $data['cl_name'] . ' - ' . $data['art_marca'] . ': ' . $data['art_type'] . ' - ' . $reparador . '<br/>';;
		}	
	}else{
		$textmail .= 'Não existe nenhuma. <br/>';
		
	}
	$textmail .= '<br/>';
	unset($where);
	unset($table);
	unset($data);

	/*//Estado dos sms

	//aqui vou atualizar o estado das sms antes
	$where = 'status_sms  > 1 AND date_tocliente IS NULL';
	$table = grepGetByFiltro($where, 'date_in');
	if(mysql_num_rows($table) > 0)
	{
		while($data = mysql_fetch_array($table))
		{
			$versms = verifysms($data['sms_id']);
			$status = $versms->body->MessageInfo->DeliveryStatus;
			//insiro na DB
			$fields = array();
			$fields['id'] = dbInteger($data['id']);
			$fields['status_sms'] = dbString($status);
			grepUpdate($fields);
			unset($fields);
			//agora a tabela modif
			$fields = array();
			$fields['gr_id'] = $data['id'];
			$fields['us_id'] = 9;
			$fields['modif_date'] = dbString(date("Y-m-d H-i-s"));
			switch($status){
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
			$fields['modif_text'] = dbString($texto);
			modifgrInsert($fields);
			unset($fields);	
			
		}	
	}
	unset($where);
	unset($table);
	unset($data);*/

	//isso vai para o mail
	$where = 'status_sms  != 1 AND date_sms IS NOT NULL AND date_tocliente IS NULL AND id_section = '.$numerowhile;
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
		
	}
	/*$numerowhile = $numerowhile + 1;
	if($numerowhile == 1)
	{
		$titulo = "Bazar Pesado";
	}else{
		$titulo = "Bazar Ligeiro";
	}*/
}
$textmail .= '<br/>';
unset($where);
unset($table);
unset($data);

$textmail .= '!!!! Muito importante, caso deixam de receber esse mail diario, avisar-me !!!!';
$textmail .= '</body></html>';

//echo 'd';
enviamaildiary($textmail);
//echo 'd';
closeDataBase();
?>