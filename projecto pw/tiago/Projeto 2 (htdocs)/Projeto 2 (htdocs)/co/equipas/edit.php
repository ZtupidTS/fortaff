<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
?>
<script type="text/javascript">

	function setModalidadeTipo(select, idImg)
	{
		img = document.getElementById(idImg);
		loadGetXMLHttpRequest("/pw606/XMLHttpRequest/modalidadeTipo.php?id_modalidade=" + select.value,
							  function (xmlhttp)
							  {
								setModalidadeTipoXMLHttpRequest(xmlhttp, img);
							  }
							 );
	}

	function setModalidadeTipoXMLHttpRequest(xmlhttp, img)
	{
		if (isReadyXMLHttpRequest(xmlhttp)) {
			img.src = "/pw606/img/modalidades/" + xmlhttp.responseText + ".png";
		}
	}
	
	function delegacaoOnChange()
	{
		select = $('ipt_delegacao');
		
		//Muda a bandeira da delegacao
		var id_pais = "generic";
		for (var i = 0; i < delegacoes.length; i++)
		{
			if (delegacoes[i].id_delegacao == select.value) {
				id_pais = delegacoes[i].id_pais;
				break;
			}
		}
		
		$('imgDelegacao').src = "/pw606/img/countries/16/" + id_pais + ".png";
		
		//Preenche a lista de modalidades não existentes para a delegacao seleccionada
		loadGetXMLHttpRequest("/pw606/XMLHttpRequest/modalidadeNaoExistentes.php?id_delegacao=" + select.value,
							  preencheModalidades);
	}
	
	function preencheModalidades(xmlhttp)
	{
		if (isReadyXMLHttpRequest(xmlhttp)) {
		
			var select = $('input_modalidade');
			select.options.length = 0;
			var mods = eval('(' + xmlhttp.responseText + ')');
			
			for (var i = 0; i < mods.length; i++)
			{
				var opt = document.createElement('option');
				opt.text = mods[i].nome;
				opt.value = mods[i].id_modalidade;
				select.options.add(opt);
			}
		}
	}
	
</script>
<?php
	include_once rootPath('includes/gijo/master_header.php', 1);
	require_once rootPath('co/check_login.php', 1);
?>
<?php

	if (isset($_SESSION['equipa_post']) and isset($_SESSION['equipa_post']['id_equipa'])) {
		$_POST['id_equipa'] = $_SESSION['equipa_post']['id_equipa'];
		unset($_SESSION['equipa_post']);
	}
	
	$update = isset($_POST['id_equipa']);
	$eq = null;
	$id_equipa = "-1";
	$status = 'V';
	$status_descricao = estadoGetDescricao($status);
	$id_pais = '-1';
	$pais_nome = '';
	$id_modalidade = "-1";
	$modalidade_nome = '';
	
	if (isset($_POST['id_delegacao'])) {
		$id_delegacao = $_POST['id_delegacao'];
		$deg = delegacaoGet($id_delegacao);
		$id_pais = $deg['id_pais'];
		$pais_nome = $deg['pais_nome'];
	} else {
		$id_delegacao = "-1";
	}
	
	if ($update) {
		$eq = equipaGet($_POST['id_equipa']);
		
		$id_equipa = $eq['id_equipa'];
		$status = $eq['status'];
		$status_descricao = $eq['status_descricao'];
		$id_delegacao = $eq['id_delegacao'];
		$id_pais = $eq['id_pais'];
		$pais_nome = $eq['pais_nome'];
		$id_modalidade = $eq['id_modalidade'];
		$modalidade_nome = $eq['modalidade_nome'];
	}
	
	$isPendente = in_array($status, array('D', 'I', 'U'));
	$isRejected = ($status == 'R');
	$isNew = ($id_equipa == '-1');
	$isValid = ($status == 'V');
	
?>
<h1 class="header_h1">Equipa</h1>
<form action="edit_db.php" method="post">
	<table>
		<tr>
			<td>
				<label for="input_equipa">ID:</label>
			</td>
			<td>
				<input type="text" value="<?= $id_equipa ?>" disabled="disabled" />
				<input type="hidden" id="input_equipa" name="id_equipa" value="<?= $id_equipa ?>" />
			</td>
		</tr>
		<tr>
			<td>
				Estado:
			</td>
			<td>
				<input type="hidden" name="status" value="<?= $status ?>" />
				<img src="/pw606/img/status/<?= $status ?>.png" />
				<?= $status_descricao ?>
			</td>
			<td>
<?php
	if ($isPendente or $isRejected) {
?>
				<input type="submit" name="accept" value="Aceitar" />
<?php
		if (!$isRejected) { 
?>
				<input type="submit" name="reject" value="Rejeitar" />
<?php
		}
	}
?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="input_delegacao">Delegação:</label>
			</td>
			<td>
<?php
	if ($update) {
?>
				<input type="hidden" name="id_delegacao" value="<?= $id_delegacao ?>" />
				<img src="/pw606/img/countries/16/<?= $id_pais ?>.png" />
				<?= $pais_nome ?>
<?php 
	} else {
?>
				<img id="imgDelegacao" src="" />
				<select id="ipt_delegacao" name="id_delegacao" onchange="delegacaoOnChange();" >
<?php
		$ds = delegacaoGetByFiltro(-1, null, array('X'));
		$dados = array();
		
		while($row = foreachRow($ds)) {
			$dados[] = array('id_delegacao' => $row['id_delegacao'], 'id_pais' => $row['id_pais']);
?>
					<option value="<?= $row['id_delegacao'] ?>"><?= $row['pais_nome'] ?></option>
<?php
		}
?>	
				</select>
				<script type="text/javascript">
					var delegacoes = eval('(<?= ujson_encode($dados); ?>)');
					delegacaoOnChange();
				</script>
<?php
	}
