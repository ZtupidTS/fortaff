<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
	include_once rootPath('includes/gijo/master_header.php', 1);
	require_once rootPath('co/check_login.php', 1);
?>
<h1 class="header_h1">
	Locais
</h1>
<table id="tableresults" class="tableclass">
	<tr class="rowHeader">
		<th>ID</th>
		<th>Nome</th>
		<th>Lotação</th>
		<th></th>
	</tr>
<?php	
		$locais = localGetByFiltro(null, array('X'));
		$alt = true;
		while ($row = mysql_fetch_array($locais)) {
			$alt = !$alt;
?>		
		<tr class="<?= $alt ? "rowalternative" : "" ?>">
			<td><?= $row["id_local"] ?></td>
			<td title="<?= $row["descricao"] ?>"><?= $row["nome"] ?></td>
			<td><?= $row["num_lugares"] ?></td>
			<td> 
				<form action="edit.php" method="post">
					<input type="hidden" name="id_local" value="<?= $row['id_local'] ?>" />
					<input type="image" alt="Edit" src="/pw606/img/view.png" title="Ver informação" onsubmit="submit-form();" />
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
<h1 class="footer_h1">
	<button type="button" onclick="parent.location.href='edit.php'" >Novo Local</button>
</h1>
<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>