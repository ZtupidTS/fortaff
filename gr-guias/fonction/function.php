<?php

function recupera_url()
{
    $path_part = pathinfo($_SERVER['REQUEST_URI']);
    return $path_part['filename'];
    #return $path_part;
}

#para o controle da inser��o dos dados
function control_post($post)
{
	$nova_string = mysql_real_escape_string($post);
	return $nova_string;	
}

//raiz do projecto
function rootPath($path, $offset = 0) 
{
    $rev = strrev($_SERVER['SCRIPT_NAME']);
    $i = 0;
    $count = 0;
    while ($i = strpos($rev, '/', $i)) {
            $count += 1;
            $i += 1;
    }
    $count -= (1 + $offset);
    return str_repeat('../', $count) . $path;
}

#inversa a data
function inverte_data($data)
{
    $data_invertida = explode("-", $data);
    $new_data = $data_invertida[2].'-'.$data_invertida[1].'-'.$data_invertida[0];
    return $new_data;
}

//data to pdf guia
function invertedatasemhora($data)
{
    if(strlen($data) > 0)
    {
    	$data_semtempo = explode(" ", $data);
    	$data_invertida = explode("-", $data_semtempo[0]);
    	$new_data = $data_invertida[2].'-'.$data_invertida[1].'-'.$data_invertida[0];
    }else{
    	$new_data = "";	
    }
    return $new_data;
}

