<?php include 'includes/cabecalho.php';?>
	<script type="text/javascript" language="javascript">
	function FiltroTabela()
	{
		window.location.href = "equipas.php";
	}
	</script>
	
	<!-- corpo -->
		<div class="titulo"> Equipas </div>
			<div id="filtro">
				<form method="post" action="equipas.php">
					<select name="pais">
						<?php
						$pais = mysql_query("SELECT distinct nome_pais, cod_delegacao FROM equipa_with_delegacao ORDER BY nome_pais ");
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
				$db = mysql_query("SELECT * FROM equipa_with_delegacao WHERE estado_valido = 'V' and cod_delegacao = '$_POST[pais]' ORDER BY nome_pais");
			}else{
				$db = mysql_query("SELECT * FROM equipa_with_delegacao WHERE estado_valido = 'V' ORDER BY nome_pais");
			}
			?>
			<table id="results">
					<tr>
						<th>Nº</th>
						<th>Modalidade</th>
						<th>Categoria</th>
						<th>Delegação</th>
						<th>Nº Total de Elementos</th>
					</tr>
					<?php
					$class = 'linha_impar';
					while($dados = mysql_fetch_array($db))
					{
						?>
						<tr class="<?php echo $class;?>">
							<td><?php echo $dados['cod_equipa']; ?></td>
							<td><?php echo $dados['nome_modalidade']; ?></td>
							<td><?php include '../includes/sexo_imagem.php';?></td>
							<td class="delegação_nome">
								<img src="../images/Bandeiras/<?= $dados['cod_delegacao'];?>.png" class="bandeiras"/>
								<?php echo $dados['nome_pais']; ?>
							</td>
							<td>
								<?php 
								$tot_elemento = mysql_query("SELECT total FROM total_elemento_equipa WHERE '$dados[cod_equipa]' = cod_equipa");
								if(mysql_num_rows($tot_elemento) == 0)
								{
									echo '0';
								}else{
									$dados2 = mysql_fetch_array($tot_elemento);
									echo $dados2['total'];
								}
								?>
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