<?php
#concatenar a data para a BD
function concatenar_data($ano, $mes, $dia)
{
	$data = $ano .'-'. $mes .'-'. $dia;
	return $data;
}
#concatenar a hora para a BD 
function concatenar_hora($hora, $minutos)
{
	$hora = $hora .':'. $minutos .':'. '00';
	return $hora;
}
#arredondar o preço para a BD
function arredondar_preco($preco)
{
	return round($preco,2);
}
#explode a data que vem do mysql
function dividir_data($data)
{
	$data_array = explode("-", $data);
	return $data_array;
}
#explode a hora que vem do mysql
function dividir_hora($hora)
{
	$data_array = explode(":", $hora);
	return $data_array;
}
#inversa a data
function inverte_data($data)
{
	if(is_null($data))
	{
		return "Primeira visita";
	}else{	
		$data_invertida = explode("-", $data);
		$new_data = $data_invertida[2].'-'.$data_invertida[1].'-'.$data_invertida[0];
		return $new_data;
	}
}
#para o controle da inserção dos dados
function control_post($post)
{
	$nova_string = mysql_real_escape_string($post);
	return $nova_string;	
}
function enviamail($mail_orig,$login,$password)
{
	require '../mail/class.phpmailer.php';
	$email = (string)$mail_orig;
	$mail = new PHPmailer();
	$mail->IsSMTP();
	$mail->IsHTML(true);
	$mail->Helo='mail.pw-jre.heliohost.org';
	$mail->SMTPSecure='SSL';
	$mail->Username='jo2012@pw-jre.heliohost.org';
	$mail->Password='jre123456';
	$mail->Host='mail.pw-jre.heliohost.org';
	$mail->From='jo2012@pw-jre.heliohost.org';
	$mail->SetFrom=('jo2012@pw-jre.heliohost.org');
	$mail->AddAddress($email);
	#$mail->AddReplyTo('jo2012@pw-jre.heliohost.org', 'Administrator JO2012');	
	$mail->Subject='Palavra Passe JO2012';
	$mail->Body='<html><body><head><style>.tabela{border:solid 3px;font-size:25px;text-align:center;}</style></head>';
	$mail->Body.='<center><table><tr><img src="http://img703.imageshack.us/img703/4474/headermail.jpg"</td></tr>';
	$mail->Body.='<tr><td>Login de acesso ao site: '.$login.' </td></tr>';
	$mail->Body.='<tr><td>Palavra Passe: '.$password.'</td></tr></table></center></body></html>';
	

	if(!$mail->Send()){
	  #return $mail->ErrorInfo;
	  $erro = true;
	  #return 'Verifica o email introduzido (ex: meumail@mail.com)';
	  return $erro;
	}
	else{	 
		$erro = false;
		#return 'Email enviado com sucesso';
		return $erro;
	}
	$mail->SmtpClose();
	unset($mail);
}
?>