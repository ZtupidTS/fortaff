<?php
	require_once '/includes/utils.php';
	include_once rootPath('includes/html_header.php', 1);
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
	
	function validationVote() 
	{
		var submit = true;
		if (document.evento.apreciacao.value == "-1" || document.evento.nome_utilizador.value == "") {
			blinkValidator('validatorApreciacaoNome', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorApreciacaoNome');
		}
		return submit;
	}	
</script>
<?php
	include_once rootPath('includes/master_header.php', 1);
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
	$apreciacao = "0";

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
		$apreciacao = $evento['apreciacao'];
	}
?>
<h1>Eventos</h1>
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
			<input type="text" name="designacao" value="<?= $designacao ?>" disabled="disabled" size="50" />
			<span id="validatorDesignacao" class="validatorField" title="A designação é de preenchimento obrigatório!">*</span>
		</td>
	</tr>
	<tr>
		<td>
			<label>Data/hora:</label>
		</td>
		<td>
			<input type="text" name="data_hora" value="<?= $data_hora ?>" disabled="disabled" />
			<span id="validatorDataHora" class="validatorField" title="A data tem de esta no formato 'yyyy-MM-dd HH:mm:ss'!">*</span>
		</td>
	</tr>
	<tr>
		<td>
			<label>Duração: [min]</label>
		</td>
		<td>
			<input type="text" name="duracao" value="<?= $duracao ?>" disabled="disabled"/>
			<span id="validatorDuracao" class="validatorField" title="A duração é de preenchimento obrigatório!">*</span>
		</td>
	</tr>	
	<tr>
		<td>
			<label>Preço Bilhete: [€]</label>
		</td>
		<td>
			<input type="text" name="preco_bilhete" value="<?= $preco_bilhete ?>" disabled="disabled" />
			<span id="validatorPrecoBilhete" class="validatorField" title="O preço do bilhete é de preenchimento obrigatório!">*</span>
		</td>
	</tr>	
	<tr>
		<td>
			<label>Descrição:</label>
		</td>
		<td>
			<textarea name="descricao" rows="7" cols="80" disabled="disabled" ><?= $descricao ?>  </textarea>
			<span id="validatorDescricao" class="validatorField" title="A descrição é de preenchimento obrigatório!">*</span>
		</td>
	</tr>		
	<tr>
		<td>
			<label>Local - Lotação:</label>
		</td>
		<td>
			<select id="slt_local" name="id_local" disabled="disabled">
<?php
	$tabela_locais = localGetAll(); //tabela locais
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
			<input type="text" name="lugares_vendidos" value="<?= $lugares_vendidos ?>" disabled="disabled"/>
			<span id="validatorLugaresVendidos" class="validatorField" title="O número de lugares vendidos é de preenchimento obrigatório!">*</span>
		</td>
	</tr>	
	<tr>
		<td>
			<label>Lugares Reservados:</label>
		</td>
		<td>
			<input type="text" name="lugares_reservados" value="<?= $lugares_reservados ?>" disabled="disabled" />
			<span id="validatorLugaresReservados" class="validatorField" title="O número de lugares reservados é de preenchimento obrigatório!">*</span>
		</td>
	</tr>
	<tr>
		<td>
			<label>Apreciação:</label>
		</td>
		<td>
			<form action="edit_db.php" name="evento" method="post" >
				<input type="hidden" name="id_evento" value="<?= $id_evento ?>" />
<?php
	$_SESSION['rating_object']['id'] = 'inputapreciacao';
	$_SESSION['rating_object']['name'] = 'apreciacao';
	include rootPath('includes/rating_object.php', 1);
?>
				<input type="text" name="nome_utilizador" />
				<span id="validatorApreciacaoNome" class="validatorField" title="Indique a classificação entre 1 a 5 e preencha o seu nome!">*</span>
				<input type="submit" name="votar" value="Votar" onclick="return validationVote();" />
			</form>
		</td>
	</tr>				
</table>
<input type="button" value="Cancelar" onclick="window.location = 'index.php';"  />
<?php
	include_once rootPath('includes/master_footer.php', 1);
?>