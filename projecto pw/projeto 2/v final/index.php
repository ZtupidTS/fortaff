<?php
require_once 'funcao/detectatelemovel.php';
if(detectaTelemovel())
{
	header("Location: mobile/index.php");
}
include 'includes/ligacao.php';
require_once 'funcao/recupera_url.php';
$url_actual = recupera_url_atual();
include 'visitante/includes/login.php';
include 'visitante/includes/cookie.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Jogos Olimpicos 2012</title>
		<link href="css/index.css" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<link rel="shortcut icon" href="images/ico.ico">
	</head>
	<body>
	<!-- menu a esquerda -->
	
	<!-- menu a direita -->
	
	
	<!-- corpo -->
	<div class="conteudo2">
			<img src="images/iconjogosolimpicos.jpg" width="100"/>
	</div>
	<div class="estrutura">
		<div class="cabeçalho">
			<img src="images/cabeçalho.png"/>
		</div>	
		<div class="conteudo">
			<iframe width="640" height="360" src="http://www.youtube.com/embed/DpEawduUW7o?rel=0&autoplay=1" frameborder="0" allowfullscreen></iframe>	
		</div>
		<div class="rodapé">	
			<a href="visitante/visitante.php">
				<img src="images/entrar.png"/>
			</a>
		</div>
	<!-- em baixo -->
	
	
	
	
	</body>
</html>