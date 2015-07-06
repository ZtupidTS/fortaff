<?php

function getTemplate($name, $args)
{
	$root = $_SERVER['DOCUMENT_ROOT'] . '/pw606/includes/mail/templates/';
	$file = file_get_contents($root . $name . ".html");
	foreach($args AS $key => $value) {
		$file = str_replace(stringToKey($key), $value, $file);
	}
	return $file;
}

function stringToKey($key)
{
	return "{*" . $key . "*}";
}

/* ### TEMPLATES ### */

function templateNewUser($id, $user, $password, $name)
{
	return getTemplate("newuser", array("NAME" => $name, "USER" => $user, "PASS" => $password,
										"ID" => $id, "CHECKSUM" => md5("CODE" . $id)));
}

function templateNewTicket($id, $user)
{
	$b = bilheteGet($id);
	
	if ($b['acontecimento'] == 'E') {
		$e = eventosGet($b['id_entidade']);
	} else {
		$e = provaGet($b['id_entidade']);
	}
	
	return getTemplate("newticket", array("NAME" => $user['nome'], "USER" => $user['email'],
										  "TIPO" => $b['tipo'] == 'C' ? 'compra' : 'reserva',
										  "ACONTECIMENTO" => $b['acontecimento'] == 'E' ? 'Evento' : 'Prova',
										  "EVENTO" => $e['designacao'], "LOCAL" => $e['local_nome'],
										  "PRECO" => $b['preco'], "QUANTIDADE" => $b['quantidade'],
										  "TOTAL" => $b['preco'] * $b['quantidade'],
										  "ID" => $id, "CHECKSUM_ACCEPT" => md5("ACCEPT" . $id),
										  "CHECKSUM_REJECT" => md5("REJECT" . $id)));
}

?>