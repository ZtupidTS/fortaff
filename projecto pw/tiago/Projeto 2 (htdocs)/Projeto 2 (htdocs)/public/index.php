<?php
	require_once '../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
?>

<?php
	$local = '';
	if (isset ($_GET['local']))
	{
		$local = $_GET['local'];
	} else {
		$local = 'London';
	}

?>
<!-- TEMPO -->
		<div id="tempo">
			<h3>Tempo</h3><a id="tempo_1">Tempo</a>
			<?php
				include_once rootPath('webservice/weather/index.php', 1);
			?>
		</div>
		<div id="eventos">
			<h3>Próximos Eventos</h3><a href="/pw606/public/eventos/index.php" target="_blank" id="eventos_1">Eventos</a>
			<table class="tableclass">
				<tr class="rowHeader">
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
	//$eventos = eventosGetByFiltro(null, array('X'));
	$eventos = eventosLastXEvents(null, array('X'), "0, 6");
	
	$alt = true;
	while ($row = mysql_fetch_array($eventos)) {
		$alt = !$alt;
?>		
			<tr class="<?= $alt ? "rowalternative" : "" ?>">
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
				<form action="/pw606/public/eventos/edit.php" method="post">
					<input type="hidden" name="id_evento" value="<?= $row['id_evento'] ?>" />
					<input type="image" alt="Edit" src="/pw606/img/view.png" title="Ver informação" onsubmit="submit-form();">
				</form>
			</td>
	</tr>
<?php
	}
?>
</table>
<!-- NOTICIAS -->
		</div>
		<div id="noticias">
			<div id="ttl_noticias">
				<h3>Notícias</h3><a href="/pw606/webservice/rss/rss_events.php" target="_blank" id="rss">RSS</a> 
				<?php
					include_once rootPath('webservice/rss/index.php', 1);
				?>	
			</div>
		</div>

<?php
	include_once rootPath('/includes/sijo/master_footer.php', 1);
?>