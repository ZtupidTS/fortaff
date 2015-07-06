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
		<link rel="shortcut icon" href="../images/ico.ico">
	</head>
	<body>
		<div id="estrutura">
		
		<!-- cabeçalho -->
		<?php include '../includes/cabecalho.php'; ?>

		<!-- menu -->
		<?php include '../includes/menu_escolha_co.php';?>
		
		<!-- corpo -->
		<div id="conteudo_acrescentar">
			<form method="post" action="verificacao_acre_delegacao_co.php">
				<p> Insira os dados da delegação que pretende inserir: </p>
				<table>
					<tr>
						<td>País:</td> 
						<td>
						<select name="nome_pais">
						<?php
						include '../includes/ligacao.php';
						$nome_pais = mysql_query("SELECT * FROM pais_notin_delegacao");
						while($dados = mysql_fetch_array($nome_pais))
						{?>
						<option value="<?php echo $dados['nome_pais']; ?>"><?php echo $dados['nome_pais']; ?></option>
						<?php
						}
						mysql_close($conexao);
						?>
						</select>
						</td>
					</tr>
					<tr>
						<td>Nome do Responsável:</td> 
						<td> <input type="text" name="nome_responsavel" size="30" maxlength="30" required class="form"></td>
					</tr>
					<tr>
						<td>Login:</td> 
						<td> <input type="text" name="login" size="30" maxlength="30" required class="form"></td>
					</tr>
					<tr>
						<td>E-mail:</td> 
						<td> <input type="text" name="email" size="30" maxlength="60" required class="form"></td>
					</tr>
					<tr>
					<?php include '../includes/gerirpassword_co.php'; ?>
					<td style="visibility:hidden;display:hidden"><input type="password" name="password" size="20"  Value="<?php echo $password;?>" class="form"></td>
					</tr>
				</table>
				<button class="botao" type="submit">Validar</button>
				<input class="botao" type="reset" name="limpar" value="Limpar Campos" >
				<input class="botao" type="button" value="Voltar às Delegações" onclick="window.location.href='delegacao_co.php'">
			</form>
		</div>
		
		<!-- em baixo -->
		<?php include '../includes/rodape.php'; ?>	
		
		<!-- include para a mensagem popup -->
		<?php include '../includes/mensagem_popup.php';?>
		</div>
	</body>
</html>