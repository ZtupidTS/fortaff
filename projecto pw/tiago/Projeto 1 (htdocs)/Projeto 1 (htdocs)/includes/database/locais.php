<?php

	// #### LOCAIS ###
	function localGet($id)
	{
		$t = getTable("locais", "id_local = " . dbInteger($id), "");
		return foreachRow($t);
	}
	
	function localGetAll()
	{
		return getTable("locais", "", "nome");
	}
	
	function localGetByFiltro($status_array, $reject_status_array)
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
		
		return getTable("locais", $where, "nome");
	}
	
	function localInsert($fields)
	{
		unset($fields['id_local']);
		$fields['id_local'] = insertRecord('locais', $fields, true);
	}
	
	function localUpdate($fields)
	{
		$id = $fields['id_local'];
		unset($fields['id_local']);
		updateRecord('locais', $fields, 'id_local = ' . dbInteger($id));
		$fields['id_local'] = $id;
	}
	
	function localUpdateStatus($id, $status)
	{
		$fields = array();
		$fields['status'] = dbString($status);
				
		updateRecord('locais', $fields, 'id_local = ' . dbInteger($id));
	}

?>