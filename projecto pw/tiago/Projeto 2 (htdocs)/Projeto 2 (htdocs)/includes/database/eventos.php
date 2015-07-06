<?php

	// #### EVENTOS ###
	function eventosGet($id)
	{
		$t = getTable("eventos_total", "id_evento = " . dbInteger($id), "");
		return foreachRow($t);
	}

	function eventosGetAll()
	{
		return getTable("eventos_total", "", "");
	}

	function eventosGetByFiltro($status_array = null, $reject_status_array = null)
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
		
		// if ($data !== null) {
			// $where .= ($where == '') ? '' : ' AND ';
			// $where .= "data_hora = " . dbDate($data);
		// }
		
		return getTable("eventos_total", $where, "id_evento");
	}
	
	function eventosLastXEvents($status_array, $reject_status_array, $limit)
	{
		$where = "data_hora >= '" . date("Y-m-d h:i:s") . "'";
		
		if ($status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status IN ('" . join("', '", $status_array) . "')";
		}
		
		if ($reject_status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status NOT IN ('" . join("', '", $reject_status_array) . "')";
		}
		
		return getTable("eventos_total", $where, "data_hora DESC, id_evento LIMIT " . $limit);
	}
	
	function eventoCountBilhete($tipoBilhete)
	{	
		if ($tipoBilhete == "C") {
			$fields = "lugares_vendidos";
		} else if ($tipoBilhete == "R") {
			$fields = "lugares_reservados";
		} else {
			$fields = "lugares_vendidos + lugares_reservados";
		}
		
		$e = getTableSelected("eventos_total", array("SUM(" . $fields . ") AS total"), "status <> 'X'", "");
		$row = forEachRow($e);
		return $row['total'];
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
	
// Apreciação de eventos
	function apreciacaoGet($id_evento, $id_visitante)
	{
		$t = getTable("eventos_classificacoes", "id_evento = " . dbInteger($id_evento) . " AND " . 
												"id_visitante = " . dbInteger($id_visitante), "");
		return foreachRow($t);
	}
	
	function apreciacaoInsert($fields)
	{
		insertRecord('eventos_classificacoes', $fields, false);
	}
	
	function apreciacaoExist($id_evento, $id_visitante)
	{
		$count = getTableCount("eventos_classificacoes", "id_evento = " . dbInteger($id_evento) . " AND " . 
														 "id_visitante = " . dbInteger($id_visitante));
		return ($count == 0 ? false : true);
	}
	
	
	
?>