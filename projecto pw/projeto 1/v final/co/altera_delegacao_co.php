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
	</head>
	
	<body>
		<div id="estrutura">
			<!-- cabeçalho -->
			<?php include '../includes/cabecalho.php'; ?>	
			
			<!-- menu -->
			<?php include '../includes/menu_escolha_co.php';?>
			
			<!-- corpo -->
			<div id="conteudo_acrescentar">
				<?php 
				include '../includes/ligacao.php';
				if(isset($_POST['cod_delegacao']))
				{
					$escolha_delegacao = mysql_query("SELECT * FROM delegacao WHERE cod_delegacao='$_POST[cod_delegacao]' and estado_valido != 'X'");
					$dados = mysql_fetch_array($escolha_delegacao);
					$_SESSION['delegacao_a_alterar'] = $dados['cod_delegacao'];
				}else{
					$escolha_delegacao = mysql_query("SELECT * FROM delegacao WHERE cod_delegacao='$_SESSION[delegacao_a_alterar]' and estado_valido != 'X'");
					$dados = mysql_fetch_array($escolha_delegacao);
				}	
				?>
				<form method="post" action="verificacao_alt_delegacao_co.php">
					<table>
						<p> Alterar delegação de <?= $dados['nome_pais'];?> :</p>
						<tr> 
							<td>Responsável:</td>
							<td><input name="nome_responsavel" maxlength="30" type="text" value="<?= $dados['nome_responsavel'];?>" required class="form"/></td>
							<td rowspan="4"><img class="bandeira" src="../images/Bandeiras/<?= $dados['cod_delegacao'];?>.png" ></td>
						</tr>
						<tr> 
							<td>Login:</td>
							<td><input name="login" type="text" value="<?= $dados['login'];?>" required maxlength="30" class="form"></td>
						</tr>
						<tr> 
							<td>E-mail:</td>
							<td><input name="email" type="text" value="<?= $dados['email'];?>" maxlength="30" required class="form"></td>
						</tr>
					</table>
					<!-- os botões -->
					<input class="botao" name="enviar" type="submit" value="Alterar" >
					<input class="botao" name="limpar" type="reset"  value="Anular Modificações" >
					<input class="botao" type="button" value="Voltar às Delegações" onclick="window.location.href='delegacao_co.php'" >
				</form>
				
			</div>
					
			<!-- em baixo -->
			<?php include '../includes/rodape.php'; ?>	
			
			<!-- include para a mensagem popup -->
			<?php include '../includes/mensagem_popup.php';?>
		</div>
	</body>
</html>