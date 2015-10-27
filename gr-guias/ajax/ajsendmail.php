<?php
include '../includes/allpageaj.php';

if (strpos($_POST['id_gr'],'-') !== false) 
{
	$data = grepGetByGrNumber($_POST['id_gr']);
	$idguia = $data['id'];
}else{
	$data = grepGetById($_POST['id_gr']);	
	$idguia = $data['id'];
}

$data = reparadorGetById($_POST['rep_id']);
$body_mail = "";
if($_POST['tipo_id'] == "1")
{
	$body_mail = $_SESSION['corpo_levantamento_mail_send_supplier'];
	if($_SESSION['corpo_add_body'] != '')
	{
		$body_mail .= '<br/><br/>'.$_SESSION['corpo_add_body'];
	}
	
}else{
	$body_mail = $_SESSION['corpo_casa_mail_send_supplier'];
}

$mail = array();
if(strlen($data['rep_email']) > 0)
{
	$mail['mail1'] = $data['rep_email'];
}
if(strlen($data['rep_email2']) > 0)
{
	$mail['mail2'] = $data['rep_email2'];
}

if(count($mail) > 0)
{
	//aqui crio a minha variavel
	$sendmail = true;
	if(isset($_POST['anexo']))
	{
		$postfilename = $_POST['anexo'];
	    	$postfilename = str_ireplace("\\", "/", $postfilename);
	    	$file_new = explode("/", $postfilename);
	    	foreach ($file_new as $v)
	    	{
			if(strpos($v, ".") !== false)
			{
				
				$sendmail = enviamail($mail, $_POST['id_gr'], $body_mail, '../uploads/' . $v);
				unlink('../uploads/' . $v);
			}
		}
	}else{
		$sendmail = enviamail($mail, $_POST['id_gr'], $body_mail, '');
	}		
	
	if($sendmail)
	{
	    echo 'O email não foi possível enviar';
	}else{
	    //echo 'foi enviado o mail';
	    //agora aqui tenho de registar que foi feito a modifcação na tabela
	    if(isset($_POST['anexo']))
	    {
	    	insertmodifgr($idguia, "Guia enviada por mail ao reparador Nº" . $_POST['rep_id'] . " com anexo");
	    }else{
	    	insertmodifgr($idguia, "Guia enviada por mail ao reparador Nº" . $_POST['rep_id']);
	    }	    
	    //vou registar na tabela grep o numero do reparador.
	    $fields = array();
            $fields['id'] = $idguia;
	    $fields['rep_id'] = $_POST['rep_id'];
	    grepUpdate($fields);
	    unset($fields);
	    echo 'ok';
	}
}else{
	echo 'O reparador não tem mail';
}

closeDataBase();
?>