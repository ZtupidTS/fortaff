<?php
include 'C:/xampp/htdocs/profumi/includes/allpage.php';

//require 'C:/xampp/htdocs/gr-guias/sms/bootstrap.php';
//openDataBase("localhost", "gr", "root", "fafedis");

//Estado dos sms

//aqui vou atualizar o estado das sms antes
$where = 'state  != "OK" AND sms_date IS NOT NULL';
$table = smsGetByFiltro($where, 'id');
if(count($table) > 0)
{
	while($data = $table->fetchArray())
	{
		//$versms = verifysms($data['sms_id']);
		//$status = $versms->body->MessageInfo->DeliveryStatus;
		$result = getreportegoi($data['smsid']);
	
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
			$status = 'OK';			
		}
		
		if(($not_delivered - $delivered - $invalid) > 0 && $continu)
		{
			$texto = "SMS enviado mas esta pendente";
			$continu = false;
			$status = '2';
		}
		
		if(($invalid - $delivered - $not_delivered) > 0 && $continu)
		{
			$texto = "SMS não entregue";
			$continu = false;
			$status = '3';
		}
		
		if($continu)
		{
			$texto = "SMS ainda não processado";
			//echo "SMS ainda não processado";
			$continu = false;
			$status = '0';
		}
		
		//insiro na DB
		$fields = array();
		$fields['id'] = dbInteger($data['id']);
		//$fields['date_sms'] = dbString(date('Y-m-d H:i:s', time() - 3600));
		$fields['state'] = dbString($status);
		smsUpdate($fields);
		unset($fields);
		//agora a tabela modif
		//insertmodifgr($data['id'], $texto);
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

//echo 'd';
closeDataBase();
?>