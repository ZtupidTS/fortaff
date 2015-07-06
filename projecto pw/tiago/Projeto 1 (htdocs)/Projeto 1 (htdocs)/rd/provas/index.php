<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/html_header.php', 1);
	include_once rootPath('includes/master_header.php', 1);
	require_once rootPath('co/check_login.php', 1);
?>
<h1 class="header_h1">Provas</h1>
<?php
	if (isset($_SESSION['error_msg'])) {
?>
	<div class="warningmsg">
		<?= $_SESSION['error_msg'] ?>
	</div>
<?php
		unset($_SESSION['error_msg']);
	}
?>
<table id="tableresults" class="tableclass">
	<tr class="rowHeader">
		<th>ID</th>
		<th>Lugar</th>
		<th>Data</th>
		<th>Modalidade</th>
		<th title="Minutos (min)">Duração</th>
		<th title="Euros (€)">Preço</th>
		<th title="Lotação (Vendidos/Reservados)">Lotação</th>
		<th></th>
	</tr>
<?php
	$alt = true;
	$mods = provaGetByFiltro(-1, -1, null, array('X'));
	
	while ($row = foreachRow($mods)) {
		$alt = !$alt;
?>
	<tr class="<?= $alt ? 'rowalternative' : '' ?>">
		<td><?= $row['id_prova'] ?></td>
		<td title="<?= $row['local_descricao'] ?>"><?= $row['local_nome'] ?></td>
		<td><?= $row['data_hora'] ?></td>
		<td>
			<img src="/pw606/img/modalidades/<?= $row['modalidade_tipo'] ?>.png" />
			<?= $row['modalidade_nome'] ?>
		</td>
		<td><?= $row['duracao'] ?></td>
		<td><?= $row['preco_bilhete'] ?></td>
		<td title="Lotação (Vendidos/Reservados)">
			<?= $row['local_num_lugares'] . ' (' . $row['lugares_vendidos'] . '/' . $row['lugares_reservados'] . ')' ?>
		</td>
		<td> 
			<form action="edit.php" method="post">
				<input type="hidden" name="id_prova" value="<?= $row['id_prova'] ?>" />
				<input type="image" src="/pw606/img/view.png" onsubmit="submit-form();" />
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
<h1 class="footer_h1"></h1>
<?php
	include_once rootPath('includes/master_footer.php', 1);
?>