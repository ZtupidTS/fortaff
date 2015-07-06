<?php

	// #### DELEGACOES ###
	function delegacaoGet($id)
	{
		$t = getTable("delegacoes_total", "id_delegacao = $id", "");
		return foreachRow($t);
	}
	
	function delegacaoGetByUser($user)
	{
		$t = getTable("delegacoes_total", "login = " . dbString($user), "");
		return foreachRow($t);
	}
	
	function delegacaoGetByFiltro($id_delegacao, $status_array, $reject_status_array)
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
		
		return getTable('delegacoes_total', $where, 'pais_nome');
	}
	
	function delegacaoGetAll()
	{
		return getTable("delegacoes_total", "", "");
	}
	
	function delegacaoInsert($fields)
	{
		unset($fields['id_delegacao']);
		$fields['id_delegacao'] = insertRecord("delegacoes", $fields, true);
	}
	
	function delegacaoUpdate($fields)
	{
		$where = "id_delegacao = " . dbString($fields['id_delegacao']);
		unset($fields['id_delegacao']);
		
		updateRecord("delegacoes", $fields, $where);
	}
	
	function delegacaoUpdateStatus($id, $status)
	{
		$fields = array();
		$fields['status'] = dbString($status);
				
		updateRecord('delegacoes', $fields, 'id_delegacao = ' . dbInteger($id));
	}
	
	function delegacaoDelete($id)
	{
		deleteRecord("delegacoes", 'id_delegacao = ' . dbInteger($id));
	}

?>