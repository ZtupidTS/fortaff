<?php
	require_once '/includes/utils.php';
	include_once rootPath('includes/html_header.php', 1);
	include_once rootPath('includes/master_header.php', 1);
?>
<?php
	if(isset($_POST['votar'])) {
	
		$fields['id_evento'] = dbInteger($_POST['id_evento']);
		$fields['apreciacao'] = dbInteger($_POST['apreciacao']);
		$fields['nome_utilizador'] = dbString($_POST['nome_utilizador']);

		apreciacaoInsert($fields);
		header('location: index.php');
	}
?>
<?php
	include_once rootPath('includes/master_footer.php', 1);
?>