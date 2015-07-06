<?php include 'includes/cabecalho.php';?>
	
	
	<!-- corpo -->
		<div class="titulo"> Modalidades </div>
		<?php
		$db = mysql_query("SELECT * FROM modalidade WHERE estado_valido = 'V' ORDER BY nome_modalidade");
		?>
		<table id="results">
			<tr>
				<th>Modalidade</th>
				<th>Categoria</th>
				<th>Imagem</th>
			</tr>
			<?php
			$class = 'linha_impar';
			while($dados = mysql_fetch_array($db))
			{
				?>
				<tr class="<?php echo $class;?>">
					<td><?php echo $dados['nome_modalidade']; ?></td>
					<td>
						<?php
						$nome_modalidade = mysql_query("SELECT * FROM informacao_diversas WHERE id = '$dados[tipo]'");
						$tipo_modalidade = mysql_fetch_array($nome_modalidade);
						echo $tipo_modalidade['informacao']; 
						?>
					</td>
					<td>
						<img class="modalidades" src="../images/modalidades/<?= $dados['nome_modalidade'];?>.png" alt="<?= $dados['nome_modalidade'];?>" title="<?= $dados['nome_modalidade'];?>" />
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