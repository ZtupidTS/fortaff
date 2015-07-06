<?php
switch($dados['estado_valido'])
{
case 'V';
	?>
	<img src="../images/accept.png" name="Valido" alt="Válido" title="Válido"/><br>
	<?php
	break;
case 'D';
	?>
	<img src="../images/warning.png" name="Pendente" alt="Pendente" title="Pendente"/><br>
	<?php
	$informacao = mysql_query("SELECT * FROM informacao_diversas WHERE id = '$dados[estado_valido]'");
	$dados_info = mysql_fetch_array($informacao);
	echo $dados_info['informacao'];
	break;
case 'M';
	?>
	<img src="../images/warning.png" name="Pendente" alt="Pendente" title="Pendente"/><br>
	<?php
	$informacao = mysql_query("SELECT * FROM informacao_diversas WHERE id = '$dados[estado_valido]'");
	$dados_info = mysql_fetch_array($informacao);
	echo $dados_info['informacao'];
	break;
case 'A';
	?>
	<img src="../images/warning.png" name="Pendente" alt="Pendente" title="Pendente"/><br>
	<?php
	$informacao = mysql_query("SELECT * FROM informacao_diversas WHERE id = '$dados[estado_valido]'");
	$dados_info = mysql_fetch_array($informacao);
	echo $dados_info['informacao'];
	break;
}?>
