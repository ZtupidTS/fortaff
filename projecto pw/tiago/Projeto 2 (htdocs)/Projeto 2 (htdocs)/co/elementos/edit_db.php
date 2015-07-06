<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
	include_once rootPath('includes/gijo/master_header.php', 1);
	require_once rootPath('co/check_login.php', 1);
?>
<?php
	$fields = array();
	
	if (isset($_POST['save'])) { // ACTUALIZAR OU INSERIR
		
		if ($_POST['id_elemento'] == "") {
			$_POST['id_elemento'] = "-1";
		}
		$fields['id_elemento'] = dbInteger($_POST['id_elemento']);
		$fields['tipo'] = dbString($_POST['tipo']);
		$fields['id_delegacao'] = dbInteger($_POST['id_delegacao']);
		$fields['nome'] = dbString($_POST['nome']);
		$fields['data_nascimento'] = dbString($_POST['data_nascimento']);
		$fields['sexo'] = dbString($_POST['sexo']);
		$fields['peso'] = dbString($_POST['peso']);
		$fields['altura'] = dbString($_POST['altura']);
		$fields['sangue'] = dbString($_POST['sangue']);
		$fields['funcao'] = dbString($_POST['funcao']);
		$fields['habilitacoes'] = dbString($_POST['habilitacoes']);
		$fields['status'] = dbString("V");
		
		if ($_POST['id_elemento'] == "-1") {
			elementoInsert($fields);
		} else {
			elementoUpdate($fields);
		}
		
	} elseif (isset($_POST['delete'])) { // CANCELAR
	
		if (isset($_POST['id_elemento'])) {
			elementoUpdateStatus($_POST['id_elemento'], 'X');
		}
		
	} elseif (isset($_POST['accept'])) { // ACEITAR
	
		if (arrayContainsKeys($_POST, 'id_elemento', 'status')) {
			switch ($_POST['status']) {
				case 'U':
				case 'I':
				case 'R':
					elementoUpdateStatus($_POST['id_elemento'], 'V');
					break;
				case "D":
					elementoUpdateStatus($_POST['id_elemento'], 'X');
					break;
			}
		}
	
	} else if (isset($_POST['reject'])) { // REJEITAR
	
		if (arrayContainsKeys($_POST, 'id_elemento', 'status')) {
			switch ($_POST['status']) {
				case 'U':
				case 'I':
				case 'D':
					elementoUpdateStatus($_POST['id_elemento'], 'R');
					break;
			}
		}
		
	} else if (isset($_POST['cancel'])) { // SAIR
		//não faz nada e volta para index
	}
	
	header('location: index.php');
	
?>
<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>