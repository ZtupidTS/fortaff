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
		<link rel="shortcut icon" href="../images/ico.ico" >
		<script language="javascript">
		<?php include '../js/mensagem_popup.js';?>
		</script>
	</head>
	
	<body>
		<div id="estrutura">
			
			<!-- cabeçalho -->
			<?php include '../includes/cabecalho.php';?>
			
			<!-- menu -->
			<?php include '../includes/menu_escolha_co.php';?>
			
			<!-- corpo -->
			<div id="conteudo_acrescentar">
				<?php 
				include '../includes/ligacao.php';
				if(isset($_POST['cod_modalidade']))
				{
					$escolha_modalidade = mysql_query("SELECT * FROM modalidade WHERE cod_modalidade='$_POST[cod_modalidade]'");
					$dados = mysql_fetch_array($escolha_modalidade);
					$_SESSION['modalidade_a_alterar'] = $dados['nome_modalidade'];
				}else{
					$escolha_delegacao = mysql_query("SELECT * FROM delegacao WHERE cod_delegacao='$_SESSION[modalidade_a_alterar]'");
					$dados = mysql_fetch_array($escolha_delegacao);
				}
				?>
				<form method="post" action="verif_alt_modalidade_co.php">
					<table>
						<h4>Alterar Modalidade: </h4>
						<tr>
							<td>Nome da modalidade:</td> 
							<td style="visibility:hidden; display:none"><input type="text" name="cod_modalidade" value="<?php echo $dados['cod_modalidade']; ?>"></td>
							<td><?= $_SESSION['modalidade_a_alterar']?></td>
						</tr>
						<tr>
							<td>Tipo:</td> 
							<td>
							<select name="tipo">
							<?php
							if($dados['tipo'] == "Coletiva")
							{?>
								<option value="C" selected="selected">Coletiva</option>
								<option value="I">Individual</option>
								<?php
							}else{?>
								<option value="C">Coletiva</option>
								<option value="I" selected="selected">Individual</option>
								<?php
							}?>
							</select>
							</td>
						</tr>	
					</table>
				</form>
				<!-- os botões -->
				<input class="botao" name="enviar" type="submit" value="Alterar"/>
				<input class="botao" type="button" value="Voltar às Modalidades" onclick="window.location.href='modalidade_co.php'">
			</div>			
			<!-- em baixo -->
			<?php include '../includes/rodape.php';?>
			
			<!-- include para a mensagem popup -->
			<?php include '../includes/mensagem_popup.php';?>
			
		</div>	
	</body>
</html>