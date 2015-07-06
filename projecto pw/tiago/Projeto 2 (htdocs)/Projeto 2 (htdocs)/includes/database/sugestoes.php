<?php

	// ### SUGESTOES ###
	function sugestaoGetAll($ids = null)
	{
		$where = '';
		if ($ids !== null) {
			$where = 'id_sugestao IN (' . join(', ', $ids) . ')';
		}
		
		return getTable('sugestoes_total', $where, 'data, id_sugestao');
	}
	
	function sugestaoInsert($fields)
	{
		unset($fields['id_sugestao']);
		$fields['id_sugestao'] = insertRecord('sugestoes', $fields, true);
	}
	
?>