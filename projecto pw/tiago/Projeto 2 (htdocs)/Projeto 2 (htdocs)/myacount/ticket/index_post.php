<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
	require_once rootPath('includes/mail/utils.phpmailer.php', 1);
	require_once rootPath('includes/mail/template.php', 1);
?>
<?php
	$fields = array();
	
	if (isset($_POST['pagar'])) {
	
	} else if (isset($_POST['reconfirm_x'])) {
		
		$body = templateNewTicket($_POST['id_bilhete'], $current_user);
		echo $current_user['email'];
		
		$obj = createMailJO($current_user['email'], "Bilheteira", $body);
		
		if ($obj->SendAndClose()) {
			$_SESSION['returnMsg']["code"] = "information";
			$_SESSION['returnMsg']["msg"] = "Email de confirmação enviado com sucesso.";
		} else {
			$_SESSION['returnMsg']["code"] = "error";
			$_SESSION['returnMsg']["msg"] = "Não foi possível enviar o email de confirmação.";
		}
		
	} else if (isset($_POST['cancelar_x'])) {
		bilheteUpdateStatus($_POST['id_bilhete'], 'X');
		$_SESSION['returnMsg']["code"] = "information";
		$_SESSION['returnMsg']["msg"] = "Bilhete cancelado com sucesso.";
	}
	
	header("location: index.php");
	exit();
?>
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>