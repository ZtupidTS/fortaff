<?php
	include '../../includes/utils.php';
	include rootPath('includes/html_header.php', 1);
	include '../../includes/master_header.php';
	include rootPath('co/check_login.php', 1);
?>
<?php
	$fields = array();
	
	if (isset($_POST['save'])) { // ACTUALIZAR OU INSERIR
	
		if ($_POST['id_modalidade'] == "") {
			$_POST['id_modalidade'] = "-1";
		}
		$fields['id_modalidade'] = dbInteger($_POST['id_modalidade']);
		$fields['nome'] = dbString($_POST['nome']);
		$fields['tipo'] = dbString($_POST['tipo']);
		$fields['status'] = dbString('V');
		
		if ($_POST['id_modalidade'] == "-1") {
			modalidadeInsert($fields);
		} else {
			modalidadeUpdate($fields);
		}
		
	} elseif (isset($_POST['delete'])) { // CANCELAR
	
		$fields = array();
		if (isset($_POST['id_modalidade'])) {
			modalidadeUpdateStatus($_POST['id_modalidade'], 'X');
		}
		
	} elseif (isset($_POST['cancel'])) { // CANCELAR
		// não faz nada e volta para traz
	}
	
	header('location: index.php');
?>
<?php
	include_once rootPath('includes/master_footer.php', 1);
?>