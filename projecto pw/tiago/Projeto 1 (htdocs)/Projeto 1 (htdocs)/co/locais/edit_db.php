<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/html_header.php', 1);
	include_once rootPath('includes/master_header.php', 1);
	require_once rootPath('co/check_login.php', 1);
?>
<?php
	$fields = array();
	
	if (isset($_POST['save'])) { // ACTUALIZAR OU INSERIR
		
		if ($_POST['id_local'] == "") {
			$_POST['id_local'] = "-1";
		}
		$fields['id_local'] = dbInteger($_POST['id_local']);
		$fields['nome'] = dbString($_POST['nome']);
		$fields['descricao'] = dbString($_POST['descricao']);
		$fields['num_lugares'] = dbInteger($_POST['num_lugares']);
		$fields['status'] = dbString('V');
		
		if ($fields['id_local'] == "-1") {
			localInsert($fields);
		} else {
			localUpdate($fields);
		}

	} elseif (isset($_POST['delete'])) { // CANCELAR
	
		$fields = array();
		if (isset($_POST['id_local'])) {
			localUpdateStatus($_POST['id_local'], 'X');
		}
		
	} elseif (isset($_POST['cancel'])) { // CANCELAR
		// não faz nada e volta para traz
	}
	header('location: index.php');
?>
<?php
	include_once rootPath('includes/master_footer.php', 1);
?>