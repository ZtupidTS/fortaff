<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
	include_once rootPath('includes/gijo/master_header.php', 1);
	require_once rootPath('rd/check_login.php', 1);
?>
<?php
	$fields = array();
	$redirectToEquipa = false;
	
	if (isset($_POST['id_prova'])) {
		
		$c = provaGet($_POST['id_prova']);
		$proof_date = new TimeStamp(new DateTime("now"), date_create($c['data_hora']));
		
		if ($proof_date->totaldays < joLimitChangeProof()) {
			$_SESSION['error_msg'] = 'Ops!!! O tempo previsto para a inscrição de elementos em provas expirou.';
			header('location: index.php');
			exit(0);
		}
	}
	
	if (isset($_POST['inscrever'])) { // INSCREVER

		$fields['id_classificacao'] = dbInteger(-1);
		$fields['id_prova'] = $_POST['id_prova'];
		$fields['id_entidade'] = $_POST['id_entidade'];
		$fields['classificacao'] = 99999;
		$fields['status'] = dbString('I');
		
		provaClassificacaoInsert($fields);
		$redirectToEquipa = true;
		
	} elseif (isset($_POST['desinscrever'])) { // DESINSCREVER
		
		$fields['id_prova'] = $_POST['id_prova'];
		if (in_array($_POST['status'], array('I', 'R'))) {
			$status = 'X';
		} else {
			$status = 'D';
		}
		
		provaClassificacaoUpdateStatus($_POST['id_classificacao'], $status);
		$redirectToEquipa = true;
		
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
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>