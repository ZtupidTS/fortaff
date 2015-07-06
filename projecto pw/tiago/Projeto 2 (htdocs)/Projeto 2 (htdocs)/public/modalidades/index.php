<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
?>
<h1 class="header_h1">
	Modalidades
</h1>
<table id="tableresults" class="tableclass">
	<tr class="rowHeader">
		<th>ID</th>
		<th>Tipo</th>
		<th>Nome</th>
		<th></th>
	</tr>
<?php
	$alt = true;
	$mods = modalidadeGetByFiltro(null, array('X'));
	
	while ($row = foreachRow($mods)) {
		$alt = !$alt;
?>
	<tr class="<?= $alt ? 'rowalternative' : '' ?>">
		<td><?= $row['id_modalidade'] ?></td>
		<td><img src="/pw606/img/modalidades/<?= $row['tipo'] ?>.png" /></td>
		<td><?= $row['nome'] ?></td>
		<td> 
			<form action="modalidades_paises.php" method="GET">
				<input type="hidden" name="id_modalidade" value="<?= $row['id_modalidade'] ?>" />
				<input type="image" src="/pw606/img/view.png" title="Ver informação" onsubmit="submit-form();">
			</form>
		</td>
	</tr>
<?php
	}
?>
</table>
<div id="pageNavPosition"></div>
<script type="text/javascript">
        var pager = new Pager('tableresults', <?= $lines_per_table ?>); 
        pager.init(); 
        pager.showPageNav('pager', 'pageNavPosition'); 
        pager.showPage(1);
</script>
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>