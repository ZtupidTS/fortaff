<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
	require_once rootPath('includes/mail/utils.phpmailer.php', 1);
	require_once rootPath('includes/mail/template.php', 1);
?>
<?php
	if(isset($_POST['confirm'])) {
		
		$fields['id_bilhete'] = dbInteger(-1);
		$fields['acontecimento'] = dbString($_POST['acontecimento']);
		$fields['id_entidade'] = dbInteger($_POST['id_entidade']);
		$fields['id_visitante'] = dbInteger($_POST['id_visitante']);
		$fields['tipo'] = dbString($_POST['tipo']);
		$fields['status'] = dbString('I');
		$fields['quantidade'] = dbInteger($_POST['quantidade']);
		$fields['preco'] = dbString($_POST['preco']);
		$fields['data'] = dbDateTime(new DateTime());
		$fields['data_compra'] = dbDateTime(mktime(0, 0, 0, 0, 0, 0));
		
		bilheteinsert($fields);
		$body = templatenewticket($fields['id_bilhete'], $current_user);
		$obj = createmailjo($current_user['email'], "bilheteira", $body);
		
		if ($obj->sendandclose()) {
			
		} else {
			bilhetedelete($fields['id_bilhete']);
			$erro = true;
		}
	}
	
	header('location: index.php');
	exit();
	
?>
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>