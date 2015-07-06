<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
	include_once rootPath('includes/gijo/master_header.php', 1);
	require_once rootPath('co/check_login.php', 1);
?>
<h1 class="header_h1">
	Sugestões / Comentários / Reclamações
</h1>
<table id="tableresults" class="tableclass">
	<tr class="rowHeader">
		<th>Código</th>
		<th>Tipo</th>
		<th>Data</th>
		<th>Descrição</th>
		<th>Visitante</th>
		<th></th>
		<th></th>
	</tr>
<?php	
		$sugestions = sugestaoGetAll();
		$alt = true;
		while ($row = mysql_fetch_array($sugestions)) {
			$alt = !$alt;
?>		
		<tr class="<?= $alt ? "rowalternative" : "" ?>">
			<td>#<?= $row["id_sugestao"] ?></td>
			<td><?= $row["tipo_descricao"] ?></td>
			<td><?= $row["data"] ?></td>
			<td><?= $row["descricao"] ?></td>
			<td title="<?= $row["email"] ?>" ><?= $row["nome"] ?></td>
			<td>
				<a href="mailto:<?= $row["email"] ?>" title="Responder por email"><img src="/pw606/img/mail_forward.png" /></a>
			</td>
			<td>
				<img src="/pw606/img/mobilephone1.png" title="Responder por sms" style="cursor:pointer;"
					 onclick="return showMessageSms('<?= $row["nome"] ?>', '<?= $row["telemovel"] ?>');" />
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
<h1 class="footer_h1">
</h1>
<br/>
<div id="messageSMS" style="display:none;">
	<fieldset>
		<form action="index_db.php" name="sms" method="post">
			Nome:<br/>
			<input id="smsnome" type="text" name="nome" readonly="readonly" /><br/>
			Telemóvel:<br/>
			<input id="smstelemovel" type="text" name="telemovel" readonly="readonly" /><br/>
			Mensagem:<br/>
			<textarea id="smstext" name="smstext"></textarea><br/>
			<input type="submit" value="Enviar" name="enviar" onclick="return validationSms();" />
			<input type="button" value="Cancelar" onclick="return hideMessageSms();" />
		</form>
	</fieldset>
</div>
<script type="text/javascript">
	
	function showMessageSms(nome, telemovel) {
		$('smsnome').value = nome;
		$('smstelemovel').value = telemovel;
		$('smstext').value = '';
		$('messageSMS').style.display = 'block';
		return false;
	}
	
	function hideMessageSms() {
		$('messageSMS').style.display = 'none';
		return false;
	}
	
	function validationSms() {
		if ($('smstelemovel').value == "") {
			return false;
			alert(false);
		} else {
			return true;
		}
	}
	
</script>
<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>