<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/html_header.php', 1);
	include_once rootPath('includes/master_header.php', 1);
	require_once rootPath('co/check_login.php', 1);
?>
<?php
	$fields = array();
	$redirectToEquipa = false;
	
	if (isset($_POST['save'])) { // ACTUALIZAR OU INSERIR
	
		if ($_POST['id_equipa'] == "") {
			$_POST['id_equipa'] = "-1";
		}
		
		$fields['id_equipa'] = dbInteger($_POST['id_equipa']);
		$fields['id_delegacao'] = dbInteger($_POST['id_delegacao']);
		$fields['id_modalidade'] = dbInteger($_POST['id_modalidade']);
		$fields['status'] = dbString("V");
		
		if ($_POST['id_equipa'] == "-1") {
			equipaInsert($fields);
			$redirectToEquipa = true; //salta para a nova equipa
		} else {
			equipaUpdate($fields);
		}
		
	} elseif (isset($_POST['delete'])) { // CANCELAR
	
		if (isset($_POST['id_equipa'])) {
			equipaUpdateStatus($_POST['id_equipa'], 'X');
		}
		
	} elseif (isset($_POST['accept'])) { // ACEITAR
	
		if (arrayContainsKeys($_POST, 'id_equipa', 'status')) {
			switch ($_POST['status']) {
				case 'U':
				case 'I':
				case 'R':
					equipaUpdateStatus($_POST['id_equipa'], 'V');
					break;
				case "D":
					equipaUpdateStatus($_POST['id_equipa'], 'X');
					break;
			}
		}
	
	} else if (isset($_POST['reject'])) { // REJEITAR
	
		if (arrayContainsKeys($_POST, 'id_equipa', 'status')) {
			switch ($_POST['status']) {
				case 'U':
				case 'I':
				case 'D':
					equipaUpdateStatus($_POST['id_equipa'], 'R');
					break;
			}
		}
		
	} elseif (isset($_POST['inscrever'])) { // INSCREVER
		
		$fields = array();
		$fields['id_elemento_equipa'] = dbInteger(-1);
		$fields['id_equipa'] = $_POST['id_equipa'];
		$fields['id_elemento'] = $_POST['id_elemento'];
		$fields['status'] = dbString('V');
		
		elementoEquipaInsert($fields);
		$redirectToEquipa = true;
	
	} elseif (isset($_POST['desinscrever'])) { // DESINSCREVER
		
		$fields['id_equipa'] = $_POST['id_equipa'];
		elementoEquipaUpdateStatus($_POST['id_elemento_equipa'], 'X');
		$redirectToEquipa = true;
		
	} elseif (isset($_POST['aceitarInscricao'])) { // ACEITAR INSCRICAO
		
		$fields['id_equipa'] = $_POST['id_equipa'];
		$redirectToEquipa = true;
		
		switch ($_POST['status']) {
			case 'U':
			case 'I':
			case 'R':
				elementoEquipaUpdateStatus($_POST['id_elemento_equipa'], 'V');
				break;
			case "D":
				elementoEquipaUpdateStatus($_POST['id_elemento_equipa'], 'X');
				break;
		}
	
	} elseif (isset($_POST['rejeitarInscricao'])) { // REJEITAR INSCRICAO
		
		$fields['id_equipa'] = $_POST['id_equipa'];
		$redirectToEquipa = true;
		
		elementoEquipaUpdateStatus($_POST['id_elemento_equipa'], 'R');
		
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
	include_once rootPath('includes/master_footer.php', 1);
?>