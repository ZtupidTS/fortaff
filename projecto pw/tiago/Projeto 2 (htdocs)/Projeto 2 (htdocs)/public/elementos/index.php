<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
	//require_once rootPath('co/check_login.php', 1);
?>
<h1 class="header_h1">Elementos</h1>
<table id="tableresults" class="tableclass">
	<tr class="rowheader">
		<th>ID</th>
		<th>Nome</th>
		<th>Sexo</th>
		<th>Nascimento</th>
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
	} 	else {
		$id_delegacao = -1;
	}
	
	$elementos = elementoGetByFiltro($id_delegacao, -1, null, array('X'));
	$alt = false;
	$id_delegacao = -1;
	while ($row = foreachRow($elementos)) {
		$alt = !$alt;
		if ($id_delegacao !== $row['id_delegacao']) {
			$id_delegacao = $row['id_delegacao'];
			// $alt = false;
?>
	<tr class="rowgroup">
		<td colspan="4">
			<img src="/pw606/img/countries/16/<?= $row['id_pais'] ?>.png" />
			<b><?= $row['pais_nome'] ?><b>
		</td>
		<td>		
			<form action="index.php" method="GET">
				<input type="hidden" name="id_delegacao" value="<?= $id_delegacao['id_delegacao'] ?>" />
				<input type="image" src="/pw606/img/funnel_add.png" title="Filtrar" onsubmit="submit-form();">
			</form>
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
			<form action="edit.php" method="GET">
				<input type="hidden" name="id_elemento" value="<?= $row['id_elemento'] ?>" />
				<input type="image"  src="/pw606/img/view.png" title="Ver informação" onsubmit="submit-form();">
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
		pager.funcGroup = function (row) {
			return row.hasClassName("rowgroup");
		}
</script>
<div class="fDireita">&#9794; Atletas Masculinos = <?= elementoCount('A', 'M'); ?> | Auxiliares Masculinos = <?= elementoCount('X', 'M'); ?></div><br/>
<div class="fDireita">&#9792; Atletas Femininos = <?= elementoCount('A', 'F'); ?> | Auxiliares Femininos = <?= elementoCount('X', 'F'); ?></div><br/>
<div class="fDireita" style="margin-left:396px;">Total elementos = <?= elementoCount(); ?></div>
<!-- <h1 class="footer_h1"></h1> -->
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>