<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
	<title>Jogos Olimpicos 2012</title>
	<link href="css/global.css" rel="stylesheet" type="text/css">
	<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
	<link rel="shortcut icon" href="../images/ico.ico" >
	</head>
	<body>
	
	
	<p class="subcaixa_de_texto">
	<!-- <a href="visitante.html">Visitante >></a><br> -->
	</p>
	<p class="subcaixa_de_texto">
	<?php 
	$_SESSION["login_false"] = false;
	?>
	<?php header('Location: login/area_reservada.php');?>
	<!--
	<a href="login/area_reservada.php">Area Reservada >></a>
	</p>
	-->
	</body>
</html>