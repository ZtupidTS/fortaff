<?php

	// #### MODALIDADES ####
	function modalidadeGet($id)
	{
		$t = getTable('modalidades', 'id_modalidade = ' . dbInteger($id), '');
		return foreachRow($t);
	}
	
	function modalidadeGetAll($ids = null)
	{
		$where = '';
		if ($ids !== null) {
			$where = 'id_modalidade IN (' . join(', ', $ids) . ')';
		}
		
		return getTable('modalidades', $where, 'nome');
	}
	
	function modalidadeNaoExistente($id_delegacao)
	{
		$t = getTable('modalidades_nao_existentes', 'id_delegacao = ' . dbInteger($id_delegacao), '');
		
		$ids = array();
		while ($row = foreachRow($t)) {
			$ids[] = $row['id_modalidade'];
		}
		
		if (count($ids) == 0) {
			$ids[] = -1;
		} 
		
		return modalidadeGetAll($ids);
	}
	
	function modalidadeGetByFiltro($status_array, $reject_status_array)
	{
		$where = '';
		
		if ($status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status IN ('" . join("', '", $status_array) . "')";
		}
		
		if ($reject_status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status NOT IN ('" . join("', '", $reject_status_array) . "')";
		}
		
		return getTable('modalidades', $where, 'nome');
	}
	
	
		function modalidadeGetByFiltro2($id_modalidade, $status_array, $reject_status_array)
	{
		$where = '';
		
		if ($id_modalidade !== -1) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "id_modalidade = " . dbInteger($id_modalidade);
		}
				
		if ($status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status IN ('" . join("', '", $status_array) . "')";
		}
		
		if ($reject_status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status NOT IN ('" . join("', '", $reject_status_array) . "')";
		}
		
		return getTable('modalidades', $where, 'nome');
	}
	
	function modalidadeInsert($fields)
	{
		unset($fields['id_modalidade']);
		$fields['id_modalidade'] = insertRecord('modalidades', $fields, true);
	}
		
	function modalidadeUpdate($fields)
	{
		$id = $fields['id_modalidade'];
		unset($fields['id_modalidade']);
		updateRecord('modalidades', $fields, 'id_modalidade = ' . dbInteger($id));
		$fields['id_modalidade'] = $id;
	}
	
	function modalidadeUpdateStatus($id, $status)
	{
		$fields = array();
		$fields['status'] = dbString($status);
				
		updateRecord('modalidades', $fields, 'id_modalidade = ' . dbInteger($id));
	}
	
	function modalidadeDelete($id)
	{
		deleteRecord('modalidades', "id_modalidade = " . dbInteger($id));
	}

?>