//codigo postal to DB
function codpostalToMysql($cod)
{
    $newcod = explode("-", $cod); 
    return $newcod[0].''.$newcod[1];    
}
//codigo postal to form
function codpostalToForm($cod)
{
    $cod1 = substr($cod, 0, -3);
    $cod2 = substr($cod, 4, 3);
    return $cod1."-".$cod2;
}
#enviar um mail
function enviamail($dest,$id_gr,$body_mail,$anex)
{
	require '../mail/class.phpmailer.php';
	//$emaildest = (string)$dest;
	$mail = new PHPmailer();
	$mail->IsSMTP();
	$mail->IsHTML(true);
	$mail->Helo=$_SESSION['helo_envio_mail_send_supplier'];
	//$mail->SMTPSecure='SSL';
	$mail->Port= $_SESSION['port_envio_mail_send_supplier'];
	$mail->Username= $_SESSION['login_mail_send_supplier'];
	$mail->Password= $_SESSION['password_mail_send_supplier'];
	$mail->Host= $_SESSION['host_envio_mail_send_supplier'];
	$mail->From= $_SESSION['from_mail_send_supplier'];
	$mail->SetFrom=($_SESSION['setfrom_mail_send_supplier']);
	foreach ($dest as $db => $value) {
		$mail->AddAddress($value);		
	}	
	//$mail->AddAddress($emaildest);
        $mail->AddCC($_SESSION['addcc_mail_send_supplier']);
	#$mail->AddReplyTo('jo2012@pw-jre.heliohost.org', 'Administrator JO2012');	
	$mail->Subject='GR Nº' . $id_gr;
	$mail->Body='<html><body>Bom dia,<br /><br />' . $body_mail . '<br/><br/>Obrigado pela atenção.</body></html>';
	
        $pdf = createpdf($id_gr);
        $attachment= $pdf->Output('GR numero '. $id_gr . '.pdf', 'S');
        $mail->AddStringAttachment($attachment, 'GR numero '. $id_gr . '.pdf');
        //verifica se existe um talão porque se existe é sempre para enviar
        if (strpos($id_gr,'-') !== false) 
	{
		$data = grepGetByGrNumber($id_gr);		
	}else{
		$data = grepGetById($id_gr);	
	}
        //$data = grepGetById($id_gr);
        //$urlguia = $data['url_talao'];
	if($data['url_talao'] != "")
	{
		$mail->AddAttachment('../' . $data['url_talao'], 'talao.pdf');
	}
	unset($data);
        
        if($anex != '')
        {
		$mail->AddAttachment($anex);		
	}
        
        
	if($mail->Send()){
		$mail->ErrorInfo;
		$mail->SmtpClose();
		unset($mail);
		//$erro = true;
		#return 'Verifica o email introduzido (ex: meumail@mail.com)';
		return false;
	}
	else{	 
		//$erro = false;
		$mail->SmtpClose();
		unset($mail);
		#return 'Email enviado com sucesso';
		return true;
	}
	#$mail->SmtpClose();
	#unset($mail);
}
//criar pdf A5
function createpdfA5($id_gr)
{
    require('../fpdf/fpdf.php');
    //permite criar uma font a partir das font do windows
    //require('../fpdf/makefont/makefont.php');
    //MakeFont('../fpdf/arial.ttf','iso-8859-1', true);

    $grepdb = grepGetById($id_gr);
    
    $pdf = new FPDF('L','mm','A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('arial','',9);
    $pdf->Cell(10,10,$pdf->Image('../images/eleclerc.jpg',8,7,30),0 ,0 ,'L');
    $pdf->Cell(10,10,$pdf->Image('../images/eleclerc.jpg',148,7,30),0 ,0 ,'L');
    //$pdf->Cell(0,10,utf8_decode('Guia de Reparação nº19') ,0 ,0 ,'R');
    $pdf->Ln(6);
    if($grepdb['gr_number'] == "")
    {
    	$pdf->Cell(140,5,utf8_decode('Guia de Reparação nº' . $grepdb['id']) ,0 ,0 ,'L');
    	$pdf->Cell(0,5,utf8_decode('Guia de Reparação nº' . $grepdb['id']) ,0 ,0 ,'L');	
    }else{
    	$pdf->Cell(140,5,utf8_decode('Guia de Reparação nº' . $grepdb['gr_number']) ,0 ,0 ,'L');
    	$pdf->Cell(0,5,utf8_decode('Guia de Reparação nº' . $grepdb['gr_number']) ,0 ,0 ,'L');
    }
    //$pdf->Cell(140,5,utf8_decode('Guia de Reparação nº' . $grepdb['gr_number']) ,0 ,0 ,'L');
    //$pdf->Cell(0,5,utf8_decode('Guia de Reparação nº' . $grepdb['gr_number']) ,0 ,0 ,'L');
    $pdf->Ln(6);
    $pdf->Cell(100,10,utf8_decode($_SESSION['morada_leclerc_pdf']) ,0 ,0, 'L');
    $pdf->Cell(40,10,utf8_decode('Data: '. invertedatasemhora($grepdb['date_in'])) ,0 ,0, 'L');
    //a5
    $pdf->Cell(100,10,utf8_decode($_SESSION['morada_leclerc_pdf']) ,0 ,0, 'L');
    $pdf->Cell(2,10,utf8_decode('Data: '. invertedatasemhora($grepdb['date_in'])) ,0 ,0, 'L');
    $pdf->Ln(6);
    $pdf->Cell(140,10,utf8_decode($_SESSION['cod_postal_leclerc_pdf']) ,0 ,0, 'L');
    //a5
    $pdf->Cell(0,10,utf8_decode($_SESSION['cod_postal_leclerc_pdf']) ,0 ,0, 'L');
    $pdf->Ln(6);
    $pdf->Cell(140,10,utf8_decode('Tel: '.$_SESSION['telefone_leclerc_pdf'].' Fax: '.$_SESSION['fax_leclerc_pdf']) ,0 ,0, 'L');
    //a5
    $pdf->Cell(0,10,utf8_decode('Tel: '.$_SESSION['telefone_leclerc_pdf'].' Fax: '.$_SESSION['fax_leclerc_pdf']) ,0 ,0, 'L');
    $pdf->Ln(6);
    $pdf->Cell(140,10,utf8_decode($_SESSION['mail_leclerc_pdf']) ,0 ,0, 'L');
    //a5
    $pdf->Cell(0,10,utf8_decode($_SESSION['mail_leclerc_pdf']) ,0 ,0, 'L');
    $pdf->Ln(6);
    $pdf->Cell(140,10,utf8_decode('NIF: '.$_SESSION['nif_leclerc_pdf']) ,0 ,0, 'L');
    //a5
    $pdf->Cell(0,10,utf8_decode('NIF: '.$_SESSION['nif_leclerc_pdf']) ,0 ,0, 'L');

    //cliente
    $pdf->Ln(9);
    $pdf->SetFont('arial','',12);
    $pdf->Cell(140,10,utf8_decode('Cliente') ,0 ,0, 'L');
    //a5
    $pdf->Cell(0,10,utf8_decode('Cliente') ,0 ,0, 'L');
    $pdf->Ln(2);
    $pdf->Cell(140,10,utf8_decode('______________________________________________________') ,0 ,0, 'L');
    //a5
    $pdf->Cell(0,10,utf8_decode('______________________________________________________') ,0 ,0, 'L');
    $pdf->Ln(6);
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(10,10,utf8_decode('Nome:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(130,10,utf8_decode(' ' .$grepdb['cl_name']));
    //a5
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(10,10,utf8_decode('Nome:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(0,10,utf8_decode(' ' .$grepdb['cl_name']));
    $pdf->Ln(6);
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(12,10,utf8_decode('Morada:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(128,10,utf8_decode(' ' . $grepdb['cl_morada']));
    //a5
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(12,10,utf8_decode('Morada:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(0,10,utf8_decode(' ' . $grepdb['cl_morada']));
    $pdf->Ln(6);
    //o multicell permite ser só uma linha ou caso acaba a linha cria logo uma por baixo
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(16,10,utf8_decode('Localidade:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(60,10,utf8_decode(' ' . $grepdb['cl_localidade']));  
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(17,10,utf8_decode('Cod. Postal:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(47,10,utf8_decode(' ' . codpostalToForm($grepdb['cl_codpostal'])));
    //a5
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(16,10,utf8_decode('Localidade:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(60,10,utf8_decode(' ' . $grepdb['cl_localidade']));  
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(17,10,utf8_decode('Cod. Postal:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(0,10,utf8_decode(' ' . codpostalToForm($grepdb['cl_codpostal'])));
    
    $pdf->Ln(6);
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(14,10,utf8_decode('Contacto:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(126,10,utf8_decode(' ' . $grepdb['cl_telefone']));
    //a5
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(14,10,utf8_decode('Contacto:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(0,10,utf8_decode(' ' . $grepdb['cl_telefone']));
    //artigo
    $pdf->Ln(9);
    $pdf->SetFont('arial','',12);
    $pdf->Cell(140,10,utf8_decode('Artigo') ,0 ,0, 'L');
    //a5
    $pdf->Cell(0,10,utf8_decode('Artigo') ,0 ,0, 'L');
    $pdf->Ln(2);
    $pdf->Cell(140,10,utf8_decode('______________________________________________________') ,0 ,0, 'L');
    //a5
    $pdf->Cell(0,10,utf8_decode('______________________________________________________') ,0 ,0, 'L');
    $pdf->Ln(6);
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(10,10,utf8_decode('Marca:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(47,10,utf8_decode(' ' . $grepdb['art_marca']));
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(7,10,utf8_decode('Tipo:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(76,10,utf8_decode(' ' . $grepdb['art_type']));
    //a5
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(10,10,utf8_decode('Marca:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(47,10,utf8_decode(' ' . $grepdb['art_marca']));
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(7,10,utf8_decode('Tipo:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(0,10,utf8_decode(' ' . $grepdb['art_type']));
    
    $pdf->ln(6);
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(12,10,utf8_decode('Modelo:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(45,10,utf8_decode(' ' . $grepdb['art_modelo']));
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(7,10,utf8_decode('EAN:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(76,10,utf8_decode(' ' . $grepdb['art_ean']));
    //a5
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(12,10,utf8_decode('Modelo:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(45,10,utf8_decode(' ' . $grepdb['art_modelo']));
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(7,10,utf8_decode('EAN:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(0,10,utf8_decode(' ' . $grepdb['art_ean']));
    
    $pdf->ln(6);
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(13,10,utf8_decode('Nº Série:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(127,10,utf8_decode(' ' . $grepdb['art_numserie']));
    //a5
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(13,10,utf8_decode('Nº Série:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(0,10,utf8_decode(' ' . $grepdb['art_numserie']));
    
    $pdf->ln(6);
    $newcell = false;
    if(strlen($grepdb['art_anomalia']) > 80)
    {
    	$anomaliatemp = wordwrap($grepdb['art_anomalia'], 80, "%&", true);    	
    	$anomaliafinal = split("%&", $anomaliatemp);
    	$newcell = true;
    }else{
    	$anomaliafinal = array($grepdb['art_anomalia']);
    }
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(14,10,utf8_decode('Anomalia:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(126,10,utf8_decode(' ' . $anomaliafinal[0]));
    //a5
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(14,10,utf8_decode('Anomalia:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(10,10,utf8_decode(' ' . $anomaliafinal[0]));
    if($newcell)
    {
    	$pdf->ln(6);
    	$pdf->Cell(140,10,utf8_decode($anomaliafinal[1]));
    	$pdf->Cell(0,10,utf8_decode($anomaliafinal[1]));
    }
    
    $pdf->ln(6);
    $newcell = false;
    if(strlen($grepdb['art_acessor']) > 80)
    {
    	$acessotemp = wordwrap($grepdb['art_acessor'], 80, "%&", true);    	
    	$acessofinal = split("%&", $acessotemp);
    	$newcell = true;
    }else{
    	$acessofinal = array($grepdb['art_acessor']);
    }
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(16,10,utf8_decode('Acessórios:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(124,10,utf8_decode(' ' . $acessofinal[0]));
    //a5
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(16,10,utf8_decode('Acessórios:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(10,10,utf8_decode(' ' . $acessofinal[0]));
    if($newcell)
    {
    	$pdf->ln(6);
    	$pdf->Cell(140,10,utf8_decode($acessofinal[1]));
    	$pdf->Cell(0,10,utf8_decode($acessofinal[1]));
    }
    
    $pdf->ln(6);
    $newcell = false;
    if(strlen($grepdb['art_estetic']) > 80)
    {
    	$esttemp = wordwrap($grepdb['art_estetic'], 80, "%&", true);    	
    	$estfinal = split("%&", $esttemp);
    	$newcell = true;
    }else{
    	$estfinal = array($grepdb['art_estetic']);
    }
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(12,10,utf8_decode('Estética:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(128,10,utf8_decode(' ' . $estfinal[0]));
    //a5
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(12,10,utf8_decode('Estética:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(10,10,utf8_decode(' ' . $estfinal[0]));
    if($newcell)
    {
    	$pdf->ln(6);
    	$pdf->Cell(140,10,utf8_decode($estfinal[1]));
    	$pdf->Cell(0,10,utf8_decode($estfinal[1]));
    }
    
    $pdf->ln(7);
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(9,10,utf8_decode('Talão:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(47,10,utf8_decode(' ' . $grepdb['art_numtalao']));
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(9,10,utf8_decode('Valor:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(75,10,utf8_decode(' ' . $grepdb['art_valor']));
    //a5
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(9,10,utf8_decode('Talão:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(47,10,utf8_decode(' ' . $grepdb['art_numtalao']));
    $pdf->SetFont('arial','U',9);
    $pdf->Cell(9,10,utf8_decode('Valor:'));
    $pdf->SetFont('arial','',9);
    $pdf->Cell(0,10,utf8_decode(' ' . $grepdb['art_valor']));
    
    $pdf->Ln(6);
    if($grepdb['art_garantie'] == 1)
    {
        $pdf->SetFont('arial','U',9);
        $pdf->Cell(13,10,utf8_decode('Garantia:'));
        $pdf->SetFont('arial','',9);
        $pdf->Cell(43,10,utf8_decode(' Sim'));
        $pdf->SetFont('arial','U',9);
        $pdf->Cell(8,10,utf8_decode('Data:'));
        $pdf->SetFont('arial','',9);
        $pdf->Cell(76,10,utf8_decode(' ' . $grepdb['art_dategar']));
        //a5
        $pdf->SetFont('arial','U',9);
        $pdf->Cell(13,10,utf8_decode('Garantia:'));
        $pdf->SetFont('arial','',9);
        $pdf->Cell(43,10,utf8_decode(' Sim'));
        $pdf->SetFont('arial','U',9);
        $pdf->Cell(10,10,utf8_decode('Data:'));
        $pdf->SetFont('arial','',9);
        $pdf->Cell(2,10,utf8_decode(' ' . $grepdb['art_dategar']));
    }else{
    	$pdf->SetFont('arial','U',9);
        $pdf->Cell(13,10,utf8_decode('Garantia:') ,0 ,0, 'L');
        $pdf->SetFont('arial','',9);
        $pdf->Cell(127,10,utf8_decode(' Não') ,0 ,0, 'L');
        //a5
        $pdf->SetFont('arial','U',9);
        $pdf->Cell(13,10,utf8_decode('Garantia:') ,0 ,0, 'L');
        $pdf->SetFont('arial','',9);
        $pdf->Cell(0,10,utf8_decode(' Não') ,0 ,0, 'L');
    }
    
    $pdf->Ln(6);
    if($grepdb['art_orcamento'] == 1)
    {
        $pdf->SetFont('arial','U',9);
        $pdf->Cell(16,10,utf8_decode('Orçamento:') ,0 ,0, 'L');
        $pdf->SetFont('arial','',9);
        $pdf->Cell(124,10,utf8_decode(' Sim') ,0 ,0, 'L');
        //a5
        $pdf->SetFont('arial','U',9);
        $pdf->Cell(16,10,utf8_decode('Orçamento:') ,0 ,0, 'L');
        $pdf->SetFont('arial','',9);
        $pdf->Cell(0,10,utf8_decode(' Sim') ,0 ,0, 'L');
    }else{
    	$pdf->SetFont('arial','U',9);
        $pdf->Cell(16,10,utf8_decode('Orçamento:') ,0 ,0, 'L');
        $pdf->SetFont('arial','',9);
        $pdf->Cell(124,10,utf8_decode(' Não') ,0 ,0, 'L');
        //a5
        $pdf->SetFont('arial','U',9);
        $pdf->Cell(16,10,utf8_decode('Orçamento:') ,0 ,0, 'L');
        $pdf->SetFont('arial','',9);
        $pdf->Cell(0,10,utf8_decode(' Não') ,0 ,0, 'L');
    }
    
    $pdf->Ln(7);
    $pdf->Cell(20,10,utf8_decode('               '));
    $pdf->Cell(60,10,utf8_decode('Assinatura Cliente:'));
    $pdf->Cell(60,10,utf8_decode('Assinatura Funcionário:'));
    $pdf->Cell(20,10,utf8_decode('               '));
    $pdf->Cell(60,10,utf8_decode('Assinatura Cliente:'));
    $pdf->Cell(2,10,utf8_decode('Assinatura Funcionário:'));
    $pdf->Ln(7);
    $pdf->Cell(20,10,utf8_decode('               '));
    $pdf->Cell(60,10,utf8_decode('________________'));
    $pdf->Cell(60,10,utf8_decode('____________________'));
    $pdf->Cell(20,10,utf8_decode('               '));
    $pdf->Cell(60,10,utf8_decode('________________'));
    $pdf->Cell(2,10,utf8_decode('____________________'));
    
    $pdf->Ln(9);
    $newcell = false;
    $breakline = 0;
    switch ($_SESSION['size_font_rodape']) {
	    case 7:
	        $breakline = 93;
	        break;
	    case 6:
	        $breakline = 105;
	        break;
	    case 5:
	        $breakline = 130;
	        break;
	    case 4:
	        $breakline = 160;
	        break;
	}
    
    
    if(strlen($_SESSION['rodape_guia']) > $breakline)
    {
    	$acessotemp = wordwrap($_SESSION['rodape_guia'], $breakline, "%&", true);    	
    	$acessofinal = split("%&", $acessotemp);
    	$newcell = true;
    }else{
    	$acessofinal = array($_SESSION['rodape_guia']);
    }
    $pdf->SetFont('arial','',$_SESSION['size_font_rodape']);
    $pdf->Cell(140,10,utf8_decode($acessofinal[0]));
    //a5
    $pdf->Cell(10,10,utf8_decode($acessofinal[0]));
    if($newcell)
    {
    	for($i = 1; $i < count($acessofinal); $i++) 
    	{
	    	$pdf->ln(3);
    		$pdf->Cell(140,10,utf8_decode($acessofinal[$i]));
    		$pdf->Cell(0,10,utf8_decode($acessofinal[$i]));
	}
    }
    
    return $pdf;
}
//criar pdf A4
function createpdf($id_gr)
{
    require('../fpdf/fpdf.php');
    //permite criar uma font a partir das font do windows
    //require('../fpdf/makefont/makefont.php');
    //MakeFont('../fpdf/arial.ttf','iso-8859-1', true);

    if (strpos($id_gr,'-') !== false) 
    {
	$grepdb = grepGetByGrNumber($id_gr);
    }else{
	$grepdb = grepGetById($id_gr);	
    }	
    //$grepdb = grepGetById($id_gr);
    
    $pdf = new FPDF('P','mm','A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('arial','',12);
    $pdf->Cell(0,10,$pdf->Image('../images/eleclerc.jpg',6,10,50),0 ,0 ,'L');
    //$pdf->Cell(0,10,utf8_decode('Guia de Reparação nº19') ,0 ,0 ,'R');
    if($grepdb['gr_number'] == "")
    {
    	$pdf->Cell(0,10,utf8_decode('Guia de Reparação nº' . $grepdb['id']) ,0 ,0 ,'R');
    }else{
    	$pdf->Cell(0,10,utf8_decode('Guia de Reparação nº' . $grepdb['gr_number']) ,0 ,0 ,'R');
    }
    $pdf->Ln(15);
    $pdf->Cell(155,10,utf8_decode($_SESSION['morada_leclerc_pdf']) ,0 ,0, 'L');
    $pdf->Cell(2,10,utf8_decode('Data: '. invertedatasemhora($grepdb['date_in'])) ,0 ,0, 'L');
    $pdf->Ln(6);
    $pdf->Cell(0,10,utf8_decode($_SESSION['cod_postal_leclerc_pdf']) ,0 ,0, 'L');
    $pdf->Ln(6);
    $pdf->Cell(0,10,utf8_decode('Tel: '.$_SESSION['telefone_leclerc_pdf'].' Fax: '.$_SESSION['fax_leclerc_pdf']) ,0 ,0, 'L');
    $pdf->Ln(6);
    $pdf->Cell(0,10,utf8_decode($_SESSION['mail_leclerc_pdf']) ,0 ,0, 'L');
    $pdf->Ln(6);
    $pdf->Cell(0,10,utf8_decode('NIF: '.$_SESSION['nif_leclerc_pdf']) ,0 ,0, 'L');

    //cliente
    $pdf->Ln(15);
    $pdf->SetFont('arial','',20);
    $pdf->Cell(0,10,utf8_decode('Cliente') ,0 ,0, 'L');
    $pdf->Ln(2);
    $pdf->Cell(0,10,utf8_decode('_______________________________________________') ,0 ,0, 'L');
    $pdf->Ln(10);
    $pdf->SetFont('arial','',12);
    $pdf->Cell(0,10,utf8_decode('Nome: '. $grepdb['cl_name']) ,0 ,0, 'L');
    $pdf->Ln(10);
    $pdf->Cell(0,10,utf8_decode('Morada: ' . $grepdb['cl_morada']) ,0 ,0, 'L');
    $pdf->Ln(10);
    //o multicell permite ser só uma linha ou caso acaba a linha cria logo uma por baixo
    $pdf->Cell(80,10,utf8_decode('Localidade: ' . $grepdb['cl_localidade']));
    $pdf->Cell(2,10,utf8_decode('Cod. Postal: ' . codpostalToForm($grepdb['cl_codpostal'])));
    $pdf->Ln(10);
    $pdf->Cell(0,10,utf8_decode('Contacto: ' . $grepdb['cl_telefone']) ,0 ,0, 'L');
    $pdf->Ln(15);
    $pdf->SetFont('arial','',20);

    //artigo
    $pdf->Cell(0,10,utf8_decode('Artigo') ,0 ,0, 'L');
    $pdf->Ln(2);
    $pdf->Cell(0,10,utf8_decode('_______________________________________________') ,0 ,0, 'L');
    $pdf->Ln(10);
    $pdf->SetFont('arial','',12);
    $pdf->Cell(80,10,utf8_decode('Marca: ' . $grepdb['art_marca']));
    $pdf->Cell(2,10,utf8_decode('Tipo: ' . $grepdb['art_type']));
    $pdf->ln(10);
    $pdf->Cell(80,10,utf8_decode('Modelo: ' . $grepdb['art_modelo']));
    $pdf->Cell(2,10,utf8_decode('EAN: ' . $grepdb['art_ean']));
    $pdf->ln(10);
    $pdf->MultiCell(0,10,utf8_decode('Nº Série: ' . $grepdb['art_numserie']));
    $pdf->MultiCell(0,10,utf8_decode('Anomalia: ' . $grepdb['art_anomalia']));
    $pdf->MultiCell(0,10,utf8_decode('Acessórios: ' . $grepdb['art_acessor']));
    $pdf->MultiCell(0,10,utf8_decode('Estética: ' . $grepdb['art_estetic']));
    //$image_photo = $pdf->Image('../images/euro.jpg',$pdf->GetX(), $pdf->GetY(), 'R');
    $pdf->Cell(80,10,utf8_decode('Talão: ' . $grepdb['art_numtalao']));
    $pdf->Cell(2,10,utf8_decode('Valor: ' . $grepdb['art_valor']));
    $pdf->Ln(10);
    if($grepdb['art_garantie'] == 1)
    {
        $pdf->Cell(80,10,utf8_decode('Garantia: Sim'));
        $pdf->Cell(2,10,utf8_decode('Data: ' . $grepdb['art_dategar']));
    }else{
        $pdf->Cell(0,10,utf8_decode('Garantia: Não') ,0 ,0, 'L');
    }
    $pdf->Ln(10);
    if($grepdb['art_orcamento'] == 1)
    {
        $pdf->Cell(0,10,utf8_decode('Orçamento: Sim') ,0 ,0, 'L');
    }else{
        $pdf->Cell(0,10,utf8_decode('Orçamento: Não') ,0 ,0, 'L');
    }
    $pdf->Ln(20);
    $pdf->Cell(20,10,utf8_decode('               '));
    $pdf->Cell(80,10,utf8_decode('Assinatura Cliente:'));
    $pdf->Cell(2,10,utf8_decode('Assinatura Funcionário:'));
    $pdf->Ln(20);
    $pdf->Cell(20,10,utf8_decode('               '));
    $pdf->Cell(80,10,utf8_decode('________________'));
    $pdf->Cell(2,10,utf8_decode('____________________'));
    
    return $pdf;
}
//verifique o estado do sms EZ4u
function verifysms($lastsmsid)
{
	$login = "FafeDis";
	$password = "34BB8CA7";
	$uri = "https://ziegen.dyndns.org/ez4usms/API/getSMSStatus.php?account=" . $login . "&licensekey=" . $password . "&smsID=" . $lastsmsid;
	
	$response = \Httpful\Request::get($uri)
	    ->expectsJson()
	    ->sendIt();
	    
	return $response;
	
}
//EgoiApi
function getreportegoi($lastsmsid)
{
	//ini_set('max_execution_time', 90);
	$params = array(
	'apikey'    => $_SESSION['apikey_sms'],
	'campaign'    => $lastsmsid);

	$client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
	$resultreport = $client->getReport($params);
	return $resultreport;
}
function getnumberexist($number_tel)
{
	$continue_while = true;
	$result_final = '';
	$start = 0;
	
	while($continue_while)
	{
		$params = array(
		'apikey'     => $_SESSION['apikey_sms'],
        	'listID'     => $_SESSION['list_sms'],
        	'limit'	     => '1000',
        	'start'      => $start,
        	'subscriber' => 'all_subscribers');
        	
        	//echo ' startnew: ' . $start;
        	
        	$client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
		$result = $client->subscriberData($params);
		
		//echo 'result: ' . print_r($result);
		
		if(!empty($result))
		{
			//echo '   d     ';
			//print_r($result['subscriber']);
			if(count($result['subscriber']) > 0)
			{
				foreach($result['subscriber'] as $arr)
				{
					if(in_array('351-'.$number_tel, $arr))
					{
						$result_final = $arr['UID'];
						$continue_while = false;
					}
				}	
			}else{
				$continue_while = false;
			}
		}else{
			$continue_while = false;
		}
		$start = $start + 999;
		unset($arr);
		unset($client);
		unset($result);
	}
	return $result_final;
	//return $stringtest;
}
//insere dados na tabela modif gr
function insertmodifgr($id, $text)
{
	$fields = array();
	$fields['gr_id'] = $id;
	$fields['us_id'] = $_SESSION['iduser'];
	$data2 = grepGetById($id);
	$fields['gr_number'] = dbString($data2['gr_number']);
	$fields['modif_date'] = dbString(date('Y-m-d H:i:s', time() - 3600));
	$fields['modif_text'] = dbString($text);
	modifgrInsert($fields);
	unset($fields);	
}

#enviar um mail diario aos chefes
function enviamaildiary($text)
{
	//require 'C:/xampp/htdocs/gr-guias/mail/class.phpmailer.php';
	require $_SESSION['locate_file_phpmailer'];
	//$emaildest = (string)$dest;
	$mail = new PHPmailer();
	$mail->IsSMTP();
	$mail->IsHTML(true);
	//$mail->Helo='auth.ptasp.com';
	$mail->Port= $_SESSION['port_envio_mail_send_daily'];
	$mail->Helo=$_SESSION['helo_envio_mail_send_daily'];
	//$mail->SMTPSecure='SSL';
	$mail->Username=$_SESSION['login_mail_send_daily'];
	$mail->Password=$_SESSION['password_mail_send_daily'];
	//$mail->Host='auth.ptasp.com';
	$mail->Host=$_SESSION['host_envio_mail_send_daily'];
	$mail->From=$_SESSION['from_mail_send_daily'];
	$mail->SetFrom=($_SESSION['setfrom_mail_send_daily']);
	//$mail->AddCC('bazarl@fafedis.pt');
        //$mail->AddCC('bazarl2@fafedis.pt');
        //$mail->AddCC('bazarp@fafedis.pt');
        //$mail->AddCC('bazarsav@fafedis.pt');
        //$mail->AddCC('informatica@fafedis.pt');
        foreach ($_SESSION['add_cc_mail_send_daily'] as $db => $value) {
		$mail->AddCC($value);		
	}
	#$mail->AddReplyTo('jo2012@pw-jre.heliohost.org', 'Administrator JO2012');	
	$mail->Subject='Reparações pendentes e estado sms';
	$mail->Body=$text;
	
        if($mail->Send()){
		$mail->ErrorInfo;
		$mail->SmtpClose();
		unset($mail);
		//$erro = true;
		#return 'Verifica o email introduzido (ex: meumail@mail.com)';
		return false;
	}
	else{	 
		//$erro = false;
		$mail->SmtpClose();
		unset($mail);
		#return 'Email enviado com sucesso';
		return true;
	}
	#$mail->SmtpClose();
	#unset($mail);
}

//diferença entre 2 datas em dias
function diff_data($data_recebida)
{
	#dá me a data atual em timestamp php (segundos)
	$data_atual = time();
	$diff = $data_recebida - $data_atual;
	#os 86400 corresponde ao numero de segundos num dia pq o timestamp dá me em segundos
	$numdias = floor($diff/86400);
	return $numdias;
}
//devolve o numero da guia para inserir na DB
function newnumbergr()
{
	$year = date('y', time() - 3600);
	//$year = "15";
	$lastnumber = gregGetLastNumberGr($year);
	if($year > 15)
	{
		if($lastnumber['gr_number'] == "")
		{
			//se devolde vazio quer dizer que não tem nada ou
			//é um novo ano
			return $year . "-0001";
		}else{
			//caso tem vou devolver ja o bom numero
			$oldnumber = explode("-", $lastnumber['gr_number']);
			$tempnumber = (int)$oldnumber[1] + 1;
			switch ($tempnumber) {
			    case $tempnumber < 10:
			        return $year . "-000" . $tempnumber;
			        break;
			    case $tempnumber < 100:
			        return $year . "-00" . $tempnumber;
			        break;
			    case $tempnumber < 1000:
			        return $year . "-0" . $tempnumber;
			        break;
			    case $tempnumber < 10000:
			        return $year . "-" .$tempnumber;
			        break;
			}
		}
	}else{
		return "";
	}	
}

?>