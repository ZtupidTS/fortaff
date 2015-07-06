<?php
//criação de uma instância do servidor
$server = new SoapServer(null, array('uri' => "http://localhost/webservice/rss/"));

//definição do serviço
function helloWorld($name){
return "Hello ".$name;
}

function nextSixEvents(){
	if(!$dbconnect = mysql_connect('localhost', 'pw606','pw10606')){
	   echo "Connection failed to the host 'localhost'.";
	   exit;
	} // if
	if (!mysql_select_db('pw606_jo')) {
	   echo "Cannot connect to database 'test'";
	   exit;
	} // if

	$table_id = 'eventos_total';
	$query = "SELECT * FROM $table_id WHERE data_hora >= '" . date("Y-m-d h:i:s") . "' AND status NOT IN ('X') ORDER BY data_hora DESC, id_evento  LIMIT 0,6";
	$dbresult = mysql_query($query, $dbconnect); 

	$rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
	$rssfeed .= '<rss version="2.0">';
		$rssfeed .= '<channel>';
		$rssfeed .= '<title>RSS de Eventos PW606 JO</title>';
		$rssfeed .= '<link>http://pw606.x10.mx/webservices/rss/rss_events.php</link>';
		$rssfeed .= '<description>Eventos dos Jogos Olímpicos</description>';
		$rssfeed .= "<pubDate>". date("D, d M Y H:i:s O", time()) ."</pubDate>";
		// process one row at a time
		while($row = mysql_fetch_assoc($dbresult)) {
			$rssfeed .= '<item>';
			$rssfeed .= '<title>'.$row['designacao'].'</title>';
			$rssfeed .= '<description>'.$row['descricao'].'</description>';		
			$rssfeed .= '<date_time>'.$row['data_hora'].'</date_time>';
			$rssfeed .= '<duration>'.$row['duracao'].'</duration>';
			$rssfeed .= '<locale>'.$row['local_nome'].'</locale>';
			$rssfeed .= '<capacity>'.$row['num_lugares'].'</capacity>';
			$rssfeed .= '<ticket_price>'.$row['preco_bilhete'].'</ticket_price>';		
			$rssfeed .= '<sold_tickets>'.$row['lugares_vendidos'].'</sold_tickets>';		
			$rssfeed .= '</item>';
		} // while
		$rssfeed .= '</channel>';
	$rssfeed .= '</rss>';
return $rssfeed ;
}


//registo do serviço
$server->addFunction("helloWorld");
$server->addFunction("nextSixEvents");
//chamada do método para atender os pedidos de serviço
$server->handle();
?>