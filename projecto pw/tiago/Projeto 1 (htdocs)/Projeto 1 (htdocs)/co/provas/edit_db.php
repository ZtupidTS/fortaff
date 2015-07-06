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
	
		if ($_POST['id_prova'] == "") {
			$_POST['id_prova'] = "-1";
		}
		
		$fields['id_prova'] = dbInteger($_POST['id_prova']);
		$fields['id_local'] = dbInteger($_POST['id_local']);
		$fields['id_modalidade'] = dbInteger($_POST['id_modalidade']);
		$fields['status'] = dbString("V");
		$fields['data_hora'] = dbString($_POST['data_hora']);
		$fields['duracao'] = dbInteger($_POST['duracao']);
		$fields['nome_juiz'] = dbString($_POST['nome_juiz']);
		$fields['preco_bilhete'] = dbInteger($_POST['preco_bilhete']);
		$fields['lugares_reservados'] = dbInteger($_POST['lugares_reservados']);
		$fields['lugares_vendidos'] = dbInteger($_POST['lugares_vendidos']);
		
		if ($_POST['id_prova'] == '-1') {
			provaInsert($fields);
			$redirectToEquipa = true; //salta para a nova prova
		} else {
			provaUpdate($fields);
		}
		
	} elseif (isset($_POST['delete'])) { // REMOVER
	
		if (isset($_POST['id_prova'])) {
			provaUpdateStatus($_POST['id_prova'], 'X');
		}
		
	} elseif (isset($_POST['inscrever'])) { // INSCREVER
		
		$fields = array();
		$fields['id_classificacao'] = dbInteger(-1);
		$fields['id_prova'] = $_POST['id_prova'];
		$fields['id_entidade'] = $_POST['id_entidade'];
		$fields['classificacao'] = 99999;
		$fields['status'] = dbString('V');
		
		provaClassificacaoInsert($fields);
		$redirectToEquipa = true;
		
	} elseif (isset($_POST['desinscrever'])) { // DESINSCREVER
		
		$fields['id_prova'] = $_POST['id_prova'];
		provaClassificacaoUpdateStatus($_POST['id_classificacao'], 'X');
		$redirectToEquipa = true;
		
	} elseif (isset($_POST['aceitarInscricao'])) { // ACEITAR INSCRICAO
		
		$fields['id_prova'] = $_POST['id_prova'];
		$redirectToEquipa = true;
		
		switch ($_POST['status']) {
			case 'U':
			case 'I':
			case 'R':
				provaClassificacaoUpdateStatus($_POST['id_classificacao'], 'V');
				break;
			case "D":
				provaClassificacaoUpdateStatus($_POST['id_classificacao'], 'X');
				break;
		}
	
	} elseif (isset($_POST['rejeitarInscricao'])) { // REJEITAR INSCRICAO
		
		$fields['id_prova'] = $_POST['id_prova'];
		$redirectToEquipa = true;
		
		provaClassificacaoUpdateStatus($_POST['id_classificacao'], 'R');
		
	} elseif (isset($_POST['cancel'])) { // VOLTAR
		//não faz nada e volta para index
	}
		
	if ($redirectToEquipa) {
		$_SESSION['prova_post'] = array('id_prova' => $fields['id_prova']);
		header('location: edit.php');
	} else {
		header('location: index.php');
	}
?>
<?php
	include_once rootPath('includes/master_footer.php', 1);
?>