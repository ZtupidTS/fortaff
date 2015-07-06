<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
	include_once rootPath('includes/gijo/master_header.php', 1);
?>
<?php
	switch ($_POST['submeter'])
		{
		case "Guardar":
		  $status ="V";
		  
			if (($_POST['submeter'] !="Cancelar")){
				$fields = array();
				if ($_POST['id_evento'] == "") {
					$_POST['id_evento'] = "-1";
				}
				$fields['id_evento'] = dbInteger($_POST['id_evento']);
				$fields['id_local'] = dbInteger($_POST['id_local']);
				$fields['designacao'] = dbString($_POST['designacao']);
				$fields['data_hora'] = dbString($_POST['data_hora']);
				$fields['duracao'] = dbInteger($_POST['duracao']);
				$fields['preco_bilhete'] = dbInteger($_POST['preco_bilhete']);
				$fields['lugares_vendidos'] = dbInteger($_POST['lugares_vendidos']);
				$fields['lugares_reservados'] = dbInteger($_POST['lugares_reservados']);
				$fields['status'] = dbString($_POST['status']);
				$fields['descricao'] = dbString($_POST['descricao']);
				
				print_r($fields);
				if ($fields['id_evento'] == "-1") {
					eventosInsert($fields);
				} else {
					eventosUpdate($fields);
				}
				echo ocurrenceError();
			}		  
		  
		  break;
		case "Remover":
		  $status ="X";
			eventosUpdateStatus($_POST['id_evento'], $status);
		  break;
		default:
		  $status ="X";
		 }
		 

	 header('location: index.php');
	
?>
<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>