<?php

	// #### EVENTOS ###
	function eventosGet($id)
	{
		$t = getTable("eventos_total", "id_evento = $id", "");
		return foreachRow($t);
	}

	function eventosGetAll()
	{
		return getTable("eventos_total", "", "");
	}

	function eventosGetByFiltro($status_array, $reject_status_array)
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
		
		return getTable("eventos_total", $where, "id_evento");
	}
	
	function eventosInsert($fields)
	{
		unset($fields['id_evento']);
		$fields['id_evento'] = insertRecord('eventos', $fields, true);
	}
	
	function eventosUpdate($fields)
	{
		$id = $fields['id_evento'];
		unset($fields['id_evento']);
		updateRecord('eventos', $fields, 'id_evento = ' . dbInteger($id));
		$fields['id_evento'] = $id;
	}
	
	function eventosDelete($id)
	{
		deleteRecord('eventos', "id_evento = " . dbInteger($id));
	}	

	function eventosUpdateStatus($id, $status)
	{
		$fields = array();
		$fields['status'] = dbString($status);
				
		updateRecord('eventos', $fields, 'id_evento = ' . dbInteger($id));
	}
	
// Apreciaчуo de eventos
	function apreciacaoInsert($fields)
	{
		insertRecord('eventos_classificacoes', $fields, false);
	}
	
	
	
?>