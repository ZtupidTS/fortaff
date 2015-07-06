<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
	include_once rootPath('includes/gijo/master_header.php', 1);
	require_once rootPath('co/check_login.php', 1);
?>
<h1 class="header_h1">
	Equipas
</h1>
<table id="tableresults" class="tableclass">
	<tr class="rowheader">
		<th>ID</th>
		<th>Modalidade</th>
		<th title="Total Elementos (Elementos válidos)" >Elementos</th>
		<th>Estado</th>
		<th></th>
	</tr>
<?php
	$delegacoes = delegacaoGetByFiltro(-1, null, array('X'));
	while ($deg = foreachRow($delegacoes)) {
?>
	<tr class="rowgroup">
		<td colspan="5">
			<img src="/pw606/img/countries/16/<?= $deg['id_pais'] ?>.png" />
			<b><?= $deg['pais_nome'] ?></b>
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
			<img src="/pw606/img/status/<?= $row['status'] ?>.png" title="<?= $row['status_descricao'] ?>" />
			<?= $row['status_descricao'] ?>
		</td>
		<td> 
			<form action="edit.php" method="post">
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
<h1 class="footer_h1">
	<input type="button" value="Nova Equipa" onclick="window.location = 'edit.php';" />
</h1>
<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>