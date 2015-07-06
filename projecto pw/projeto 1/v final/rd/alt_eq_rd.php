<?php 
session_start(); 
include '../includes/test_intruso_rd.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Jogos Olimpicos 2012</title>
		<link href="../css/estilo_rd.css" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<link rel="shortcut icon" href="../images/ico.ico">
		<script language="javascript">
		<?php include '../js/mensagem_popup.js';?>
		</script>
	</head>
	
	<body>
	<div class="estrutura">			
		<!-- cabeçalho -->
		<?php include '../includes/cabecalho_rd.php';?>
	
		<!-- menu a direita -->
		<?php include '../includes/bandeira.php'; ?>
		
		<!-- corpo -->
		<div class="estrutabela">	
		<?php 
			include '../includes/ligacao.php';
			
			#caso veio da pagina anterior ou da validação pega no post ou na variavel de sessão
			if(isset($_POST['cod_equipa']))
			{
				$escolha_equipa = mysql_query("SELECT * FROM equipa WHERE cod_equipa='$_POST[cod_equipa]'");
				$dados = mysql_fetch_array($escolha_equipa);
				$_SESSION['eq_rd_a_alterar'] = $dados['cod_equipa'];
			}else{
				$escolha_equipa = mysql_query("SELECT * FROM equipa WHERE cod_equipa='$_SESSION[eq_rd_a_alterar]'");
				$dados = mysql_fetch_array($escolha_equipa);
			}
			?>
			<form method="post" action="verif_alt_eq_rd.php">
				<h1>Alterar Equipa:</h1>
				<table>
					<tr>
						<td>Numero da equipa:</td> 
						<td style="visibility:hidden; display:none"><input type="text" name="cod_equipa" value="<?php echo $dados['cod_equipa']; ?>"></td>
						<td style="visibility:hidden; display:none"><input type="text" name="cod_delegacao" value="<?php echo $dados['cod_delegacao']; ?>"></td>
						<td style="visibility:hidden; display:none"><input type="text" name="sexo" value="<?php echo $dados['sexo']; ?>"></td>
						<td><?php echo $dados['cod_equipa']; ?></td>
					</tr>
					<tr>
						<td>Modalidade:</td> 
						<td><?php include '../includes/select_modalidade.php';?></td>
					</tr>		
				</table>
				<!-- os botões -->
				<input name="enviar" type="submit" value="Alterar" class="botao" />
				<input type="button" value="Voltar as Equipas" onclick="window.location.href='area_gestao_rd.php'" class="botao">
			</form>
		</div>
		
		<!-- em baixo -->
		<?php include '../includes/rodape_rd.php';?>
		<!-- include para a mensagem popup -->
		<?php include '../includes/mensagem_popup.php';?>	
	</div>	
	</body>
</html>