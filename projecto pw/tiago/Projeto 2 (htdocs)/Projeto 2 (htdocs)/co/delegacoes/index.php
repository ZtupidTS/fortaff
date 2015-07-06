<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
	include_once rootPath('includes/gijo/master_header.php', 1);
	require_once rootPath('co/check_login.php', 1);
?>

<?php
?>
<h1 class="header_h1">
	Delegações
</h1>
<table id="tableresults" class="tableclass">
	<tr class="rowHeader">
		<th>ID</th>
		<th>País</th>
		<th>Responsável</th>
		<th>Utilizador</th>
		<th>
			<img src="/pw606/img/goblet_gold.png" title="Ouro" />
		</th>
		<th>
			<img src="/pw606/img/goblet_silver.png" title="Prata" />
		</th>
		<th>
			<img src="/pw606/img/goblet_bronze.png" title="Bronze" />
		</th>
		<th>Estado</th>
		<th></th>
	</tr>
<?php	
	$tabela_delegacoes = delegacaoGetByFiltro(-1, null, array('X'));
		
	$alt = true;
	while ($row = mysql_fetch_array($tabela_delegacoes)) {
		$alt = !$alt;
?>		
	<tr class="<?= $alt ? "rowalternative" : "" ?>">
		<td><?= $row["id_delegacao"] ?></td>
		<td>
			<img src="/pw606/img/countries/16/<?= $row["id_pais"] ?>.png" />
			<?= $row["pais_nome"] ?>
		</td>
		<td><?= $row["nome_responsavel"] ?></td>
		<td><?= $row["login"] ?></td>
		<td><?= $row["ouro"] ?></td>
		<td><?= $row["prata"] ?></td>
		<td><?= $row["bronze"] ?></td>
		<td>
			<img type="image" src="/pw606/img/status/16/<?= $row["status"] ?>.png"/>
			<?= $row["status_descricao"] ?>
			<input type="hidden" name="status" value="<?= $row["status"] ?>" />
		</td>
		<td> 
			<form action="edit.php" method="post">
				<input type="hidden" name="id_delegacao" value="<?= $row['id_delegacao'] ?>" />
				<input type="image" alt="Edit" src="/pw606/img/view.png" title="Ver informação" onsubmit="submit-form();">
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
	<button onclick="parent.location='edit.php'" type="button">Nova Delegação</button>
</h1>
<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>