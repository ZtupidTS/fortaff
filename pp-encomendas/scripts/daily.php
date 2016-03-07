<?php
session_start();
include 'C:/xampp/htdocs/pp-encomendas/includes/database/mysql.php';
include 'C:/xampp/htdocs/pp-encomendas/includes/conf.php';

include $_SESSION['pp_bolo_mail_send_daily'];
include $_SESSION['pp_cobertura_mail_send_daily'];
include $_SESSION['pp_encomendas_mail_send_daily'];
include $_SESSION['pp_massa_mail_send_daily'];
include $_SESSION['pp_recheio_mail_send_daily'];
include $_SESSION['pp_users_mail_send_daily'];
include $_SESSION['view_nossosbolos_mail_send_daily'];
include $_SESSION['include_function'];
include $_SESSION['pp_modif_enc_mail_send_daily'];


//dia actual 
$date_atual = date('Y-m-d');
$date_mais8 = date("Y-m-d", strtotime($date_atual . ' + 8 days'));


//Estado dos sms

//aqui vou atualizar o estado das sms antes
$where = 'pp_enc_statussms  != 1 AND pp_enc_datalevantamento IS NULL AND pp_enc_datesms IS NOT NULL';
$table = encomendasGetByFiltro($where, 'pp_enc_dateenc');
if(mysql_num_rows($table) > 0)
{
	while($data = mysql_fetch_array($table))
	{
		//$versms = verifysms($data['sms_id']);
		//$status = $versms->body->MessageInfo->DeliveryStatus;
		$result = getreportegoi($data['pp_enc_smsid']);
	
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
		$fields['pp_enc_id'] = dbInteger($data['pp_enc_id']);
		//$fields['pp_enc_datesms'] = dbString(date('Y-m-d H:i:s', time() - 3600));
		$fields['pp_enc_statussms'] = dbString($status);
		encomendasUpdate($fields);
		unset($fields);
		//agora a tabela modif
		insertmodifencomenda($data['pp_enc_id'], $texto);
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

$textmail = '';
$textmail_final = '<html><body>';
//$titulo = "Indiferenciado";
//$numerowhile = 0;

$textmail_pdf = '';

$table = encomendasGetByFiltro("pp_enc_datedone >= ".dbString($date_atual)." AND pp_enc_datedone <= ".dbString($date_mais8). " AND pp_enc_datalevantamento is NULL AND pp_enc_enable = 1", "pp_enc_datedone");

while ($row = foreachRow($table))
{
	$textmail .= '<h2 style="color:blue"> Encomenda Nº ' . $row['pp_enc_id'] . '</h2>';
	
	$textmail .= '<b>Data do levantamento da encomenda:</b> '.$row['pp_enc_datedone'].'<br/>';
	$textmail .= '<b>Nome do cliente:</b> '.$row['pp_enc_clientname'].'<br/>';
	$textmail .= '<b>Contacto do cliente:</b> '.$row['pp_enc_clientcontact'].'<br/>';
	$textmail .= '<b>Data de criação da encomenda:</b> '.$row['pp_enc_dateenc'].'<br/>';
	if($row['pp_enc_idbolonosso'] == '')
	{
		$textmail .= '<b>Fez a selecção através de um bolo nosso:</b> Não<br/>';
	}else{
		$textmail .= '<b>Fez a selecção através de um bolo nosso:</b> Sim<br/>';
		$bolonosso = boloGetById($row['pp_enc_idbolonosso']);
		//mail
		$textmail_final .= $textmail;
		//$textmail_final .= '<img height="150" width="250" src="//219.21.221.141/pp-encomendas_dev/'.$bolonosso['pp_bolo_urlimage'].'"/><br/>';
		//pdf
		$textmail_pdf .= $textmail;
		//pelo site
		//$textmail_pdf .= '<img height="150" width="250" src="../'.$bolonosso['pp_bolo_urlimage'].'"/><br/>';
		//para criar o pdf com imagem
		$textmail_pdf .= '<img height="150" width="250" src="C:/xampp/htdocs/pp-encomendas/'.$bolonosso['pp_bolo_urlimage'].'"/><br/>';
		$textmail = '';
		
	}
	
	$textmail .= '<h4 style="color:green">Composição:</h4>';
	if($row['pp_enc_coberturaid'] == '')
	{
		$textmail .= '<b>Cobertura:</b> '.$row['pp_enc_coberturaoutra'].'<br/>';
	}else{
		$data_cob = coberturaGetById($row['pp_enc_coberturaid']);
		$textmail .= '<b>Cobertura:</b> '.$data_cob['pp_cobertura_designacao'].'<br/>';
	}
	if($row['pp_enc_recheioid'] == '')
	{
		$textmail .= '<b>Recheio:</b> '.$row['pp_enc_recheiooutra'].'<br/>';
	}else{
		$data_cob = recheioGetById($row['pp_enc_recheioid']);
		$textmail .= '<b>Recheio:</b> '.$data_cob['pp_recheio_designacao'].'<br/>';
	}
	if($row['pp_enc_massaid'] == '')
	{
		$textmail .= '<b>Massa:</b> '.$row['pp_enc_massaoutra'].'<br/>';
	}else{
		$data_cob = massaGetById($row['pp_enc_massaid']);
		$textmail .= '<b>Massa:</b> '.$data_cob['pp_massa_designacao'].'<br/>';
	}
	
	$textmail .= '<h4 style="color:green">Outros:</h4>';
	if($row['pp_enc_peso'] != '')
	{
		$textmail .= '<b>Peso:</b> '.$row['pp_enc_peso'].' Kg <br/>';
	}
	if($row['pp_enc_pessoas'] != '')
	{
		$textmail .= '<b>Pessoas:</b> '.$row['pp_enc_pessoas'].'<br/>';
	}
	if($row['pp_enc_dizeres'] != '')
	{
		$textmail .= '<b>Dizeres:</b> '.$row['pp_enc_dizeres'].'<br/>';
	}
	if($row['pp_enc_obs'] != '')
	{
		$textmail .= '<b>Observações:</b> '.$row['pp_enc_obs'].'<br/>';
	}	
}
if($textmail == "")
{
	$textmail .= 'Não há encomendas?? Verificar se não há mesmo encomendas.';
}

$textmail .= '<br/>';
$textmail .= '<br/>';
$textmail .= '<br/>';
$textmail .= '!!!! Muito importante, caso deixam de receber esse mail diario, avisar-me !!!!';
$textmail_pdf .= $textmail;
$textmail_final .= $textmail;

$textmail_final .= '</body></html>';

require_once('C:/xampp/htdocs/pp-encomendas/FPDF/html2pdf/html2pdf.class.php');
    
ob_start();
echo $textmail_pdf; 
$content = ob_get_clean();
$html2pdf = new HTML2PDF('P', 'A4', 'pt');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
$html2pdf->Output('C:/xampp/htdocs/pp-encomendas/scripts/script_diario.pdf', 'F');
//aqui permite me envia-lo em anexo
$content_PDF = $html2pdf->Output('', true);

enviamaildiary($textmail_final, $content_PDF);

closeDataBase();
?>