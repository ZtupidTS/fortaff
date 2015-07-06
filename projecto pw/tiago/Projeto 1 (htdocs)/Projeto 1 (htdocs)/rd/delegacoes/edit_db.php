<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/html_header.php', 1);
	include_once rootPath('includes/master_header.php', 1);
?>
<?php
	$fields = array();

	switch ($_POST['submeter']) {
		case "Guardar":
	
			if ($_POST['id_delegacao'] == "") {
				$_POST['id_delegacao'] = "-1";
			}
			
			$fields['id_delegacao'] = dbInteger($_POST['id_delegacao']);
			$fields['id_pais'] = dbString($_POST['id_pais']);
			$fields['nome_responsavel'] = dbString($_POST['nome_responsavel']);
			$fields['status'] = dbString($status);	
			$fields['login'] = dbString($_POST['user']);
			$fields['password'] = dbString($_POST['password']);
			
			if ($_POST['id_delegacao'] == "-1") {
				$fields['status'] = dbString("I");
				delegacaoInsert($fields);
			} else {
			
				$de = delegacaoGet($fields['id_delegacao']);
				
				if (!setIsEquivalent($_POST, $de)) {
					$fields['status'] = dbString("U");
					delegacaoUpdate($fields);
				}
			}
			break;
		  
		case "Remover":
		
			if ($_POST['status'] == 'I') {
				$status = 'X';
			} else {
				$status = 'D';
			}
			
			delegacaoUpdateStatus($_POST['id_delegacao'], $status);
			break;
			
		default:
		  //não faz nada e volta para index
	}
	header('location: index.php');
	
?>


<?php
	include_once rootPath('includes/master_footer.php', 1);
?>