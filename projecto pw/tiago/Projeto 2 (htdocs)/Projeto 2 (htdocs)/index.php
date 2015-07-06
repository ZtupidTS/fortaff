<?php
	// header('location: co/index.php');
	require_once 'includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
	
	header('location: public/index.php');
	exit;
	
?>
<input type="button" value="Comité Olímpico" onclick="window.location='co/index.php'"/>
<input type="button" value="Responsável Delegação" onclick="window.location='rd/index.php'"/>
<br />
<br />
<h1 class="header_h1">
	Eventos TESTE
</h1>
<table class="tableclass">
	<tr class="rowHeader">
		<th>ID</th>
		<th>Designação</th>
		<th>Local</th>
		<th>Data/Hora</th>
		<th>Duração</th>
		<th>€/Bilhete</th>
		<th>Apreciação</th>
		<th>Lotação</th>
		<th> </th>
	</tr>
<?php	
	$eventos = eventosGetByFiltro(null, array('X'));
	$alt = true;
	while ($row = mysql_fetch_array($eventos)) {
		$alt = !$alt;
?>		
	<tr class="<?= $alt ? "rowalternative" : "" ?>">
		<td><?= $row["id_evento"] ?></td>
		<td><?= $row["designacao"] ?></td>
		<td><?= $row["local_nome"] ?></td>
		<td><?= $row["data_hora"] ?></td>
		<td> <?= $row["duracao"] ?></td>
		<td> <?= $row["preco_bilhete"] ?></td>
		<td>
<?php
	$_SESSION['rating_object']['id'] = 'ratingid' . $row["id_evento"];
	$_SESSION['rating_object']['name'] = 'ratingname' . $row["id_evento"];
	$_SESSION['rating_object']['value'] = $row["apreciacao"];
	$_SESSION['rating_object']['readonly'] = 'true';
	include rootPath('includes/rating_object.php', 1);
?>
		</td>
		<td title="Lotação (Vendidos/Reservados)"> <?= $row["num_lugares"] . ' (' . $row["lugares_vendidos"] .'/'. $row["lugares_reservados"] .')'?> </td>
		<td>
			<form action="edit.php" method="post">
				<input type="hidden" name="id_evento" value="<?= $row['id_evento'] ?>" />
				<input type="image" alt="Edit" src="/pw606/img/view.png" title="Ver informação" onsubmit="submit-form();">
			</form>
		</td>
	</tr>
<?php
	}
?>
</table>
<h1 class="footer_h1">

</h1>
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>