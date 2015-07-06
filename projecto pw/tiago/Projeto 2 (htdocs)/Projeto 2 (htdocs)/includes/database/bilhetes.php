<?php
	
	function bilheteGet($id)
	{
		$t = getTable("bilhetes", "id_bilhete = " . dbInteger($id), "");
		return foreachRow($t);
	}
	
	function bilheteGetByFiltro($id_visitante, $status_array, $reject_status_array)
	{
		$where = '';
		
		if ($id_visitante !== -1) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "id_visitante = " . dbInteger($id_visitante);
		}
		
		if ($status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status IN ('" . join("', '", $status_array) . "')";
		}
		
		if ($reject_status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status NOT IN ('" . join("', '", $reject_status_array) . "')";
		}
		
		return getTable('bilhetes_total', $where, 'acontecimento_data, id_entidade, data');
	}
	
	function bilheteInsert(&$fields)
	{
		unset($fields['id_bilhete']);
		$fields['id_bilhete'] = insertRecord('bilhetes', $fields, true);
	}
	
	function bilheteUpdate($fields)
	{
		$id = $fields['id_bilhete'];
		unset($fields['id_bilhete']);
		updateRecord('bilhetes', $fields, 'id_bilhete = ' . dbInteger($id));
		$fields['id_bilhete'] = $id;
	}
	
	function bilheteUpdateStatus($id, $status)
	{
		$fields = array();
		$fields['status'] = dbString($status);
				
		updateRecord('bilhetes', $fields, 'id_bilhete = ' . dbInteger($id));
	}
	
?>