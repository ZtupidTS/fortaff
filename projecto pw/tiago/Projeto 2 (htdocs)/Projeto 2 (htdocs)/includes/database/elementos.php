<?php

	// ### ELEMENTO ###
	function elementoGetAll($ids = null)
	{
		$where = '';
		if ($ids !== null) {
			$where = 'id_elemento IN (' . join(', ', $ids) . ')';
		}
		
		return getTable('elementos_total', $where, 'pais_nome, nome');
	}
	
	function elementoGetByFiltro($id_delegacao, $id_equipa, $status_array, $reject_status_array)
	{
		$where = '';
		
		if ($id_delegacao !== -1) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "id_delegacao = " . dbInteger($id_delegacao);
		}
		
		if ($id_equipa !== -1) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "elementoInscritoEquipa(id_equipa, " . dbInteger($id_equipa) . ")";
		}
		
		if ($status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status IN ('" . join("', '", $status_array) . "')";
		}
		
		if ($reject_status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status NOT IN ('" . join("', '", $reject_status_array) . "')";
		}
		
		return getTable('elementos_total', $where, 'pais_nome, nome');
	}
	
	function elementoCount($tipo = "", $sexo = "", $id_delegacao = -1)
	{
		$where = '';
		
		if ($id_delegacao !== -1) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "id_delegacao = " . dbInteger($id_delegacao);
		}
		
		if ($tipo !== "") {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "tipo = " . dbString($tipo);
		}
		
		if ($sexo !== "") {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "sexo = " . dbString($sexo);
		}
		
		$where .= ($where == '') ? '' : ' AND ';
		$where .= "status <> " . dbString("X");
		
		return getTableCount("elementos", $where);
		
	}
	
	function elementoGet($id)
	{
		$t = getTable('elementos_total', 'id_elemento = ' . dbInteger($id), '');
		return foreachRow($t);
	}
	
	function elementoGetTipoDescricao($tipo)
	{
		$t = getTable('elemento_tipo', 'tipo = ' . dbString($tipo), '');
		$t = foreachRow($t);
		return $t['descricao'];
	}
	
	function elementoInsert($fields)
	{
		unset($fields['id_elemento']);
		$fields['id_elemento'] = insertRecord('elementos', $fields, true);
	}
		
	function elementoUpdate($fields)
	{
		$id = $fields['id_elemento'];
		unset($fields['id_elemento']);
		
		updateRecord('elementos', $fields, 'id_elemento = ' . dbInteger($id));
		$fields['id_elemento'] = $id;
	}
	
	function elementoUpdateStatus($id, $status)
	{
		$fields = array();
		$fields['status'] = dbString($status);
		
		updateRecord('elementos', $fields, 'id_elemento = ' . dbInteger($id));
		
		if ($status == 'X') {
			$fields = array();
			$fields['status'] = dbString('X');		
			updateRecord('elementos_equipas', $fields, 'id_elemento = ' . dbInteger($id));
		}
		
	}
	
	function elementoDelete($id)
	{
		deleteRecord('elementos', "id_elemento = " . dbInteger($id));
	}

	//retorna as modalidades às quais o elemento está inscrito
	function elementoModalidades($id_elemento)
	{		$where = "id_elemento = ". dbInteger($id_elemento)." AND status NOT LIKE 'X'";
		return $elementoModalidades = getTable('elementos_equipas_total',$where,'');
		
	}
	
	
?>