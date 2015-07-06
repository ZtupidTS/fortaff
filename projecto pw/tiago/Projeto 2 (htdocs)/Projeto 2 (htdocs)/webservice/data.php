<?php
	include('../includes/utils.php');
	include('../includes/database/jo_db.php');
		
//q - query (delegações; equipas)
//output - output (xml; json)

	if ((isset($_GET['output'])) && $_GET['output'] != ""){
		$output = $_GET['output'];
	} else {
		$output = "json";
	}

	if((isset($_GET['q'])) && $_GET['q'] != ""){
		$q = $_GET['q'];
	}else{
		$q = "delegacoes";
	}
			
	switch ($q)	{
		case "equipas":
		
			switch ($output) {
				case "xml":
					$xml = '<?xml version="1.0" encoding="ISO-8859-1" ?>';
					$xml .= "<countries>";
					
					$delegacoes = delegacaoGetByFiltro(-1, null, array('X'));
					while($country = foreachRow($delegacoes)){
						$xml .= "<country>";
						$xml .= '<id>'.$country['id_pais'].'</id>';
						$xml .= '<name>'.$country['pais_nome'].'</name>';
						$xml .= '<teams>';
						
						$equipas = equipaGetByFiltro($country['id_delegacao'], null, array('X'));
						while ($team = foreachRow($equipas)){
							$xml .= '<team>';
							$xml .= '<name>'.$team['modalidade_nome'].'</name>';
							$xml .= '<type>'.$team['modalidade_tipo'].'</type>';		
							$xml .= '</team>';
						}
						
						$xml .= '</teams>';
						$xml .= "</country>";
					}
					
					$xml .="</countries>";
					echo $xml;
					break;
			
				case "json":
					$delegacoes = delegacaoGetByFiltro(-1, null, array('X'));
					while ($a = foreachRow($delegacoes)) {
						$equipas = equipaGetByFiltro($a['id_delegacao'], null, array('X'));
						$y = array();
						while ($b = foreachRow($equipas)) {
							$y[] = array('modalidade_nome' => $b['modalidade_nome'],
										'modalidade_tipo' => $b['modalidade_tipo']);
						}
						$x[] = array('id_delegacao' => $a['id_delegacao'],
									 'id_pais' => $a['id_pais'],
									 'pais_nome' => utf8_encode($a['pais_nome']),
									 'equipas' => $y);
					}
					echo ujson_encode($x);
					break;
			}
		
			break;

		case "delegacoes":
			switch ($output) {
				case "xml":
					$xml = '<?xml version="1.0" encoding="ISO-8859-1" ?>';
					$xml .= '<countries>';		
					
					$delegacoes = delegacaoGetByFiltro(-1, null, array('X'));
					while($country = foreachRow($delegacoes)){
						$xml .= '<country>';
						$xml .= '<id>'.$country['id_pais'].'</id>';
						$xml .= '<name>'.$country['pais_nome'].'</name>';		
						$xml .= '<responsible>'.$country['nome_responsavel'].'</responsible>';
						$xml .= '<average_age>'.$country['media_idade'].'</average_age>';
						$xml .= '<medals_gold>'.$country['ouro'].'</medals_gold>';
						$xml .= '<medals_silver>'.$country['prata'].'</medals_silver>';
						$xml .= '<medals_bronze>'.$country['bronze'].'</medals_bronze>';				
						$xml .= '</country>';
					}
					$xml .= '</countries>';
					echo $xml ;
					break;
			
				case "json":
					$delegacoes = delegacaoGetByFiltro(-1, null, array('X'));
					while ($a = foreachRow($delegacoes)) {
						$x[] = array('id_delegacao' => $a['id_delegacao'],
									 'id_pais' => $a['id_pais'],
									 'pais_nome' => utf8_encode($a['pais_nome']),
									 'nome_responsavel' => utf8_encode($a['nome_responsavel']),
									 'media_idade' => $a['media_idade'],
									 'ouro' => $a['ouro'],
									 'prata' => $a['prata'],
									 'bronze' => $a['bronze']);
					}
		
					echo ujson_encode($x);
					break;
		}
	}
		
	closeDataBase();

?>
