<?php

	// #### ELEMENTO EQUIPA ####
	function elementoNaoInscritoEmEquipa($id_equipa) {
		
		$t = getTable('elementos_equipas_nao_inscritos', 'tipo = \'A\' AND id_equipa = ' . dbInteger($id_equipa), '');
		
		$ids = array();
		while ($row = foreachRow($t)) {
			$ids[] = $row['id_elemento'];
		}
		
		if (count($ids) == 0) {
			$ids[] = -1;
		} 
		
		return elementoGetAll($ids);
		
	}
	
	function elementoEquipaGetByFiltro($id_delegacao, $id_equipa, $id_elemento, $status_array, $reject_status_array)
	{
		$where = '';
		
		if ($id_delegacao !== -1) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "id_delegacao = " . dbInteger($id_delegacao);
		}
		
		if ($id_equipa !== -1) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "id_equipa = " . dbInteger($id_equipa);
		}
		
		if ($id_elemento !== -1) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "id_elemento = " . dbInteger($id_elemento);
		}
		
		if ($status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status IN ('" . join("', '", $status_array) . "')";
		}
		
		if ($reject_status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status NOT IN ('" . join("', '", $reject_status_array) . "')";
		}
		
		if ($where == "") {
			return array();
		} else {
			return getTable('elementos_equipas_total', $where, 'pais_nome, elemento_nome');
		}
	}
	
	function elementoEquipaInsert($fields)
	{
		unset($fields['id_elemento_equipa']);
		$fields['id_elemento_equipa'] = insertRecord('elementos_equipas', $fields, true);
	}
	
	function elementoEquipaUpdateStatus($id_elemento_equipa, $status)
	{
		$fields = array();
		$fields['status'] = dbString($status);
		
		updateRecord('elementos_equipas', $fields, 'id_elemento_equipa = ' . dbInteger($id_elemento_equipa));
	}

?>