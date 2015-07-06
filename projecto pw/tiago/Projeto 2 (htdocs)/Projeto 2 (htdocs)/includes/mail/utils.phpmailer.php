<?php

require_once 'phpmailer/class.pop3.php';
require_once 'phpmailer/class.smtp.php';
require_once 'phpmailer/class.phpmailer.php';

addSmtpServer('gmail.com', 'smtp.gmail.com', '');
addSmtpServer('pw606.mx.com', 'mail.pw606.x10.mx', '');

function createMailJo($to, $subject, $body)
{
	return createMail(array("noreplypw606@gmail.com", "Jogos Olímpicos 2012"), "pw10606jo", 
					  $to, $subject, $body);
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
	$mail->Password='p';
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