?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="input_modalidade">Modalidade:</label>
			</td>
			<td>
<?php
	if ($update) {
?>
				<input type="hidden" name="id_modalidade" value="<?= $id_modalidade ?>" />
				<input type="text" value="<?= $modalidade_nome ?>" disabled="disabled" />
<?php 
	} else {
?>
				<select id="input_modalidade" name="id_modalidade" >
				</select>
<?php
	}
?>
			</td>
		</tr>
	</table>
<?php
	if ($isValid) {
?>
		<input type="submit" name="save" value="Guardar" />
<?php
		if (!$isNew) {
?>
		<input type="submit" name="delete" value="Remover" />
<?php
		}
	}
?>
	<input type="submit" name="cancel" value="Cancelar" />
</form>
<hr/>
<h2>Elementos Não Inscritos</h2>
<table id="tblelementos" class="tableclass">
	<tr>
		<th>ID</th>
		<th>Nome</th>
		<th>Sexo</th>
		<th>Nascimento</th>
		<th>Estado</th>
		<th></th>
	</tr>
<?php
	$elementos = elementoNaoInscritoEmEquipa($id_equipa);
	
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
			<img src="/pw606/img/status/<?= $row['status'] ?>.png" title="<?= $row['status_descricao'] ?>" />
			<?= $row['status_descricao'] ?>
		</td>
		<td> 
			<form action="edit_db.php" method="post">
				<input type="hidden" name="id_elemento" value="<?= $row['id_elemento'] ?>" />
				<input type="hidden" name="id_equipa" value="<?= $id_equipa ?>" />
				<input type="submit" name="inscrever" value="Inscrever" />
			</form>
		</td>
	</tr>
<?php
	}
?>
</table>
<div id="pageNavPositionElementos"></div>
<br/>
<h2>Elementos Inscritos</h2>
<table id="tblinscritos" class="tableclass">
	<tr>
		<th>ID</th>
		<th>Inscricao</th>
		<th>Atleta</th>
		<th>Nome</th>
		<th>Sexo</th>
		<th>Nascimento</th>
		<th></th>
	</tr>
<?php
	$elementos = elementoEquipaGetByFiltro(-1, $id_equipa, -1, null, array('X'));

	$delegacao = -1;
	$alt = false;
	while ($row = foreachRow($elementos)) {
		$alt = !$alt;
		if ($delegacao !== $row['id_delegacao']) {
			$delegacao = $row['id_delegacao'];
			$alt = false;
?>
	<tr class="rowgroup">
		<td colspan="7">
			<img src="/pw606/img/countries/16/<?= $row['id_pais'] ?>.png" />
			<b><?= $row['pais_nome'] ?><b>
		</td>
	</tr>
<?php
		}
?>
	<tr class="<?= $alt ? "rowalternative": "" ?>">
		<td><?= $row['id_elemento_equipa'] ?></td>
		<td>
			<img src="/pw606/img/status/<?= $row['status'] ?>.png" title="<?= $row['status_descricao'] ?>" />
			<?= $row['status_descricao'] ?>
		</td>
		<td><?= $row['id_elemento'] ?></td>
		<td>
			<img src="/pw606/img/elementos/<?= $row['elemento_tipo'] ?>.png" title="<?= $row['elemento_status_descricao'] ?>" />
			<?= $row['elemento_nome'] ?>
		</td>
		<td><?= $row['elemento_sexo'] ?></td>
		<td><?= $row['elemento_data_nascimento'] ?></td>
		<td> 
			<form action="edit_db.php" method="post">
				<input type="hidden" name="id_equipa" value="<?= $row['id_equipa'] ?>" />
				<input type="hidden" name="id_elemento_equipa" value="<?= $row['id_elemento_equipa'] ?>" />
				<input type="hidden" name="status" value="<?= $row['status'] ?>" />
<?php
	if (in_array($row['status'], array('D', 'I', 'U', 'R'))) {
?>
				<input type="submit" name="aceitarInscricao" value="Aceitar" />
<?php
		if ($row['status'] !== 'R') {
?>
				<input type="submit" name="rejeitarInscricao" value="Rejeitar" />
<?php
		}
	} else if ($row['status'] == 'V') {
?>
				<input type="submit" name="desinscrever" value="Remover" />
<?php
	}
?>
			</form>
		</td>
	</tr>
<?php
	}
?>
</table>
<div id="pageNavPositionInscritos"></div>
<script type="text/javascript">
        // var pagerElm = new Pager('tblelementos', <?= $lines_per_table ?>); 
        // pagerElm.init();
        // pagerElm.showPageNav('pagerElm', 'pageNavPositionElementos');
        // pagerElm.showPage(1);
		// pagerElm.funcGroup = function (row) {
			// return row.hasClassName("rowgroup");
		// }
		
		// var pagerIns = new Pager('tblinscritos', <?= $lines_per_table ?>); 
        // pagerIns.init(); 
        // pagerIns.showPageNav('pagerIns', 'pageNavPositionInscritos'); 
        // pagerIns.showPage(1);
		// pagerIns.funcGroup = function (row) {
			// return row.hasClassName("rowgroup");
		// }
</script>
<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>