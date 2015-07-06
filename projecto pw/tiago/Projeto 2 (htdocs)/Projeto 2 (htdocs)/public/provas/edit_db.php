<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
	require_once rootPath('includes/mail/utils.phpmailer.php', 1);
	require_once rootPath('includes/mail/template.php', 1
?>
<?php
	// $fields = array();
	// $redirectToEquipa = false;
	
	// if(isset($_POST['comprar']) || isset($_POST['reservar'])) {
	
		// $tipo = isset($_POST['comprar']) ? 'C' : 'R';
		// $fields['id_bilhete'] = dbInteger(-1);
		// $fields['acontecimento'] = dbString('P');
		// $fields['id_entidade'] = dbInteger($_POST['id_prova']);
		// $fields['id_visitante'] = dbInteger($_POST['id_visitante']);
		// $fields['tipo'] = dbString($tipo);
		// $fields['status'] = dbString('I');
	
			// $fields['quantidade'] = dbInteger($_POST['quantidade']);
		// $fields['preco'] = dbString($_POST['preco_bilhete']);
		// $fields['data'] = dbDateTime(new DateTime());
		// $fields['data_compra'] = dbDateTime(mktime(0, 0, 0, 0, 0, 0));
		
		// bilheteInsert($fields);
		// $body = templateNewTicket($fields['id_bilhete'], $current_user);
		// $obj = createMailJO($current_user['email'], "Bilheteira", $body);
		
		// if ($obj->SendAndClose()) {
			
		// } else {
			// bilheteDelete($fields['id_bilhete']);
			// $erro = true;
		// }
	// }
	
	header('location: index.php');
	exit();
	
?>
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>