<?php

	include 'mysql.php';
	include 'delegacoes.php';
	include 'equipas.php';
	include 'elementos.php';
	include 'elementosequipas.php';
	include 'modalidades.php';
	include 'eventos.php';
	include 'locais.php';
	include 'provas.php';
	include 'provas_classificacoes.php';
	include 'sugestoes.php';
	include 'visitantes.php';
	include 'bilhetes.php';
	include 'paypal.php';
	
	//Inicia a ligaчуo р base de dados
	openDataBase("localhost", "pw606_jo", "pw606", "pw10606");
	
	// #### ESTADOS ####
	function estadoGetAll()
	{
		return getTable('estados', '', '');
	}
	
	function estadoGetDescricao($status) {
		$t = getTable('estados', 'status = ' . dbString($status), '');
		$t = foreachRow($t);
		return $t['descricao'];
	}
	
	// #### LOGIN ####
	function coCheckLogin($user, $password)
	{
		$p = parametroGetAll();
		
		if ($p['co_user'] == $user and $p["co_pass"] == $password)
		{
			return true;
		} else {
			return false;
		}
	}
	
	function rdCheckLogin($user, $password)
	{
		$count = getTableCount("delegacoes",
							   "login = " . dbString($user) . " AND password = " . dbString($password) . " AND status <> 'X'", "");
		return ($count == 1);
	}
	
	function vsCheckLogin($user, $password)
	{
		$count = getTableCount("visitantes",
							   "email = " . dbString($user) . " AND password = " . dbString($password) . " AND status = 'A'", "");
		return ($count == 1);
	}
	
	// #### PAIS ####
	
	function paisGet($id_pais)
	{
		return foreachRow(getTable('paises', "id_pais = ". dbString($id_pais), ''));
	}
	
	function paisGetAll()
	{
		return getTable('pais', '', '');
	}
	
	function paisSemDelegacao()
	{
		return getTable("paises_sem_delegacao", "", "");
	}
	
	// #### PARAMETROS ####
	function parametroGetAll()
	{
		$pms = getTable("parametros", "", "");
		$p = array();
		
		while($row = foreachRow($pms))
		{
			$p[$row['chave']] = $row['valor'];
		}
		
		return $p;
	}
	
	function coUserGet()
	{
		$params = parametroGetAll();
		
		$co = array();
		$co['id_delegacao'] = -1;
		$co['id_pais'] = "ad";
		$co['nome_responsavel'] = $params['co_name'];
		$co['status'] = "V";
		$co['login'] = $params['co_user'];
		$co['password'] = $params['co_pass'];
		$co['pais_nome'] = "Administrador";
		$co['status_descricao'] = "Validado";
		
		return $co;
		
	}
	
	function joInitialDate()
	{
		$params = parametroGetAll();
		return date_create($params['inicio_jo']);
	}
	
	function joLimitChangeData()
	{
		$params = parametroGetAll();
		return intval($params['limitchangedata']);
	}
	
	function joLimitChangeProof()
	{
		$params = parametroGetAll();
		return intval($params['limitchangeproof']);
	}
	
?>