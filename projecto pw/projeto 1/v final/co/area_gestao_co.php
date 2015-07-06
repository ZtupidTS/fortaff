<?php 
session_start(); 
include '../includes/test_intruso_co.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Jogos Olimpicos 2012</title>
		<link href="../css/estilo_co.css" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<link rel="shortcut icon" href="images/ico.ico">
	</head>
	
	<body>
		<div id="estrutura">		
		<!-- cabeçalho -->
		<?php include '../includes/cabecalho.php';?>
		
		<!-- menu -->
		<?php include '../includes/menu_escolha_co.php';?>
		
		<!-- corpo -->
		<?php
			require_once '../funcao/funcao_formulario.php';
			$data = inverte_data($_SESSION["ultimo_acesso"]);
		?>
		<div id="conteudo">
			<div id="conteudo_a_gestão_co">
			<p> Olá <strong><?= $_SESSION['nome_utilizador'];?></strong> !</p>
			<p> Bem-Vindo ao sistema de Gestão de Informação dos Jogos Olímpicos.</p> 
			<p> Ultimo acesso: <?= $data;?> </p>

			</div>
		</div>
		
		<!-- em baixo -->
		<?php include '../includes/rodape.php';?>
		</div>
				
	
	</body>
</html>