<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
	include_once rootPath('includes/gijo/master_header.php', 1);
	require_once rootPath('rd/check_login.php', 1);
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
<form name="prova" action="edit_db.php" method="post">
	<table>
		<tr>
			<td>ID:</td>
			<td>
				<input type="text" value="<?= $id_prova ?>" disabled="disabled" />
				<input type="hidden" name="id_prova" value="<?= $id_prova ?>" />
				<input type="hidden" name="status" value="<?= $status ?>" />
			</td>
		</tr>
		<tr>
			<td>Local:</td>
			<td>
				<select id="slt_local" name="id_local">
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
				<input type="hidden" name="id_modalidade" value="<?= $prova_id_modalidade ?>" />
				<img src="/pw606/img/modalidades/<?= $prova_modalidade_tipo ?>.png" />
				<?= $prova_modalidade_nome ?>
<?php
	} else {
?>
				<select id="slt_modalidade" name="id_modalidade" <?= $update ? 'disabled="disabled"' : ''; ?> >
<?php
		$modalidades = modalidadeGetAll();
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
				<input type="text" name="data_hora" value="<?= $data_hora ?>" />
				<span id="validatorDataHora" class="validatorField" title="A data tem de esta no formato 'yyyy-MM-dd HH:mm:ss'!">*</span>
			</td>
		</tr>
		<tr>
			<td>Duração:</td>
			<td>
				<input type="text" name="duracao" value="<?= $duracao ?>" />
				<span id="validatorDuracao" class="validatorField" title="A duração tem de ser um valor numérico!">*</span>
			</td>
		</tr>
		<tr>
			<td>Juiz:</td>
			<td>
				<input type="text" name="nome_juiz" value="<?= $nome_juiz ?>" />
				<span id="validatorJuiz" class="validatorField" title="O nome do juiz é de preenchimento obrigatório!">*</span>
			</td>
		</tr>
		<tr>
			<td>Preço:</td>
			<td>
				<input type="text" name="preco_bilhete" value="<?= $preco_bilhete ?>" />
				<span id="validatorPreco" class="validatorField" title="O preço tem de ser um valor numérico!">*</span>
			</td>
		</tr>
		<tr>
			<td>Lugares Vendidos:</td>
			<td>
				<input type="text" name="lugares_vendidos" value="<?= $lugares_vendidos ?>" />
				<span id="validatorVendidos" class="validatorField" title="O número de lugares vendidos tem de ser um valor numérico!">*</span>
			</td>
		</tr>
		<tr>
			<td>Lugares Reservados:</td>
			<td>
				<input type="text" name="lugares_reservados" value="<?= $lugares_reservados ?>" />
				<span id="validatorReservados" class="validatorField" title="A número de lugares reservados tem de ser um valor numérico!">*</span>
			</td>
		</tr>
	</table>
	<input type="button" value="Cancelar" onclick="window.location = 'index.php';" />	
</form>
<hr/>
<h2><?= $prova_modalidade_tipo == 'C' ? 'Equipas não inscritas' : 'Atletas não inscritos' ?></h2>
<table id="tblElementos" class="tableclass">
	<tr>
		<th>ID</th>
		<th>Nome</th>
<?php
	if ($prova_modalidade_tipo == 'S') {
?>
		<th>Sexo</th>
		<th>Nascimento</th>	
<?php
	}
?>
		<th>Estado</th>
		<th></th>
	</tr>
<?php
	if ($prova_modalidade_tipo == 'C') {
		$entidades = equipaNaoInscritaEmProva($id_prova, $prova_id_modalidade, $current_user['id_delegacao']);
	} else {
		$entidades = elementoNaoInscritoEmProva($id_prova, $prova_id_modalidade, $current_user['id_delegacao']);	
	}

	$delegacao = -1;
	$alt = false;
	while ($row = foreachRow($entidades)) {
		$alt = !$alt;
		if ($delegacao !== $row['id_delegacao']) {
			$delegacao = $row['id_delegacao'];
			$alt = false;
?>
	<tr class="rowgroup">
		<td colspan="<?= $prova_modalidade_tipo == 'S' ? '6' : '4' ?>">
			<img src="/pw606/img/countries/16/<?= $row['id_pais'] ?>.png" />
			<b><?= $row['pais_nome'] ?><b>
		</td>
	</tr>
<?php
		}
?>
	<tr class="<?= $alt ? "rowalternative": "" ?>">
<?php
		if ($prova_modalidade_tipo == 'C') {
			// ENTIDADE COLECTIVA
?>
		<td><?= $row['id_equipa'] ?></td>
		<td><?= $row['modalidade_nome'] ?></td>
		<td>
			<img src="/pw606/img/status/<?= $row['status'] ?>.png" title="<?= $row['status_descricao'] ?>" />
			<?= $row['status_descricao'] ?>
		</td>
		<td> 
			<form action="edit_db.php" method="post">
				<input type="hidden" name="id_prova" value="<?= $id_prova ?>" />
				<input type="hidden" name="prova_modalidade_tipo" value="<?= $prova_modalidade_tipo ?>" />
				<input type="hidden" name="id_entidade" value="<?= $row['id_equipa'] ?>" />
				<input type="submit" name="inscrever" value="Inscrever" />
			</form>
		</td>
<?php
		} else {
			//ENTIDADE SINGULAR
?>
		<td><?= $row['id_elemento'] ?></td>
		<td>
			<img src="/pw606/img/elementos/<?= $row['tipo'] ?>.png" />
			<?= $row['nome'] ?>
		</td>
		<td><?= $row['sexo'] ?></td>
		<td><?= $row['data_nascimento'] ?></td>
		<td>
			<img src="/pw606/img/status/<?= $row['status'] ?>.png" title="<?= $row['status_descricao'] ?>" />
			<?= $row['status_descricao'] ?>
		</td>
		<td> 
			<form action="edit_db.php" method="post">
				<input type="hidden" name="id_prova" value="<?= $id_prova ?>" />
				<input type="hidden" name="prova_modalidade_tipo" value="<?= $prova_modalidade_tipo ?>" />
				<input type="hidden" name="id_entidade" value="<?= $row['id_elemento'] ?>" />
				<input type="submit" name="inscrever" value="Inscrever" />
			</form>
		</td>
<?php
		}
?>
	</tr>
<?php
	}
?>
</table>
<div id="pageNavPositionElementos"></div>
<script type="text/javascript">
        var pagerElm = new Pager('tblElementos', <?= $lines_per_table ?>); 
        pagerElm.init(); 
        pagerElm.showPageNav('pagerElm', 'pageNavPositionElementos'); 
		pagerElm.funcGroup = function (row) {
			return row.hasClassName("rowgroup");
		}
		pagerElm.showPage(1);
</script>
<br/>
<h2><?= $prova_modalidade_tipo == 'C' ? 'Equipas inscritas' : 'Atletas inscritos' ?></h2>
<table id="tblprova" class="tableclass">
	<tr>
		<th>ID</th>
		<th>Inscrição</th>
		<th>Classificação</th>
		<th>Nome</th>
		<th>País</th>
		<th></th>
	</tr>
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
<?php
		if ($prova_modalidade_tipo == 'C') {
			// ENTIDADE COLECTIVA
?>
		<td><?= $row['id_classificacao'] ?></td>
		<td>
			<img src="/pw606/img/status/<?= $row['status'] ?>.png" />
			<?= $row['status_descricao'] ?>
		</td>
		<td>
			<?= $row['classificacao'] == 99999 ? "---" : $row['classificacao'] ?>
		</td>
		<td><?= $row['equipa_modalidade_nome'] ?></td>
		<td>
			<img src="/pw606/img/countries/16/<?= $row['id_pais'] ?>.png" />
			<?= $row['pais_nome'] ?></td>
		<td>
			<form action="edit_db.php" method="post">
				<input type="hidden" name="id_prova" value="<?= $row['id_prova'] ?>" />
				<input type="hidden" name="id_classificacao" value="<?= $row['id_classificacao'] ?>" />
				<input type="hidden" name="status" value="<?= $row['status'] ?>" />
<?php
	if ($row['status'] <> 'D' and $row['id_delegacao'] == $current_user['id_delegacao']) {
?>
				<input type="submit" name="desinscrever" value="Remover" />
<?php
	}
?>
			</form>
		</td>
<?php
		} else {
?>
		<td><?= $row['id_classificacao'] ?></td>
		<td>
			<img src="/pw606/img/status/<?= $row['status'] ?>.png" />
			<?= $row['status_descricao'] ?>
		</td>
		<td>
			<?= $row['classificacao'] == 99999 ? "---" : $row['classificacao'] ?>
		</td>
		<td>
			<img src="/pw606/img/elementos/<?= $row['elemento_tipo'] ?>.png" />
			<?= $row['elemento_nome'] ?>
		</td>
		<td>
			<img src="/pw606/img/countries/16/<?= $row['id_pais'] ?>.png" />
			<?= $row['pais_nome'] ?></td>
		<td>
			<form action="edit_db.php" method="post">
				<input type="hidden" name="id_prova" value="<?= $row['id_prova'] ?>" />
				<input type="hidden" name="id_classificacao" value="<?= $row['id_classificacao'] ?>" />
				<input type="hidden" name="status" value="<?= $row['status'] ?>" />
<?php
	if ($row['status'] <> 'D' and $row['id_delegacao'] == $current_user['id_delegacao']) {
?>
				<input type="submit" name="desinscrever" value="Remover" />
<?php
	}
?>
			</form>
		</td>
<?php
		}
?>		
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
<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>