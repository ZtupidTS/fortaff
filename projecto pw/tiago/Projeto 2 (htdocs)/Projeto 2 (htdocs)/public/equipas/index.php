<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
	//require_once rootPath('co/check_login.php', 1);
?>
<h1 class="header_h1">Equipas</h1>
<table id="tableresults" class="tableclass">
	<tr class="rowheader">
		<th>ID</th>
		<th>Modalidade</th>
		<th title="Total Elementos (Elementos válidos)" >Elementos</th>
		<th>
		<!-- funil -->
			<form action="index.php" method="GET">
				<!--<input type="hidden" name="id_delegacao" value="<?= dbInteger(-1)?>" /> -->
				<input type="image" src="/pw606/img/funnel_delete.png" title="Retirar filtro" onsubmit="submit-form();">
			</form>
		</th>
	</tr>
<?php
	if (isset($_GET['id_delegacao'])){
		$id_delegacao = dbInteger($_GET['id_delegacao']);
	}	else {
		$id_delegacao = -1;
	}
	
	$delegacoes = delegacaoGetByFiltro($id_delegacao, null, array('X'));
	while ($deg = foreachRow($delegacoes)) {
?>
	<tr class="rowgroup">
		<td colspan="3">
			<img src="/pw606/img/countries/16/<?= $deg['id_pais'] ?>.png" />
			<b><?= $deg['pais_nome'] ?></b>
		</td>
		<td>
			<form action="index.php" method="GET">
				<input type="hidden" name="id_delegacao" value="<?= $deg['id_delegacao'] ?>" />
				<input type="image" src="/pw606/img/funnel_add.png" title="Filtrar" onsubmit="submit-form();">
			</form>
		</td>
	</tr>
<?php
		$alt = true;
		$equipas = equipaGetByFiltro($deg['id_delegacao'], null, array('X'));
		while ($row = foreachRow($equipas)) {
			$alt = !$alt;
?>
	<tr class="<?= $alt ? "rowalternative": "" ?>">
		<td><?= $row['id_equipa'] ?></td>
		<td>
			<img src="/pw606/img/modalidades/<?= $row['modalidade_tipo'] ?>.png" />
			<?= $row['modalidade_nome'] ?>
		</td>
		<td title="Total Elementos (Elementos válidos)" ><?= $row['total'] ?> (<?= $row['total_valid'] ?>)</td>
		<td> 
			<form action="edit.php" method="GET">
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
<div style="float:left;" id="pageNavPosition"></div>
<script type="text/javascript">
        var pager = new Pager('tableresults', <?= $lines_per_table ?>); 
        pager.init(); 
        pager.showPageNav('pager', 'pageNavPosition'); 
        pager.showPage(1);
		pager.funcGroup = function (row) {
			return row.hasClassName("rowgroup");
		}
</script>
<div class="fDireita">Total equipas = <?= equipaCount() ?></div>
<!-- <h1 class="footer_h1"></h1> -->
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>