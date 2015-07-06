<?php
	include '../../includes/utils.php';
	include rootPath('includes/sijo/html_header.php', 1);
?>
<script type="text/javascript">
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
	include rootPath('includes/sijo/master_header.php', 1);
	//include rootPath('co/check_login.php', 1);
?>
<?php

	$update = isset($_GET['id_elemento']);
	$el = null;
	$id_elemento = "-1";
	$tipo = (isset($_GET['auxiliar'])) ? "X" : "A";
	$tipo_descricao = elementoGetTipoDescricao($tipo);
	$id_delegacao = "-1";
	$id_pais = "";
	$pais_nome = "";
	$nome = "";
	$data_nascimento = "";
	$sexo = "";
	$peso = "";
	$altura = "";
	$sangue = "";
	$funcao = "";
	$habilitacoes = "";
	$status = "V";
	$status_descricao = estadoGetDescricao($status);
	
	if ($update) {
		$el = elementoGet($_GET['id_elemento']);
		
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
	
?>
<h1 class="header_h1">Elemento</h1>
<form name="elemento" action="edit_db.php" method="GET">
	<table>
		<tr>
			<td>
				<label for="ipt_elemento">ID:</label>
			</td>
			<td>
				<input type="text" value="<?= $id_elemento ?>" readonly="true" />
			</td>
		</tr>
		<tr>
			<td>
				Tipo:
			</td>
			<td>
				<img src="/pw606/img/elementos/<?= $tipo ?>.png" />
				<?= $tipo_descricao ?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="ipt_delegacao">Delegação:</label>
			</td>
			<td>
<?php
	if ($update) {
?>
				<img src="/pw606/img/countries/16/<?= $id_pais ?>.png" />
				<?= $pais_nome ?>
<?php
	} else {
?>
				<img id="imgDelegacao" src="" />
				<select id="ipt_delegacao" name="id_delegacao" onchange="setFlagCountry(this, 'imgDelegacao');" >
<?php
		$ds = delegacaoGetByFiltro(-1, null, array('X'));
		while($row = foreachRow($ds)) {
			echo "<option value=\"{$row['id_delegacao']}\">{$row['pais_nome']}</option>";
		}
?>	
				</select>
				<script type="text/javascript">
					setFlagCountry(document.getElementById("ipt_delegacao"), 'imgDelegacao');
				</script>
<?php
	}
?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="ipt_nome">Nome:</label>
			</td>
			<td>
				<input type="text" id="ipt_nome" name="nome" value="<?= $nome ?>" readonly="true"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="ipt_datanascimento">Data Nascimento:</label>
			</td>
			<td>
				<input type="text" id="ipt_datanascimento" name="data_nascimento" value="<?= $data_nascimento ?>" readonly="true"/>
			</td>
		</tr>
		<tr>
			<td>
				Sexo:
			</td>
			<td>
				<label for="rbt_Masculino">Masculino</label>
				<input id="rbt_Masculino" type="radio" name="sexo" value="M" disabled="true"/>
				<label for="rbt_Feminino">Feminino</label>
				<input id="rbt_Feminino" type="radio" name="sexo" value="F" disabled="true"/>
				<script type="text/javascript">
					setCheckedValue(document.elemento.sexo, "<?= $sexo ?>");
				</script>
			</td>
		</tr>
		<tr style="<?= ($tipo == 'A') ? '' : 'display:none'; ?>">
			<td>
				<label for="ipt_peso">Peso (kg):</label>
			</td>
			<td>
				<input type="text" id="ipt_peso" name="peso" value="<?= $peso ?>" readonly="true"/>
			</td>
		</tr>
		<tr style="<?= ($tipo == 'A') ? '' : 'display:none'; ?>" >
			<td>
				<label for="ipt_altura">Altura (cm):</label>
			</td>
			<td>
				<input type="text" id="ipt_altura" name="altura" value="<?= $altura ?>" readonly="true"/>
			</td>
		</tr>
		<tr style="<?= ($tipo == 'A') ? '' : 'display:none'; ?>">
			<td>
				<label for="ipt_sangue">Sangue:</label>
			</td>
			<td>
				<input type="text" name="sangue" value="<?= $sangue ?>" readonly="true" />
			</td>
		</tr>
		<tr style="<?= ($tipo == 'X') ? '' : 'display:none'; ?>">
			<td>
				<label for="ipt_Funcao">Função:</label>
			</td>
			<td colspan="3">
				<input type="text" id="ipt_Funcao" name="funcao" value="<?= $funcao ?>" disabled="disabled"/>
			</td>
		</tr>
		<tr style="<?= ($tipo == 'X') ? '' : 'display:none'; ?>">
			<td>
				<label for="ipt_Habilitacoes">Habilitações:</label>
			</td>
			<td colspan="3">
				<input type="text" id="ipt_Habilitacoes" name="habilitacoes" value="<?= $habilitacoes ?>" disabled="disabled" />
			</td>
		</tr>
		
		<tr>
			<td>Modalidades:</td>
			<td>
			<!-- pesquisa em (elementos_equipas_total) pelo id_elemento -->
			<?php
			$elemento_modalidades = elementoModalidades($id_elemento);
				while($row = foreachRow($elemento_modalidades)) {
					echo $row['modalidade_nome']."</br>";
				}
			?>
			</td>
		</tr>
	</table>
</form>
<a href="index.php" class="seta-invertida" style="margin-top:10px;">Voltar</a>
<!-- <h1 class="footer_h1"></h1> -->
<?php
	include rootPath('includes/sijo/master_footer.php', 1);
?>