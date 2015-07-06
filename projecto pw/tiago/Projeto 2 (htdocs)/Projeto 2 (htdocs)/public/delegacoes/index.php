<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
	//require_once rootPath('co/check_login.php', 1);
?>

<?php
?>
<h1 class="header_h1">Delegações</h1>
<table id="tableresults" class="tableclass">
	<tr class="rowHeader">
		<th>ID</th>
		<th>País</th>
		<th>Responsável</th>
		<th title="Número de Atletas (Masculinos/Femininos)">Atletas</th>
		<th title="Número de Auxiliares (Masculinos/Femininos)">Auxiliares</th>
		<th>Média Idades</th>
		<th>
			<img src="/pw606/img/goblet_gold.png" title="Ouro" />
		</th>
		<th>
			<img src="/pw606/img/goblet_silver.png" title="Prata" />
		</th>
		<th>
			<img src="/pw606/img/goblet_bronze.png" title="Bronze" />
		</th>
		<th></th>
	</tr>
<?php	
	$tabela_delegacoes = delegacaoGetByFiltro(-1, null, array('X'));
		
	$alt = true;
	while ($row = mysql_fetch_array($tabela_delegacoes)) {
		$alt = !$alt;
		$num_atletas = elementoCount("A","", $row["id_delegacao"]);
		$num_atletas_masc = elementoCount("A","M", $row["id_delegacao"]);
		$num_atletas_fem = elementoCount("A","F", $row["id_delegacao"]);
		$num_auxiliares = elementoCount("X","", $row["id_delegacao"]);
		$num_auxiliares_masc = elementoCount("X","M", $row["id_delegacao"]);
		$num_auxiliares_fem = elementoCount("X","F", $row["id_delegacao"]);
?>		
	<tr class="<?= $alt ? "rowalternative" : "" ?>">
		<td><?= $row["id_delegacao"] ?></td>
		<td>
			<img src="/pw606/img/countries/16/<?= $row["id_pais"] ?>.png" />
			<?= $row["pais_nome"] ?>
		</td>
		<td><?= $row["nome_responsavel"] ?></td>
		<td><?= $num_atletas ?> (<?= $num_atletas_masc ?>/<?= $num_atletas_fem ?>)</td>
		<td><?= $num_auxiliares ?> (<?= $num_auxiliares_masc ?>/<?= $num_auxiliares_fem ?>)</td>
		<td><?= $row["media_idade"] ?></td>
		<td><?= $row["ouro"] ?></td>
		<td><?= $row["prata"] ?></td>
		<td><?= $row["bronze"] ?></td>
		<td> 
		<!-- apontador para ver a equipa escolhida 		-->
			<form action="../equipas/index.php" method="GET">
				<input type="hidden" name="id_delegacao" value="<?= $row['id_delegacao'] ?>" />
				<input type="image" src="/pw606/img/view.png" title="Ver informação" onsubmit="submit-form();">
			</form>

		</td>
	</tr>

<?php
	}
?>
</table>
<div style="float:left;" id="pageNavPosition"></div>
<script type="text/javascript">
        var pager = new Pager('tableresults', <?= $lines_per_table ?>); 
        pager.init(); 
        pager.showPageNav('pager', 'pageNavPosition'); 
        pager.showPage(1);
</script>
<div class="fDireita">Total delegações = <?= delegacaoCount() ?></div>
<!-- <h1 class="footer_h1"></h1> -->
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>