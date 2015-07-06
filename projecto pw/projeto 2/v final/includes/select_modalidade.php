<select name="cod_modalidade">
	<?php
	include '../includes/ligacao.php';
	$modalidade = mysql_query("SELECT * FROM modalidade WHERE estado_valido != 'X' ORDER BY nome_modalidade");
	while($dados_modalidade = mysql_fetch_array($modalidade))
	{?>
		<option value="<?= $dados_modalidade['cod_modalidade'];?>"><?= $dados_modalidade['nome_modalidade'];?></option>
		<?php
	}?>
</select>