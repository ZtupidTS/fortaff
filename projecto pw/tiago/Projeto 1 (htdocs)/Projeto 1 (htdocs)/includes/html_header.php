<?php
	//Inicializações
	date_default_timezone_set('Europe/Lisbon');
	session_start();
	ob_start();
	
	//Includes
	include 'database/jo_db.php';
	
	// Variável para o tamanho da página das tabelas
	$lines_per_table = 10;
	
	// Variáveis auxiliares do utilizador autenticado.
	$user_authenticated = isset($_SESSION['login']);
	$current_user = $user_authenticated ? $_SESSION['login'] : null;
	$user_isAdmin = (($user_authenticated) and ($current_user['id_pais'] == 'ad'));
	
	// $perfil tem o nome da pasta do perfil corrente.
	if (strpos($_SERVER['SCRIPT_NAME'], '/co/') !== false) {
		$perfil = "co";
	} else if (strpos($_SERVER['SCRIPT_NAME'], '/rd/') !== false) {
		$perfil = "rd";
	} else {
		$perfil = "";
	}
	
	// Caso um utilizador autenticado entre numa área que não é a sua, faz logout automaticamente.
	if ($user_authenticated && $perfil == 'co' && !$user_isAdmin) {
		header("location: " . rootPath("co/logout.php", 1));
		exit(0);
	} else if ($user_authenticated && $perfil == 'rd' && $user_isAdmin) {
		header("location: " . rootPath("rd/logout.php", 1));
		exit(0);
	}
	
	// Variáveis auxiliares para os relógios
	$jo_Date = new TimeStamp(new DateTime("now"), joInitialDate());
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>GIJO</title>
		<link rel="shortcut icon" href="/pw606/favicon.ico">
		<meta http-equiv="content-type" content="text/html" charset="ISO-8859-1" />
		<link href="/pw606/css/default.css" rel="stylesheet" type="text/css" />
		<link href="/pw606/css/<?= $perfil == 'rd' ? 'rd' : 'co'; ?>.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/pw606/js/prototype.js"></script>
		<script type="text/javascript" src="/pw606/js/fullJavaScript.js"></script>
		
		<script type="text/javascript">
	
			function updateClock()
			{
				setTimeout('updateClock()', 1000);
				
				var h = document.getElementById('clockHH');
				var m = document.getElementById('clockmm');
				var s = document.getElementById('clockss');
				
				var date = new Date(2011, 1, 1, h.innerHTML, m.innerHTML, s.innerHTML);
				date.setTime(date.getTime() + 1000);
				
				h.innerHTML = str_right("0" + date.getHours(), 2);
				m.innerHTML = str_right("0" + date.getMinutes(), 2);
				s.innerHTML = str_right("0" + date.getSeconds(), 2);
				
			}
			
			function updateJoDate()
			{
			
				var timerJo = setTimeout('updateJoDate()', 1000);
				
				var d = document.getElementById('joDD');
				var h = document.getElementById('joHH');
				var i = document.getElementById('joII');
				var s = document.getElementById('joSS');
				
				s.innerHTML = parseInt(s.innerHTML, 10) - 1;
				if (s.innerHTML == "-1") {
					s.innerHTML = "59";
					i.innerHTML = parseInt(i.innerHTML, 10) - 1;
				}
				
				if (i.innerHTML == "-1") {
					i.innerHTML = "59";
					h.innerHTML = parseInt(h.innerHTML, 10) - 1;
				}
				
				if (h.innerHTML == "-1") {
					h.innerHTML = "23";
					d.innerHTML = parseInt(d.innerHTML, 10) - 1;
				}
				
				if (d.innerHTML == "-1") {
					d.innerHTML = "00";
					h.innerHTML = "00";
					i.innerHTML = "00";
					s.innerHTML = "00";
					clearTimeout(timerJo);
				} else {
					h.innerHTML = str_right("0" + h.innerHTML, 2);
					i.innerHTML = str_right("0" + i.innerHTML, 2);
					s.innerHTML = str_right("0" + s.innerHTML, 2);
				}
			}
			
		</script>