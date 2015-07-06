<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
	//require_once rootPath('co/check_login.php', 1);
?>
<?php
	
	if (isset($_SESSION['prova_post']) and isset($_SESSION['prova_post']['id_prova'])) {
		$_POST['id_prova'] = $_SESSION['prova_post']['id_prova'];
		unset($_SESSION['prova_post']);
	}
	
	$update = isset($_POST['id_prova']);
	$pv = null;
	$id_prova = "-1";
	$status = 'V';
	$status_descricao = estadoGetDescricao($status);
	$id_local = '-1';
	$local_nome = '';
	$local_descricao = '';
	$designacao = '';
	$prova_id_modalidade = '-1';
	$prova_modalidade_nome = '';
	$prova_modalidade_tipo = 'S';
	$data_hora = '';
	$duracao = '';
	$nome_juiz = '';
	$preco_bilhete = '';
	$lugares_reservados = '';
	$lugares_vendidos = '';
	
	if ($update) {
		$pv = provaGet($_POST['id_prova']);
		
		$id_prova = $pv['id_prova'];
		$designacao = $pv['designacao'];
		$status = $pv['status'];
		$status_descricao = $pv['status_descricao'];
		$id_local = $pv['id_local'];
		$local_nome = $pv['local_nome'];
		$local_descricao = $pv['local_descricao'];
		$prova_id_modalidade = $pv['id_modalidade'];
		$prova_modalidade_nome = $pv['modalidade_nome'];
		$prova_modalidade_tipo = $pv['modalidade_tipo'];
		$data_hora = $pv['data_hora'];
		$duracao = $pv['duracao'];
		$nome_juiz = $pv['nome_juiz'];
		$preco_bilhete = $pv['preco_bilhete'];
		$lugares_reservados = $pv['lugares_reservados'];
		$lugares_vendidos = $pv['lugares_vendidos'];
	
	}
	
	$isPendente = in_array($status, array('D', 'I', 'U'));
	$isRejected = ($status == 'R');
	$isNew = ($id_prova == '-1');
	$isValid = ($status == 'V');
	
?>
<h1 class="header_h1">Prova</h1>
<div style="float: left; margin-right: 100px;">
		<table>
			<tr>
				<td>ID:</td>
				<td>
					<input type="text" value="<?= $id_prova ?>" readonly="readonly" />
					<input type="hidden" name="id_prova" value="<?= $id_prova ?>" />
					<input type="hidden" name="status" value="<?= $status ?>" />
				</td>
			</tr>
			<tr>
				<td>Local:</td>
				<td>
					<select id="slt_local" name="id_local" disabled="disabled">
<?php
		$locais = localGetByFiltro(null, array('X'));
		while ($local = foreachRow($locais)) {
?>
						<option value="<?= $local['id_local'] ?>" ><?= $local['nome'] ?></option>
<?php
		}
?>
					</select>
					<script type="text/javascript">
						selectSelectedValue(document.getElementById('slt_local'), "<?= $id_local ?>" )
					</script>
				</td>
			</tr>
			<tr>
				<td>Modalidade:</td>
				<td>
<?php
	if ($update) {
?>
					<input type="hidden" name="id_modalidade" value="<?= $prova_id_modalidade ?>" readonly="readonly"/>
					<img src="/pw606/img/modalidades/<?= $prova_modalidade_tipo ?>.png" />
					<?= $prova_modalidade_nome ?>
<?php
	} else {
?>
				<select id="slt_modalidade" name="id_modalidade" disabled="disabled">
<?php
		$modalidades = modalidadeGetByFiltro(null, array('X'));
		while ($mod = foreachRow($modalidades)) {
?>
					<option value="<?= $mod['id_modalidade'] ?>" ><?= $mod['nome'] ?></option>
<?php
		}
?>
				</select>
				<script type="text/javascript">
					selectSelectedValue(document.getElementById('slt_modalidade'), "<?= $id_modalidade ?>" )
				</script>
<?php
	}
