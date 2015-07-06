<?php 
session_start(); 
include '../includes/test_intruso_rd.php';
unset($_SESSION['elemento_a_alterar']);
unset($_SESSION['nome']);
unset($_SESSION['funcao']);				
unset($_SESSION['habilit_literarias']);			
unset($_SESSION['sexo']);
unset($_SESSION['dia']);
unset($_SESSION['mes']);
unset($_SESSION['ano']);

include '../includes/ligacao.php';
include '../includes/limit30.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Jogos Olimpicos 2012</title>
		<link href="../css/estilo_rd.css" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<link rel="shortcut icon" href="../images/ico.ico">
		<script language="javascript">
		function Elimina(nome, cod)
		{
			if(confirm('Deseja Eliminar o auxiliar "'+nome+'"?'))
			{
				window.location.href = "verif_el_aux_atl_rd.php?cod_elemento_equipa="+cod;
			}
		}
		<?php include '../js/limit30.js';?>
		</script>
	</head>
	
	<body onLoad="Limita30('<?= $data_devolvida;?>');">
		<div class="estrutura">
			<!-- cabeçalho -->
			<?php include '../includes/cabecalho_rd.php';?>
			
			<!-- menu a direita -->
			<?php include '../includes/bandeira.php';?>	
			
			<!-- corpo -->
			<div class="estrutabela">
				<h1 class="titulo_rd">Auxiliares</h1>
				<?php
				if(isset($_POST['cod_equipa']))
				{
					$_SESSION["cod_equipa"] = $_POST['cod_equipa']; 
				}#Recebe o cod_equipa pelo POST e coloca-a numa variável de sessão
				#include '../includes/ligacao.php';
				$db_equipa = mysql_query("SELECT * FROM dados_auxiliares where cod_delegacao='$_SESSION[cod_delegacao_utilizador]' and cod_equipa = '$_SESSION[cod_equipa]' ");
				?>
				<table class="tabela">
					<tr>
						<th>Nome</th>
						<th>Data Nascimento</th>
						<th>Sexo</th>
						<th>Função</th>
						<th>Habilitações</th>
						<th>Estado</th>	
						<th name="limit30" id="limit30">Alterar</th>
						<th name="limit30" id="limit30">Eliminar</th>
					</tr>
					<?php
					$db_elemento = mysql_query("SELECT * FROM elemento_in_equipa where cod_equipa ='$_SESSION[cod_equipa]' and estado_valido != 'X'");
					while($dados2 = mysql_fetch_array($db_elemento))
					{
						$db_auxiliar = mysql_query("SELECT * FROM dados_auxiliares WHERE cod_elemento_equipa = '$dados2[cod_elemento_equipa]'and cod_equipa ='$_SESSION[cod_equipa]' and estado_valido != 'X'");
						#verifica se é um auxiliar
						if(mysql_num_rows($db_auxiliar) > 0)
						{
						$dados = mysql_fetch_array($db_auxiliar);
						?>
						<tr>
							<td><?php echo $dados['nome']; ?></td>
							<td><?php echo $dados['data_nasc']; ?></td>
							<td><?php echo $dados['sexo']; ?></td>
							<td><?php echo $dados['funcao']; ?></td>
							<td><?php echo $dados['habilit_literarias']; ?></td>
							<td><?php include '../includes/image_val_pen.php';?></td>
							<!-- alterar auxiliar -->
							<form method="post" action="alt_auxiliar_rd.php">
								<td style="visibility:hidden; display:none"><input type="text" name="cod_elemento_equipa" value="<?php echo $dados['cod_elemento_equipa']; ?>"></td>
								<td name="limit30" id="limit30"><button class="botão_opções" type="submit"><img src="../images/altera.png" name="Altera" alt="Altera" title="Altera"/></button></td>
							</form>	
							<!-- eliminar auxiliar -->
							<td name="limit30" id="limit30"><button class="botão_opções" type="button" onclick="Elimina('<?= $dados['nome'];?>', '<?= $dados['cod_elemento_equipa'];?>')"><img src="../images/eliminar.png" name="eliminar" alt="Eliminar" title="Eliminar"/></button></td>
						</tr>
						<?php
						}
					}
					mysql_close($conexao);
					?>	
				</table>
				<!-- os botões -->
				<input type="button" name="limit30" id="limit30" value="Acrescentar Auxiliar" onclick="window.location.href='acrescentar_auxiliar_rd.php'" class="botao">
				<input type="button" value="Actualizar" onclick="window.location.href='auxiliares_rd.php'" class="botao">
				<input type="button" value="Voltar" onclick="window.location.href='area_gestao_rd.php'" class="botao">
			</div>	
			
			<!-- em baixo --> 
			<?php include '../includes/rodape_rd.php';?>
		</div>	
	</body>	
</html>	