<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
	include_once rootPath('includes/gijo/master_header.php', 1);
	require_once rootPath('rd/check_login.php', 1);
?>
<?php
	$fields = array();
	$redirectToEquipa = false;
	
	if ($jo_Date->totaldays < joLimitChangeData()) {
		echo $_SESSION['error_msg'] = 'Ops!!! O tempo previsto para a inscrição de elementos e equipas expirou.';
		header('location: index.php');
		exit();
	}
	
	if (isset($_POST['save'])) { // ACTUALIZAR OU INSERIR
	
		if ($_POST['id_equipa'] == "") {
			$_POST['id_equipa'] = "-1";
		}
		
		$fields['id_equipa'] = dbInteger($_POST['id_equipa']);
		$fields['id_delegacao'] = dbInteger($_POST['id_delegacao']);
		$fields['id_modalidade'] = dbInteger($_POST['id_modalidade']);
		
		if ($_POST['id_equipa'] == "-1") {
			$fields['status'] = dbString("I");
			equipaInsert($fields);
			$redirectToEquipa = true; //salta para a nova equipa
		} else {
		
			$eq = equipaGet($fields['id_equipa']);
			
			if (!setIsEquivalent($_POST, $eq)) {
				$fields['status'] = dbString("U");
				equipaUpdate($fields);
			}
		}
		
	} elseif (isset($_POST['delete'])) { // CANCELAR
	
		if (isset($_POST['id_equipa'])) {
			
			if ($_POST['status'] == 'I') {
				$status = 'X';
			} else {
				$status = 'D';
			}
			
			equipaUpdateStatus($_POST['id_equipa'], $status);
		}
		
	} elseif (isset($_POST['inscrever'])) { // INSCREVER
		
		$fields = array();
		$fields['id_elemento_equipa'] = dbInteger(-1);
		$fields['id_equipa'] = $_POST['id_equipa'];
		$fields['id_elemento'] = $_POST['id_elemento'];
		$fields['status'] = dbString('I');
		
		elementoEquipaInsert($fields);
		$redirectToEquipa = true;
	
	} elseif (isset($_POST['desinscrever'])) { // DESINSCREVER
		
		$fields['id_equipa'] = $_POST['id_equipa'];
		if (in_array($_POST['status'], array('I', 'R'))) {
			$status = 'X';
		} else {
			$status = 'D';
		}
		
		elementoEquipaUpdateStatus($_POST['id_elemento_equipa'], $status);
		$redirectToEquipa = true;
		
	} elseif (isset($_POST['cancel'])) { // VOLTAR
		//não faz nada e volta para index
	}
		
	if ($redirectToEquipa) {
		$_SESSION['equipa_post'] = array('id_equipa' => $fields['id_equipa']);
		header('location: edit.php');
	} else {
		header('location: index.php');
	}
?>
<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>