?>
				</td>
			</tr>
			<tr>
				<td>Data/Hora:</td>
				<td>
					<input type="text" name="data_hora" value="<?= $data_hora ?>" readonly="readonly" />
					<span id="validatorDataHora" class="validatorField" title="A data tem de esta no formato 'yyyy-MM-dd HH:mm:ss'!">*</span>
				</td>
			</tr>
			<tr>
				<td>Duração (min):</td>
				<td>
					<input type="text" name="duracao" value="<?= $duracao ?>" readonly="readonly"/>
					<span id="validatorDuracao" class="validatorField" title="A duração tem de ser um valor numérico!">*</span>
				</td>
			</tr>
			<tr>
				<td>Juiz:</td>
				<td>
					<input type="text" name="nome_juiz" value="<?= $nome_juiz ?>" readonly="readonly"/>
					<span id="validatorJuiz" class="validatorField" title="O nome do juiz é de preenchimento obrigatório!">*</span>
				</td>
			</tr>
			<tr>
				<td>Preço (€):</td>
				<td>
					<input type="text" name="preco_bilhete" value="<?= $preco_bilhete ?>" readonly="readonly"/>
					<span id="validatorPreco" class="validatorField" title="O preço tem de ser um valor numérico!">*</span>
				</td>
			</tr>
			<tr>
				<td>Lugares Vendidos:</td>
				<td>
					<input type="text" name="lugares_vendidos" value="<?= $lugares_vendidos ?>" readonly="readonly"/>
					<span id="validatorVendidos" class="validatorField" title="O número de lugares vendidos tem de ser um valor numérico!">*</span>
				</td>
			</tr>
			<tr>
				<td>Lugares Reservados:</td>
				<td>
					<input type="text" name="lugares_reservados" value="<?= $lugares_reservados ?>" readonly="readonly"/>
					<span id="validatorReservados" class="validatorField" title="A número de lugares reservados tem de ser um valor numérico!">*</span>
				</td>
			</tr>
<?php
	if ($user_authenticated) {
?>
		<tr>
			<td>
				<label>Bilhetes:</label>
			</td>
			<td>
				<form name="evento" action="/pw606/myacount/ticket/buy.php" method="post">
					<input type="hidden" name="acontecimento" value="P" />
					<input type="hidden" name="id_entidade" value="<?= $id_prova ?>" />
					<input type="hidden" name="nome" value="<?= $designacao ?>" />
					<input type="hidden" name="data" value="<?= $data_hora ?>" />
					<input type="hidden" name="duracao" value="<?= $duracao ?>" />
					<input type="hidden" name="id_local" value="<?= $id_local ?>" />
					<input type="hidden" name="id_visitante" value="<?= $current_user['id_visitante'] ?>" />
					<input type="submit" name="tipo" value="Comprar" />
					<input type="submit" name="tipo" value="Reservar" />
					<input type="hidden" name="preco" value="<?= $preco_bilhete ?>" />
				</form>
			</td>
		</tr>
<?php
 }
 $local = localGet($id_local);
?>		
		</table>
	</form>
</div>
<div id="mapG" style="height:400px; width:400px;"></div>
<script type="text/javascript">
	map = new createGoogleMaps($("mapG"));
	p = map.addPoint(<?= $local['latitude'] ?>, <?= $local['longitude'] ?>, "asdsdsd");
	map.setCenter(p.lat(), p.lng());
</script>
<hr/>
<h2><?= $prova_modalidade_tipo == 'C' ? 'Equipas inscritas' : 'Atletas inscritos' ?></h2>
<table id="tblprova" class="tableclass">
	<tr>
		<th>ID</th>
		<th>Classificação</th>
		<th>Nome</th>
		<th>País</th>
	<tr>
<?php
	if ($prova_modalidade_tipo == 'C') {
		$entidades = provaClassificacaoEquipaGetByFiltro($id_prova, null, array('X'));
	} else {
		$entidades = provaClassificacaoElementoGetByFiltro($id_prova, null, array('X'));	
	}

	$alt = true;
	while ($row = foreachRow($entidades)) {
		$alt = !$alt;
?>
	<tr class="<?= $alt ? "rowalternative": "" ?>">
		<td><?= $row['id_classificacao'] ?></td>
		<td>
			<span id="classificacao<?= $row['id_classificacao'] ?>" >
				<?= $row['classificacao'] == 99999 ? "---" : $row['classificacao'] ?>
			</span>
		</td>
<?php
		if ($prova_modalidade_tipo == 'C') {
			// ENTIDADE COLECTIVA
?>
		<td><?= $row['equipa_modalidade_nome'] ?></td>
<?php
		} else {
			// ENTIDADE SINGULAR
?>
		<td><?= $row['elemento_nome'] ?></td>
<?php
		}
?>
		<td>
			<img src="/pw606/img/countries/16/<?= $row['id_pais'] ?>.png" />
			<?= $row['pais_nome'] ?>
		</td>
	</tr>
<?php
	}
?>
</table>
<div id="pageNavPositionProva"></div>
<script type="text/javascript">
        var pagerProva = new Pager('tblprova', <?= $lines_per_table ?>); 
        pagerProva.init(); 
        pagerProva.showPageNav('pagerProva', 'pageNavPositionProva'); 
		pagerProva.funcGroup = function (row) {
			return row.hasClassName("rowgroup");
		}
		pagerProva.showPage(1);
</script>
<br/>
<a href="index.php" class="seta-invertida" style="margin-top:10px;">Voltar</a>
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>