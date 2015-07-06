<?php

	// #### VISITANTES ###
	function visitanteGet($id)
	{
		$t = getTable("visitantes", "id_visitante = " . dbInteger($id), "");
		return foreachRow($t);
	}
	
	function visitanteGetByEmail($email)
	{
		$t = getTable("visitantes", "email = " . dbString($email), "");
		return foreachRow($t);
	}
	
	function visitanteSetActive($id)
	{
		$n = getTableCount("visitantes", "id_visitante = " . dbInteger($id), "");
		
		if ($n == 0) {
			return false;
		} else {
			visitanteUpdateStatus($id, "A");
			return true;
		}
	}
	
	function visitanteGetByFiltro($id_visitante, $status_array, $reject_status_array)
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
		
		return getTable('visitantes', $where, 'nome');
	}
	
	function visitanteGetAll()
	{
		return getTable("visitantes", "", "");
	}
	
	function visitanteInsert(&$fields)
	{
		unset($fields['id_visitante']);
		$fields['id_visitante'] = insertRecord("visitantes", $fields, true);
	}
	
	function visitanteUpdate($fields)
	{
		$where = "id_visitante = " . $fields['id_visitante'];
		unset($fields['id_visitante']);
		
		updateRecord("visitantes", $fields, $where);
	}
	
	function visitanteUpdateStatus($id, $status)
	{
		$fields = array();
		$fields['status'] = dbString($status);
				
		updateRecord('visitantes', $fields, 'id_visitante = ' . dbInteger($id));
	}
	
	function visitanteDelete($id)
	{
		deleteRecord("visitantes", "id_visitante = " . dbInteger($id));
	}
	
?>