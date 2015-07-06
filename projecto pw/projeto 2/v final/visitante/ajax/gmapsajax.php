<html>
	<body>
	
	<?php
	header("Content-Type: text/html;  charset=ISO-8859-1",true);
	include '../../includes/ligacao.php';
	if($_GET['tipo'] == 'Provas')
	{
		$db = mysql_query("SELECT * FROM prova WHERE estado_valido = 'V'");
		?>
		<select name="ponto" id="ponto" onChange="setCenter()">
		<?php
		while($dados = mysql_fetch_array($db))
		{
			$db2 = mysql_query("SELECT * FROM modalidade WHERE cod_modalidade = '$dados[cod_modalidade]'");
			$modal = mysql_fetch_array($db2);
			?>
			<option value="<?= $dados['lat'];?>,<?= $dados['lng'];?>">
				<?= $modal['nome_modalidade'].' as '.$dados['hora_inicio'].' no dia '.$dados['data'];?>
			</option>
			<?php
		}?>
		</select>
		<?php
	}else{
		$db = mysql_query("SELECT * FROM evento WHERE estado_valido = 'V'");
		?>
		<select name="ponto" id="ponto" onChange="setCenter()">
		<?php
		while($dados = mysql_fetch_array($db))
		{
			?>
			<option value="<?= $dados['lat'];?>,<?= $dados['lng'];?>">
				<?= $dados['designacao'].': '.$dados['descricao'].' as '.$dados['hora_inicio']." no dia ".$dados['data'];?>
			</option>
			<?php
		}?>
		</select>
		<?php
	}
	?>	
	</body>
</html>
	