<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
	include_once rootPath('includes/gijo/master_header.php', 1);
	require_once rootPath('co/check_login.php', 1);
?>
<h1 class="header_h1">
	Elementos
</h1>
<table id="tableresults" class="tableclass">
	<tr class="rowheader">
		<th>ID</th>
		<th>Nome</th>
		<th>Sexo</th>
		<th>Nascimento</th>
		<th>Estado</th>
		<th></th>
	</tr>
<?php
	$elementos = elementoGetByFiltro(-1, -1, null, array('X'));
	
	$delegacao = -1;
	$alt = false;
	while ($row = foreachRow($elementos)) {
		$alt = !$alt;
		if ($delegacao !== $row['id_delegacao']) {
			$delegacao = $row['id_delegacao'];
			$alt = false;
?>
	<tr class="rowgroup">
		<td colspan="6">
			<img src="/pw606/img/countries/16/<?= $row['id_pais'] ?>.png" />
			<b><?= $row['pais_nome'] ?><b>
		</td>
	</tr>
<?php
		}
?>
	<tr class="<?= $alt ? "rowalternative": "" ?>">
		<td><?= $row['id_elemento'] ?></td>
		<td>
			<img src="/pw606/img/elementos/<?= $row['tipo'] ?>.png" title="<?= $row['tipo_descricao'] ?>" />
			<?= $row['nome'] ?>
		</td>
		<td><?= $row['sexo'] ?></td>
		<td><?= $row['data_nascimento'] ?></td>
		<td>
			<img width="16" src="/pw606/img/status/<?= $row['status'] ?>.png" title="<?= $row['status_descricao'] ?>" />
			<?= $row['status_descricao'] ?>
		</td>
		<td> 
			<form action="edit.php" method="post">
				<input type="hidden" name="id_elemento" value="<?= $row['id_elemento'] ?>" />
				<input type="image"  src="/pw606/img/view.png" title="Ver informação" onsubmit="submit-form();">
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
		pager.funcGroup = function (row) {
			return row.hasClassName("rowgroup");
		}
</script>
<h1 class="footer_h1">
	<button type="button" onclick="parent.location.href='edit.php'" >Novo Atleta</button>
	<button type="button" onclick="parent.location.href='edit.php?auxiliar='" >Novo Auxiliar</button>
</h1>
<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>