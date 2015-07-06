<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
	include_once rootPath('includes/gijo/master_header.php', 1);
?>
<?php
	$fields = array();
	
	switch ($_POST['submeter']) {
		case "Aceitar":
		
			if (arrayContainsKeys($_POST, 'id_delegacao', 'status')) {
				switch ($_POST['status']) {
					case 'U':
					case 'I':
					case 'R':
						delegacaoUpdateStatus($_POST['id_delegacao'], 'V');
						break;
					case "D":
						delegacaoUpdateStatus($_POST['id_delegacao'], 'X');
						break;
				}
			}
			break;
		  
		case "Rejeitar":
			
			if (arrayContainsKeys($_POST, 'id_delegacao', 'status')) {
				switch ($_POST['status']) {
					case 'U':
					case 'I':
					case 'D':
						delegacaoUpdateStatus($_POST['id_delegacao'], 'R');
						break;
				}
			}
			break;
		  
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
			$fields['status'] = dbString('V');
			
			if ($fields['id_delegacao'] == "-1") {
				delegacaoInsert($fields);
			} else {
				delegacaoUpdate($fields);
			}
		    break;
			
		case "Remover":
		  
			if (isset($_POST['id_delegacao'])) {
				delegacaoUpdateStatus($_POST['id_delegacao'], 'X');
			}
			break;
		  
		default:
			//não faz nada e volta para index
	}
	header('location: index.php');
?>


<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>