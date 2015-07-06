<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/html_header.php', 1);
	include_once rootPath('includes/master_header.php', 1);
	require_once rootPath('co/check_login.php', 1);
?>
<?php
	$fields = array();
	
	if ($jo_Date->totaldays < joLimitChangeData()) {
		echo $_SESSION['error_msg'] = 'Ops!!! O tempo previsto para a inscrição de elementos e equipas expirou.';
		header('location: index.php');
		exit();
	}
	
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
		
		if ($_POST['id_elemento'] == "-1") {
			$fields['status'] = dbString("I");
			elementoInsert($fields);
		} else {
			
			$el = elementoGet($fields['id_elemento']);
			
			if (!setIsEquivalent($_POST, $el)) {
				
				if ($_POST['status'] == 'I') {
					$fields['status'] = dbString("I");
				} else {
					$fields['status'] = dbString("U");
				}
				
				elementoUpdate($fields);
			}
		}
		
	} elseif (isset($_POST['delete'])) { // CANCELAR
	
		if (isset($_POST['id_elemento'])) {
		
			if ($_POST['status'] == 'I') {
				$status = 'X';
			} else {
				$status = 'D';
			}
		
			elementoUpdateStatus($_POST['id_elemento'], $status);
		}
		
	} else if (isset($_POST['cancel'])) { // SAIR
		//não faz nada e volta para index
	}
	
	header('location: index.php');
	
?>
<?php
	include_once rootPath('includes/master_footer.php', 1);
?>