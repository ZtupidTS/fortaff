<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
?>
<?php
	$fields = array();
	
	if(isset($_POST['votar'])) {
	
		$fields['id_evento_classificacao'] = dbInteger(-1);
		$fields['id_evento'] = dbInteger($_POST['id_evento']);
		$fields['apreciacao'] = dbInteger($_POST['apreciacao']);
		$fields['id_visitante'] = dbInteger($_POST['id_visitante']);

		apreciacaoInsert($fields);
		
	}
	
	header('location: index.php');
	exit();
	
?>
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>