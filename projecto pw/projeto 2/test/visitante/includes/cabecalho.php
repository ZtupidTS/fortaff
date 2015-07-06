<?php
session_start();
include '../includes/ligacao.php';
require_once '../funcao/recupera_url.php';
$url_actual = recupera_url_atual();
include 'login.php';
include 'cookie.php';?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Jogos Olimpicos 2012</title>
		<link href="<?= $_COOKIE['css'];?>" rel="stylesheet" type="text/css" name="css">
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<link rel="shortcut icon" href="../images/ico.ico">
		<script type="text/javascript" language="javascript" src="js/prototype.js"></script>
		<script type="text/javascript" language="javascript" src="js/menu.js"></script>
		<script type="text/javascript" language="javascript" src="js/pagina_tabela.js"></script>
		<script type="text/javascript" language="javascript" src="../js/lugares_total.js"></script>
		<script type="text/javascript" language="javascript" src="js/terminarsessao.js"></script>
		<script type="text/javascript" language="javascript" src="js/mudarcss.js"></script>
		<script type="text/javascript" language="javascript" src="js/diasfaltam.js"></script>
	</head>
	
	<body>	
	<!-- cabeçalho -->
	<div id="cores_css">
		<a href="javascript:void(0)" onClick="MudarCss('azul','<?= $url_actual;?>')"><img src="../images/css/azul.jpg" alt="Azul" title="Azul"/></a>
		<a href="javascript:void(0)" onClick="MudarCss('amarelo','<?= $url_actual;?>')"><img src="../images/css/amarelo.jpg" alt="Amarelo" title="Amarelo"/></a>
		<a href="javascript:void(0)" onClick="MudarCss('vermelho','<?= $url_actual;?>')"><img src="../images/css/vermelho.jpg" alt="Vermelho" title="Vermelho"/></a>
		<a href="javascript:void(0)" onClick="MudarCss('verde','<?= $url_actual;?>')"><img src="../images/css/verde.jpg" alt="Verde" title="Verde"/></a>
	</div>
			
	<div class="estrutura">	
		<div id="banner">
			&nbsp;
		</div>	
		<?php 
			include 'includes/proximos_6ev.php';
		?>	
		<!-- Relogio -->
		<div id="menus">
		<div class="posicao">
			<table class="border">
				<tr class="numerosrelogio">
					<td><div id="dias"></div></td>
					<td><div id="horas"></div></td>
					<td><div id="minutos"></div></td>
					<td><div id="segundos"></div></td>
				</tr>
				<tr class="legendarelogio">
					<td><div>Dias</div></td>
					<td><div>Horas</div></td>
					<td><div>Minutos</div></td>
					<td><div>Segundos</div></td>	
				</tr>
			</table>
		</div>	
		<script>DiasFaltam();</script>

		<a href="../webservice/fluxrss.xml" title="Rss" alt="Rss"><span id="img_rss"></span></a>

		
		<!-- menu -->
			
			<?php 
			include 'includes/pre_tempo.php';
			?>	
			<?php
			if(isset($_SESSION['id_vis']))
			{
				include 'menu_registado.php';
			}else{
				include 'registo_login.php';
			}
			include 'menu_vis.php';
			?>
			</br>
			<!-- menu a esquerda -->

			<!-- menu a direita -->
		</div>
	
	
	