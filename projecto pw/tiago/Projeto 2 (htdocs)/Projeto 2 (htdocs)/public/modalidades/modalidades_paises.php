<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
?>
<h1 class="header_h1">
	Países inscritos em cada Modalidade
</h1>


<table id="tableresults" class="tableclass">
	<tr class="rowheader">
		<th>ID</th>
		<th>País</th>
		<th title="Total Elementos (Elementos válidos)" >Elementos</th>
		<th>
		<!-- funil -->
			<form action="modalidades_paises.php" method="GET">
				<input type="hidden" name="id_modalidade" value=-1 />
				<input type="image" src="/pw606/img/funnel_delete.png" title="Retirar filtro" onsubmit="submit-form();">
			</form>
		</th>
	</tr>
<?php
	if (isset($_GET['id_modalidade']) && ($_GET['id_modalidade']!=-1)){
		$id_modalidade = dbInteger($_GET['id_modalidade']);
	}	else {
		$id_modalidade = -1;
	}
	
	$modalidades = modalidadeGetByFiltro2($id_modalidade,null, array('X'));
	
	while ($modalidade_linha = foreachRow($modalidades)) {
?>
	<tr class="rowgroup">
		<td colspan="3">
			<b><?= $modalidade_linha['nome'] ?></b>
		</td>
		<td>
			<form action="modalidades_paises.php" method="GET">
				<input type="hidden" name="id_modalidade" value="<?= $modalidade_linha['id_modalidade'] ?>" />
				<input type="image" src="/pw606/img/funnel_add.png" title="Filtrar" onsubmit="submit-form();">
			</form>
		</td>
	</tr>
<?php
		$alt = true;
		$equipas = equipasPorModalidade($modalidade_linha['id_modalidade'], null, array('X'));
		while ($row = foreachRow($equipas)) {
			$alt = !$alt;
?>
	<tr class="<?= $alt ? "rowalternative": "" ?>">
		<td><?= $row['id_equipa'] ?></td>
		<td>
		<!-- imagem do país -->
			<img src="/pw606/img/countries/16/<?= $row['id_pais'] ?>.png" />
			<?= $row['pais_nome'] ?>
		</td>
		<td title="Total Elementos (Elementos válidos)" ><?= $row['total'] ?> (<?= $row['total_valid'] ?>)</td>
		<td> 
			<form action="../equipas/edit.php" method="GET">
				<input type="hidden" name="id_equipa" value="<?= $row['id_equipa'] ?>" />
				<input type="image" src="/pw606/img/view.png" title="Ver informação" onsubmit="submit-form();">
			</form>
		</td>
	</tr>
<?php
		}
	}
?>
</table>
<div id="pageNavPosition"></div>
<script type="text/javascript">
        var pager = new Pager('tableresults', <?= $lines_per_table ?>); 
        pager.init(); 
        pager.showPageNav('pager', 'pageNavPosition'); 
        pager.showPage(1);
		pager.funcGroup = function (row) {
			return row.hasClassName("rowgroup");
		}
</script>
<a href="index.php" class="seta-invertida" style="margin-top:10px;">Voltar</a>
<!-- <h1 class="footer_h1"></h1> -->
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>