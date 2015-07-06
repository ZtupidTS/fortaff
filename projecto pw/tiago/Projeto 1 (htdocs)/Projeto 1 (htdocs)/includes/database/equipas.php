<?php

	// #### EQUIPAS ####
	function equipaGetAll($ids = null)
	{
		$where = '';
		if ($ids !== null) {
			$where = 'id_equipa IN (' . join(', ', $ids) . ')';
		}
		
		return getTable('equipas_total', $where, 'pais_nome, modalidade_nome');
	}
	
	function equipaGetByFiltro($id_delegacao, $status_array, $reject_status_array)
	{
		$where = '';
		
		if ($id_delegacao !== -1) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "id_delegacao = " . dbInteger($id_delegacao);
		}
		
		if ($status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status IN ('" . join("', '", $status_array) . "')";
		}
		
		if ($reject_status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status NOT IN ('" . join("', '", $reject_status_array) . "')";
		}
		
		return getTable('equipas_total', $where, 'pais_nome, modalidade_nome');
	}
	
	function equipaGet($id)
	{
		$t = getTable('equipas_total', 'id_equipa = ' . dbInteger($id), '');
		return foreachRow($t);
	}
	
	function equipaInsert(&$fields)
	{
		unset($fields['id_equipa']);
		$fields['id_equipa'] = insertRecord('equipas', $fields, true);
	}
		
	function equipaUpdate($fields)
	{
		$id = $fields['id_equipa'];
		unset($fields['id_equipa']);
		updateRecord('equipas', $fields, 'id_equipa = ' . dbInteger($id));
		$fields['id_equipa'] = $id;
	}
	
	function equipaUpdateStatus($id, $status)
	{
		$fields = array();
		$fields['status'] = dbString($status);
		
		updateRecord('equipas', $fields, 'id_equipa = ' . dbInteger($id));
		
		if ($status == 'X') {
			$fields = array();
			$fields['status'] = dbString('X');		
			updateRecord('elementos_equipas', $fields, 'id_equipa = ' . dbInteger($id));
		}
		
	}
	
	function equipaDelete($id)
	{
		deleteRecord('equipas', "id_equipa = " . dbInteger($id));
	}

?>