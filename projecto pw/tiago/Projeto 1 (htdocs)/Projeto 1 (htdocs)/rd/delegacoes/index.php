<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/html_header.php', 1);
	include_once rootPath('includes/master_header.php', 1);
	require_once rootPath('co/check_login.php', 1);
?>

<?php
?>
<h1 class="header_h1">
	Delegações
</h1>
<table id="tblresults" class="tableclass">
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
	$del = delegacaoGetByFiltro(-1, null, array('X'));
	$alt = true;
	while ($row = mysql_fetch_array($del)) {
		$alt = !$alt;
		$isMeDelegacao = ($row['id_delegacao'] == $current_user['id_delegacao']);
?>		
	<tr class="<?= $alt ? "rowalternative" : "" ?>">
		<td><?= $row["id_delegacao"] ?></td>
		<td>
			<img src="/pw606/img/countries/16/<?= $row["id_pais"] ?>.png" />
			<?= $row["pais_nome"] ?>
		</td>
		<td><?= $row["nome_responsavel"] ?></td>
		<td><?= $isMeDelegacao ? $row["login"] : '---' ?></td>
		<td><?= $row["ouro"] ?></td>
		<td><?= $row["prata"] ?></td>
		<td><?= $row["bronze"] ?></td>
		<td>
			<img type="image" src="/pw606/img/status/16/<?= $isMeDelegacao ? $row["status"] : 'X' ?>.png"/>
			<?= $isMeDelegacao ? $row["status_descricao"] : '' ?>
		</td>
		<td> 
<?php
		if ($isMeDelegacao) {
?>
			<form action="edit.php" method="post">
				<input type="hidden" name="id_delegacao" value="<?= $row['id_delegacao'] ?>" />
				<input type="image" alt="Edit" src="/pw606/img/view.png" onsubmit="submit-form();">
			</form>
<?php
		}
?>
		</td>
	</tr>
<?php
	}
?>
</table>
<div id="pageNavPosition"></div>
<script type="text/javascript">
        var pager = new Pager('tblresults', <?= $lines_per_table ?>); 
        pager.init(); 
        pager.showPageNav('pager', 'pageNavPosition'); 
		pager.showPage(1);
</script>
<h1 class="footer_h1">
</h1>
<?php
	include_once rootPath('includes/master_footer.php', 1);
?>