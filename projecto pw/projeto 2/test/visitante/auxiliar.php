<?php include 'includes/cabecalho.php';?>
	<script type="text/javascript" language="javascript">
	function FiltroTabela()
	{
		window.location.href = "auxiliar.php";
	}
	</script>
		
	<!-- corpo -->
	<div class="titulo"> Auxiliares </div>
		<div id="filtro">
			<form method="post" action="auxiliar.php">
				<select name="pais">
					<?php
					$pais = mysql_query("SELECT distinct nome_pais, cod_delegacao FROM dados_auxiliares WHERE estado_valido = 'V'");
					while($dados_pais = mysql_fetch_array($pais))
					{?>
						<option value="<?= $dados_pais['cod_delegacao'];?>"><?= $dados_pais['nome_pais'];?></option>
						<?php
					}?>
				</select>
				<button type="submit">Filtrar</button>
				<button type="button" onclick="FiltroTabela()">Ver Tudo</button>
			</form>
		</div>
		
		<?php
		if(isset($_POST['pais']))
		{
			$db = mysql_query("SELECT * FROM dados_auxiliares WHERE cod_delegacao = '$_POST[pais]' and estado_valido = 'V' ORDER BY cod_equipa");
		}else{
			$db = mysql_query("SELECT * FROM dados_auxiliares WHERE estado_valido = 'V' ORDER BY cod_equipa");
		}
		?>
		<table id="results">
			<tr>
				<th>Nº da Equipa</th>
				<th>Nº do Auxiliar</th>
				<th>Nome</th>
				<th>Data de Nascimento</th>
				<th>Sexo</th>
				<th>Função</th>
				<th>Habilitações Literarias</th>
				<th>Delegação</th>
			</tr>
			<?php
			$class = 'linha_impar';
			while($dados = mysql_fetch_array($db))
			{
				?>
				<tr class="<?php echo $class;?>">
					<td><?php echo $dados['cod_equipa']; ?></td>
					<td><?php echo $dados['cod_elemento_equipa']; ?></td>
					<td><?php echo $dados['nome']; ?></td>
					<td><?php echo $dados['data_nasc']; ?></td>
					<td><?php include '../includes/sexo_imagem.php';?></td>
					<td><?php echo $dados['funcao']; ?></td>
					<td><?php echo $dados['habilit_literarias']; ?></td>
					<?php
					$db_delegacao = mysql_query ("SELECT * FROM delegacao WHERE cod_delegacao = '$dados[cod_delegacao]'");
					$dados_delegacao = mysql_fetch_array($db_delegacao);
					?>
					<td class="delegação_nome">
						<img src="../images/Bandeiras/<?= $dados_delegacao['cod_delegacao'];?>.png" class="bandeiras"/>
						<?php echo $dados_delegacao['nome_pais']; ?>
					</td>
				</tr>
				<?php
				$class = ($class == 'linha_par') ? 'linha_impar' : 'linha_par';
			}// fim do ciclo para escrever os dados na tabela
			?>
		</table>
		
		<?php include 'includes/paginacao_tabela.php';?>
		
		<!-- em baixo -->
		<?php include 'includes/rodape.php';?>
</html>