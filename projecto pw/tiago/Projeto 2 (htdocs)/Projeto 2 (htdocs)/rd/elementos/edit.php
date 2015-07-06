<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);

?>
<script type="text/javascript">
	function validationForm() 
	{
		submit = true;
		if (document.elemento.nome.value == "") {
			blinkValidator('validatorNome', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorNome');
		}
		
		if (!stringIsDate(document.elemento.data_nascimento.value)) {
			blinkValidator('validatorDataNascimento', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorDataNascimento');
		}
		
		if ((document.elemento.sexo[0].checked == false) && (document.elemento.sexo[1].checked == false)) {
			blinkValidator('validatorSexo', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorSexo');
		}
		
		if (document.elemento.tipo.value == 'A') {
		
			if (!stringIsInteger(document.elemento.peso.value)) {
				blinkValidator('validatorPeso', 150, 5);
				submit = false;
			} else {
				hideValidator('validatorPeso');
			}	
			if (!stringIsInteger(document.elemento.altura.value)) {
				blinkValidator('validatorAltura', 150, 5);
				submit = false;
			} else {
				hideValidator('validatorAltura');
			}
			if (document.elemento.sangue.value == "") {
				blinkValidator('validatorSangue', 150, 5);
				submit = false;
			} else {
				hideValidator('validatorSangue');
			}
			
		} else {
		
			if (document.elemento.funcao.value == "") {
				blinkValidator('validatorFuncao', 150, 5);
				submit = false;
			} else {
				hideValidator('validatorFuncao');
			}	
			if (document.elemento.habilitacoes.value == "") {
				blinkValidator('validatorHabilitacoes', 150, 5);
				submit = false;
			} else {
				hideValidator('validatorHabilitacoes');
			}
		
		}
	
		return submit;
	}
	
	function setFlagCountry(select, idImg)
	{
		img = document.getElementById(idImg);
		loadGetXMLHttpRequest("/pw606/XMLHttpRequest/delegacaoPais.php?id_delegacao=" + select.value,
							  function (xmlhttp)
							  {
								setFlagCountryXMLHttpRequest(xmlhttp, img);
							  }
							 );
	}

	function setFlagCountryXMLHttpRequest(xmlhttp, img)
	{
		if (isReadyXMLHttpRequest(xmlhttp)) {
			img.src = "/pw606/img/countries/16/" + xmlhttp.responseText + ".png";
		}
	}

</script>
<?php
	include rootPath('includes/gijo/master_header.php', 1);
	include rootPath('rd/check_login.php', 1);
?>
<?php

	$update = isset($_POST['id_elemento']);
	$el = null;
	$id_elemento = "-1";
	$tipo = (isset($_GET['auxiliar'])) ? "X" : "A";
	$tipo_descricao = elementoGetTipoDescricao($tipo);
	$id_delegacao = $current_user['id_delegacao'];
	$id_pais = $current_user['id_pais'];
	$pais_nome = $current_user['pais_nome'];
	$nome = "";
	$data_nascimento = "";
	$sexo = "";
	$peso = "";
	$altura = "";
	$sangue = "";
	$funcao = "";
	$habilitacoes = "";
	$status = "I";
	$status_descricao = estadoGetDescricao($status);
	
	if ($update) {
		$el = elementoGet($_POST['id_elemento']);
		
		$id_elemento = $el['id_elemento'];
		$tipo = $el['tipo'];
		$tipo_descricao = $el['tipo_descricao'];
		$id_delegacao = $el['id_delegacao'];
		$id_pais = $el['id_pais'];
		$pais_nome = $el['pais_nome'];
		$nome = $el['nome'];
		$data_nascimento = $el['data_nascimento'];
		$sexo = $el['sexo'];
		$peso = $el['peso'];
		$altura = $el['altura'];
		$sangue = $el['sangue'];
		$funcao = $el['funcao'];
		$habilitacoes = $el['habilitacoes'];
		
		$status = $el['status'];
		$status_descricao = $el['status_descricao'];
	}
	
	$isPendente = in_array($status, array('D', 'I', 'U'));
	$isRejected = ($status == 'R');
	$isNew = ($id_elemento == '-1');
	$isValid = ($status == 'V');
	$isToRemove = ($status == 'D');
	$isToInsert = ($status == 'I');
	
?>
<h1 class="header_h1">Elemento</h1>
<form name="elemento" action="edit_db.php" method="post">
	<table>
		<tr>
			<td>
				<label for="ipt_elemento">ID:</label>
			</td>
			<td>
				<input type="text" value="<?= $id_elemento ?>" disabled="disabled" />
				<input type="hidden" id="ipt_elemento" name="id_elemento" value="<?= $id_elemento ?>" />
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
		</tr>
		<tr>
			<td>
				Tipo:
			</td>
			<td>
				<input type="hidden" name="tipo" value="<?= $tipo ?>" />
				<img src="/pw606/img/elementos/<?= $tipo ?>.png" />
				<?= $tipo_descricao ?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="ipt_delegacao">Delegação:</label>
			</td>
			<td>
				<input type="hidden" name="id_delegacao" value="<?= $id_delegacao ?>" />
				<img src="/pw606/img/countries/16/<?= $id_pais ?>.png" />
				<?= $pais_nome ?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="ipt_nome">Nome:</label>
			</td>
			<td>
				<input type="text" id="ipt_nome" name="nome" value="<?= $nome ?>" />
				<span id="validatorNome" class="validatorField" title="O nome é de preenchimento obrigatório!">*</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="ipt_datanascimento">Data Nascimento:</label>
			</td>
			<td>
				<input type="text" id="ipt_datanascimento" name="data_nascimento" value="<?= $data_nascimento ?>" />
				<span id="validatorDataNascimento" class="validatorField" title="A data tem de esta no formato 'yyyy-MM-dd'!">*</span>
			</td>
		</tr>
		<tr>
			<td>
				Sexo:
			</td>
			<td>
				<label for="rbt_Masculino">Masculino</label>
				<input id="rbt_Masculino" type="radio" name="sexo" value="M" />
				<label for="rbt_Feminino">Feminino</label>
				<input id="rbt_Feminino" type="radio" name="sexo" value="F" />
				<script type="text/javascript">
					setCheckedValue(document.elemento.sexo, "<?= $sexo ?>");
				</script>
				<span id="validatorSexo" class="validatorField" title="O genero é de selecção obrigatória!">*</span>
			</td>
		</tr>
		<tr style="<?= ($tipo == 'A') ? '' : 'display:none'; ?>">
			<td>
				<label for="ipt_peso">Peso:</label>
			</td>
			<td>
				<input type="text" id="ipt_peso" name="peso" value="<?= $peso ?>" />
				<span id="validatorPeso" class="validatorField" title="O peso tem de ser um valor numérico!">*</span>
			</td>
		</tr>
		<tr style="<?= ($tipo == 'A') ? '' : 'display:none'; ?>" >
			<td>
				<label for="ipt_altura">Altura:</label>
			</td>
			<td>
				<input type="text" id="ipt_altura" name="altura" value="<?= $altura ?>" />
				<span id="validatorAltura" class="validatorField" title="A altura tem de ser um valor numérico!">*</span>
			</td>
		</tr>
		<tr style="<?= ($tipo == 'A') ? '' : 'display:none'; ?>">
			<td>
				<label for="ipt_sangue">Sangue:</label>
			</td>
			<td>
				<select id="ipt_sangue" name="sangue" >
					<option value=""></option>
					<option value="O+">O+</option>
					<option value="A+">A+</option>
					<option value="B+">B+</option>
					<option value="AB+">AB+</option>
					<option value="O-">O-</option>
					<option value="A-">A-</option>
					<option value="B-">B-</option>
					<option value="AB-">AB-</option>
				</select>
				<script type="text/javascript">
					selectSelectedValue(document.getElementById('ipt_sangue'), "<?= $sangue ?>");
				</script>
				<span id="validatorSangue" class="validatorField" title="O tipo de sangue é de preenchimento obrigatório!">*</span>
			</td>
		</tr>
		<tr style="<?= ($tipo == 'X') ? '' : 'display:none'; ?>">
			<td>
				<label for="ipt_Funcao">Função:</label>
			</td>
			<td colspan="3">
				<input type="text" id="ipt_Funcao" name="funcao" value="<?= $funcao ?>" />
				<span id="validatorFuncao" class="validatorField" title="A função para o auxiliar é de preenchimento obrigatório!">*</span>
			</td>
		</tr>
		<tr style="<?= ($tipo == 'X') ? '' : 'display:none'; ?>">
			<td>
				<label for="ipt_Habilitacoes">Habilitações:</label>
			</td>
			<td colspan="3">
				<input type="text" id="ipt_Habilitacoes" name="habilitacoes" value="<?= $habilitacoes ?>" />
				<span id="validatorHabilitacoes" class="validatorField" title="As habilitações são de preenchimento obrigatório!">*</span>
			</td>
		</tr>
	</table>
	<input type="submit" name="save" value="Guardar" onclick="return validationForm();" />
<?php
	if (!$isToRemove) {
?>
	<input type="submit" name="delete" value="Remover" />
<?php
	}
?>
	<input type="button" value="Cancelar" onclick="window.location = 'index.php';" />	
</form>
<?php
	include rootPath('includes/gijo/master_footer.php', 1);
?>