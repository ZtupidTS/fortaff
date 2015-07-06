<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/html_header.php', 1);
	include_once rootPath('includes/master_header.php', 1);
	require_once rootPath('co/check_login.php', 1);
?>
<?php
	$fields = array();
	$redirectToEquipa = false;
	
	if (isset($_GET['save'])) { // ACTUALIZAR OU INSERIR
	
		if ($_GET['id_equipa'] == "") {
			$_GET['id_equipa'] = "-1";
		}
		
		$fields['id_equipa'] = dbInteger($_GET['id_equipa']);
		$fields['id_delegacao'] = dbInteger($_GET['id_delegacao']);
		$fields['id_modalidade'] = dbInteger($_GET['id_modalidade']);
		$fields['status'] = dbString("V");
		
		if ($_GET['id_equipa'] == "-1") {
			equipaInsert($fields);
			$redirectToEquipa = true; //salta para a nova equipa
		} else {
			equipaUpdate($fields);
		}
		
	} elseif (isset($_GET['delete'])) { // CANCELAR
	
		if (isset($_GET['id_equipa'])) {
			equipaUpdateStatus($_GET['id_equipa'], 'X');
		}
		
	} elseif (isset($_GET['accept'])) { // ACEITAR
	
		if (arrayContainsKeys($_GET, 'id_equipa', 'status')) {
			switch ($_GET['status']) {
				case 'U':
				case 'I':
				case 'R':
					equipaUpdateStatus($_GET['id_equipa'], 'V');
					break;
				case "D":
					equipaUpdateStatus($_GET['id_equipa'], 'X');
					break;
			}
		}
	
	} else if (isset($_GET['reject'])) { // REJEITAR
	
		if (arrayContainsKeys($_GET, 'id_equipa', 'status')) {
			switch ($_GET['status']) {
				case 'U':
				case 'I':
				case 'D':
					equipaUpdateStatus($_GET['id_equipa'], 'R');
					break;
			}
		}
		
	} elseif (isset($_GET['inscrever'])) { // INSCREVER
		
		$fields = array();
		$fields['id_elemento_equipa'] = dbInteger(-1);
		$fields['id_equipa'] = $_GET['id_equipa'];
		$fields['id_elemento'] = $_GET['id_elemento'];
		$fields['status'] = dbString('V');
		
		elementoEquipaInsert($fields);
		$redirectToEquipa = true;
	
	} elseif (isset($_GET['desinscrever'])) { // DESINSCREVER
		
		$fields['id_equipa'] = $_GET['id_equipa'];
		elementoEquipaUpdateStatus($_GET['id_elemento_equipa'], 'X');
		$redirectToEquipa = true;
		
	} elseif (isset($_GET['aceitarInscricao'])) { // ACEITAR INSCRICAO
		
		$fields['id_equipa'] = $_GET['id_equipa'];
		$redirectToEquipa = true;
		
		switch ($_GET['status']) {
			case 'U':
			case 'I':
			case 'R':
				elementoEquipaUpdateStatus($_GET['id_elemento_equipa'], 'V');
				break;
			case "D":
				elementoEquipaUpdateStatus($_GET['id_elemento_equipa'], 'X');
				break;
		}
	
	} elseif (isset($_GET['rejeitarInscricao'])) { // REJEITAR INSCRICAO
		
		$fields['id_equipa'] = $_GET['id_equipa'];
		$redirectToEquipa = true;
		
		elementoEquipaUpdateStatus($_GET['id_elemento_equipa'], 'R');
		
	} elseif (isset($_GET['cancel'])) { // VOLTAR
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