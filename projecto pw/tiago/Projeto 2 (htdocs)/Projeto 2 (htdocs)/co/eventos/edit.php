<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
?>	
<script type="text/javascript">
	function validationForm() 
	{
		submit = true;

		if (document.evento.designacao.value == "") {
			blinkValidator('validatorDesignacao', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorDesignacao');
		}
		
		if (!stringIsDateTime(document.evento.data_hora.value)) {
			blinkValidator('validatorDataHora', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorDataHora');
		}
		
		if (!stringIsInteger(document.evento.duracao.value)) {
			blinkValidator('validatorDuracao', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorDuracao');
		}

		if (!stringIsInteger(document.evento.preco_bilhete.value)) {
			blinkValidator('validatorPrecoBilhete', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorPrecoBilhete');
		}
		
		if (document.evento.descricao.value == "") {
			blinkValidator('validatorDescricao', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorDescricao');
		}
		
		if (!stringIsInteger(document.evento.lugares_vendidos.value)) {
			blinkValidator('validatorLugaresVendidos', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorLugaresVendidos');
		}
		
		if (!stringIsInteger(document.evento.lugares_reservados.value)) {
			blinkValidator('validatorLugaresReservados', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorLugaresReservados');
		}
		
		return submit;
	}
	
</script>
<?php
	include_once rootPath('includes/gijo/master_header.php', 1);
?>
<?php

	$update = isset($_POST['id_evento']);
	$evento = null;
	$id_evento = "-1";
	$id_local ="";
	$designacao ="";
	$data_hora = "";
	$duracao = "";
	$preco_bilhete = "";
	$lugares_vendidos = "";
	$lugares_reservados = "";
	$status = "V";
	$descricao = "";
	$local_nome = "";
	$num_lugares = "";

	if ($update) {
		$evento = eventosGet($_POST['id_evento']);
		$id_evento = $evento['id_evento'];
		$id_local = $evento['id_local'];
		$designacao = $evento['designacao'];
		$data_hora = $evento['data_hora'];
		$duracao = $evento['duracao'];
		$preco_bilhete =  $evento['preco_bilhete'];
		$lugares_vendidos = $evento['lugares_vendidos'];
		$lugares_reservados = $evento['lugares_reservados'];
		$status = $evento['status'];
		$descricao = $evento['descricao'];
		$local_nome = $evento['local_nome'];
		$num_lugares = $evento['num_lugares'];
	}
	
	$isPendente = in_array($status, array('D', 'I', 'U'));
	$isRejected = ($status == 'R');
	$isNew = ($id_evento == '-1');
	$isValid = ($status == 'V');
	
?>
<h1 class="header_h1">Eventos</h1>
<form name="evento" action="edit_db.php" method="post">
	<table>
		<tr>
			<td>
				<label for="id">ID:</label>
			</td>
			<td>
				<input type="text" id="id" value="<?= $id_evento ?>" disabled="disabled" />
				<input type="hidden" name="id_evento" value="<?= $id_evento ?>" />
				<input type="hidden" name="status" value="<?= $status ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label>Designação:</label>
			</td>
			<td>
				<input type="text" name="designacao" value="<?= $designacao ?>" size="50" />
				<span id="validatorDesignacao" class="validatorField" title="A designação é de preenchimento obrigatório!">*</span>
			</td>
		</tr>
		<tr>
			<td>
				<label>Data/hora:</label>
			</td>
			<td>
				<input type="text" name="data_hora" value="<?= $data_hora ?>" />
				<span id="validatorDataHora" class="validatorField" title="A data tem de esta no formato 'yyyy-MM-dd HH:mm:ss'!">*</span>
			</td>
		</tr>
		<tr>
			<td>
				<label>Duração: [min]</label>
			</td>
			<td>
				<input type="text" name="duracao" value="<?= $duracao ?>" />
				<span id="validatorDuracao" class="validatorField" title="A duração é de preenchimento obrigatório!">*</span>
			</td>
		</tr>	
		<tr>
			<td>
				<label>Preço Bilhete: [€]</label>
			</td>
			<td>
				<input type="text" name="preco_bilhete" value="<?= $preco_bilhete ?>" />
				<span id="validatorPrecoBilhete" class="validatorField" title="O preço do bilhete é de preenchimento obrigatório!">*</span>
			</td>
		</tr>	
		<tr>
			<td>
				<label>Descrição:</label>
			</td>
			<td>
				<textarea name="descricao" rows="7" cols="80" ><?= $descricao ?> </textarea>
				<span id="validatorDescricao" class="validatorField" title="A descrição é de preenchimento obrigatório!">*</span>
			</td>
		</tr>		
		<tr>
			<td>
				<label>Local - Lotação:</label>
			</td>
			<td>
				<select id="slt_local" name="id_local">
<?php
	$tabela_locais = localGetByFiltro(null, array('X')); 
	while ($row = mysql_fetch_array($tabela_locais)) {
?>
					<option value="<?= $row["id_local"]?>"> <?= $row["nome"]?> - <?= $row["num_lugares"] ?></option>
<?php
	}
?>
				</select>
				<script type="text/javascript">
					selectSelectedValue(document.getElementById('slt_local'), "<?= $id_local ?>");
				</script>
			</td>
		</tr>
		<tr>
			<td>
				<label>Lugares Vendidos:</label>
			</td>
			<td>
				<input type="text" name="lugares_vendidos" value="<?= $lugares_vendidos ?>" />
				<span id="validatorLugaresVendidos" class="validatorField" title="O número de lugares vendidos é de preenchimento obrigatório!">*</span>
			</td>
		</tr>	
		<tr>
			<td>
				<label>Lugares Reservados:</label>
			</td>
			<td>
				<input type="text" name="lugares_reservados" value="<?= $lugares_reservados ?>" />
				<span id="validatorLugaresReservados" class="validatorField" title="O número de lugares reservados é de preenchimento obrigatório!">*</span>
			</td>
		</tr>					
	</table>
<?php
	if ($isValid) {
?>
	<input type="submit" name="submeter" value="Guardar" onclick="return validationForm();" />
<?php
		if (!$isNew) {
?>
	<input type="submit" name="submeter" value="Remover" />
<?php
		}
	}
?>
	<input type="submit" name="submeter" value="Cancelar" />
</form>
<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>