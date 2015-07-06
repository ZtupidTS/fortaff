<?php

	function provaGet($id)
	{
		$t = getTable('provas_total', 'id_prova = ' . dbInteger($id), '');
		return foreachRow($t);
	}
	
	function provaGetAll()
	{
		return getTable('provas_total', '', 'data_hora, duracao');
	}
	
	function provaGetByFiltro($id_local = -1, $id_modalidade = -1, $status_array = null, $reject_status_array = null)
	{
		$where = '';
		
		if ($id_local !== -1) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "id_local = " . dbInteger($id_local);
		}
		
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
		
		// if ($data !== null) {
			// $where .= ($where == '') ? '' : ' AND ';
			// $where .= "data_hora = " . dbDate($data);
		// }
		
		return getTable('provas_total', $where, 'data_hora, duracao');
	}
	
	function provaCountBilhete($tipoBilhete)
	{	
		if ($tipoBilhete == "C") {
			$fields = "lugares_vendidos";
		} else if ($tipoBilhete == "R") {
			$fields = "lugares_reservados";
		} else {
			$fields = "lugares_vendidos + lugares_reservados";
		}
		
		$e = getTableSelected("provas_total", array("SUM(" . $fields . ") AS total"), "status <> 'X'", "");
		$row = forEachRow($e);
		return $row['total'];
	}
	
	function provaInsert(&$fields)
	{
		unset($fields['id_prova']);
		$fields['id_prova'] = insertRecord('provas', $fields, true);
	}
	
	function provaUpdate($fields)
	{
		$id = $fields['id_prova'];
		unset($fields['id_prova']);
		
		updateRecord('provas', $fields, 'id_prova = ' . dbInteger($id));
		$fields['id_prova'] = $id;
	}
	
	function provaUpdateStatus($id, $status)
	{
		$fields = array();
		$fields['status'] = dbString($status);
		
		updateRecord('provas', $fields, 'id_prova = ' . dbInteger($id));
		
		if ($status == 'X') {
			$fields = array();
			$fields['status'] = dbString('X');
			updateRecord('provas_classificacoes', $fields, 'id_prova = ' . dbInteger($id));
		}
		
	}

?>