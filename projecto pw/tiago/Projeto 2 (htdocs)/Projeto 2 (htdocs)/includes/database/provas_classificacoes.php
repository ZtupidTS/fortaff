<?php
	
	function provaClassificacaoGet($id)
	{
		$t = getTable('provas_classificacoes_total', 'id_classificacao = ' . dbInteger($id), '');
		return foreachRow($t);
	}
	
	function provaClassificacaoInsert($fields)
	{
		unset($fields['id_classificacao']);
		$fields['id_classificacao'] = insertRecord('provas_classificacoes', $fields, true);
	}
	
	function provaClassificacaoUpdateClassificacao($id_classificacao, $classificacao)
	{
		$fields = array();
		$fields['classificacao'] = dbInteger($classificacao);
		
		updateRecord('provas_classificacoes', $fields, 'id_classificacao = ' . dbInteger($id_classificacao));
	}
	
	function provaClassificacaoUpdateStatus($id_classificacao, $status)
	{
		$fields = array();
		$fields['status'] = dbString($status);
		
		updateRecord('provas_classificacoes', $fields, 'id_classificacao = ' . dbInteger($id_classificacao));
	}
	
	// ELEMENTOS
	function provaClassificacaoElementoGetByFiltro($id_prova, $status_array, $reject_status_array)
	{
		$where = '';
		
		if ($id_prova !== -1) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "id_prova = " . dbInteger($id_prova);
		}
		
		if ($status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status IN ('" . join("', '", $status_array) . "')";
		}
		
		if ($reject_status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status NOT IN ('" . join("', '", $reject_status_array) . "')";
		}
		
		return getTable('provas_classificacoes_elementos', $where, 'classificacao');
	}
	
	function elementoNaoInscritoEmProva($id_prova, $id_modalidade, $id_delegacao) {
		
		$where = 'tipo = \'A\'';
		$where .= ' AND equipa_id_modalidade = ' . dbInteger($id_modalidade);
		$where .= ' AND id_prova = ' . dbInteger($id_prova);
		
		if ($id_delegacao <> -1) {
			$where .= ' AND id_delegacao = ' . dbInteger($id_delegacao);
		}
		
		$t = getTable('provas_classificacoes_elementos_nao_inscritos', $where, '');
		
		$ids = array();
		while ($row = foreachRow($t)) {
			$ids[] = $row['id_elemento'];
		}
		
		if (count($ids) == 0) {
			$ids[] = -1;
		} 
		
		return elementoGetAll($ids);
		
	}
	
	// EQUIPAS
	function equipaNaoInscritaEmProva($id_prova, $id_modalidade, $id_delegacao) {
		
		$where = 'equipa_id_modalidade = ' . dbInteger($id_modalidade);
		$where .= ' AND id_prova = ' . dbInteger($id_prova);
		
		if ($id_delegacao != -1) {
			$where .= ' AND id_delegacao = ' . dbInteger($id_delegacao);
		}
		
		$t = getTable('provas_classificacoes_equipas_nao_inscritos', $where, '');
		
		$ids = array();
		while ($row = foreachRow($t)) {
			$ids[] = $row['id_equipa'];
		}
		
		if (count($ids) == 0) {
			$ids[] = -1;
		} 
		
		return equipaGetAll($ids);
		
	}
	
	function provaClassificacaoEquipaGetByFiltro($id_prova, $status_array, $reject_status_array)
	{
		$where = '';
		
		if ($id_prova !== -1) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "id_prova = " . dbInteger($id_prova);
		}
		
		if ($status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status IN ('" . join("', '", $status_array) . "')";
		}
		
		if ($reject_status_array !== null) {
			$where .= ($where == '') ? '' : ' AND ';
			$where .= "status NOT IN ('" . join("', '", $reject_status_array) . "')";
		}
		
		return getTable('provas_classificacoes_equipas', $where, 'classificacao');
	}
	
?>