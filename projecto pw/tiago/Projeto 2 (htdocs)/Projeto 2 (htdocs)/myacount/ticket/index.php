<?php
	require_once '../../includes/utils.php';
	require_once rootPath('includes/sijo/html_header.php', 1);
	require_once rootPath('includes/sijo/master_header.php', 1);
	require_once rootPath('myacount/check_login.php', 1);
?>
<h1 class="header_h1">Os meus Bilhetes</h1>

<?php
	if (isset($_SESSION['returnMsg'])) {
?>
<div class="<?= $_SESSION['returnMsg']['code'] ?>msg"><?= $_SESSION['returnMsg']['msg'] ?></div>
<?php
		unset($_SESSION['returnMsg']);
	}
?>

<table>
<?php

	function printBilhete($row)
	{
		global $current_user;
?>
	<tr>
		<td>#<?= $row['id_bilhete'] ?></td>
		<td><?= $row['data'] ?></td>
		<td><?= $row['data_compra'] ?></td>
		<td><?= $row['preco'] ?></td>
		<td><?= $row['quantidade'] ?></td>
		<td><?= $row['preco'] * $row['quantidade'] ?></td>
		<td>
<?php
		if ($row['status'] == "I") {
			//INICIAL
?>
			<form method="post" action="index_post.php">
				<input type="hidden" name="id_bilhete" value="<?= $row['id_bilhete'] ?>" />
				<input type="image" name="reconfirm" src="/pw606/img/ticket/16/<?= $row['status'] ?>.png" title="Reenviar email de confirmação" onsubmit="submit-form();"/>
			</form>
<?php
		} else if ($row['status'] == "C") {
			//CONFIRMADO
			printPayPalButton($row['id_bilhete'], $row['acontecimento_designacao'], $row['preco']);
			
		} else if ($row['status'] == "P") {
			//PAGO
?>
			<form method="post" action="view.php" target="_tab">
				<input type="hidden" name="id_bilhete" value="<?= $row['id_bilhete'] ?>" />
				<input type="hidden" name="nome" value="<?= $current_user['nome'] ?>" />
				<input type="hidden" name="email" value="<?= $current_user['email'] ?>" />
				<input type="hidden" name="acontecimento" value="<?= $row['acontecimento_tipo'] ?>" />
				<input type="hidden" name="evento" value="<?= $row['acontecimento_designacao'] ?>" />
				<input type="hidden" name="local" value="<?= $row['local_nome'] ?>" />
				<input type="hidden" name="tipo" value="<?= $row['tipo_descricao'] ?>" />
				<input type="hidden" name="quantidade" value="<?= $row['quantidade'] ?>" />
				<input type="hidden" name="preco" value="<?= $row['preco'] ?>" />
				<input type="hidden" name="total" value="<?= $row['preco'] * $row['quantidade'] ?>" />
				<input type="image" src="/pw606/img/ticket/16/<?= $row['status'] ?>.png" title="Bilhete Pago" onsubmit="submit-form();" 	 />
			</form>
<?php
		} else if ($row['status'] == "X") {
			//CANCELADO
?>
				<img src="/pw606/img/ticket/16/<?= $row['status'] ?>.png" title="Cancelado" />
<?php
		}
?>
		</td>
		<td>
<?php
		if ($row['status'] != "P") {
			//CANCELAR BILHETE
?>
			<form method="post" action="index_post.php">
				<input type="hidden" name="id_bilhete" value="<?= $row['id_bilhete'] ?>" />
				<input type="image" name="cancelar" src="/pw606/img/ticket/16/X.png" title="Cancelar" onsubmit="submit-form();"/>
			</form>
<?php
		}
?>	
		</td>
	</tr>
<?php
	}

function printEndAcontecimento()
{
?>
					</table>
				</td>
			</tr>
		</table>
	</tr>
<?php
}

	$bilhetes = bilheteGetByFiltro($current_user['id_visitante'], null, array('X'));
	$alt = true;
	$last_id_entidade = -1;
	while ($row = mysql_fetch_array($bilhetes)) {
		if ($last_id_entidade != $row['id_entidade']) {
			if ($last_id_entidade != -1) {
				printEndAcontecimento();
			}
			$last_id_entidade = $row['id_entidade'];
?>
	<tr>
		<table class="tableclass">
			<tr>
				<th><?= $row['acontecimento_tipo'] ?></th>
				<th>Local:</th>
				<th>Capacidade:</th>
				<th>Lotação:</th>
				<th>Data:</th>
				<th>Duração(min)</th>
			</tr>
			<tr>
				<td><?= $row['acontecimento_designacao'] ?></td>
				<td><?= $row['local_nome'] ?></td>
				<td><?= $row['local_num_lugares'] ?></td>
				<td><?= $row['lugares_ocupados'] ?></td>
				<td><?= $row['acontecimento_data'] ?></td>
				<td><?= $row['acontecimento_duracao'] ?></td>
			</tr>
			<tr>
				<td colspan="6">
					<table class="tableclass">
						<tr>
							<th>Codigo</th>
							<th>Data</th>
							<th>Compra</th>
							<th>Preço(€)</th>
							<th>Quantidade</th>
							<th>Total(€)</th>
							<th></th>
							<th></th>
						</tr>
<?php
		}
		printBilhete($row);
	}
	
	printEndAcontecimento();
?>
</table>
<?php
	require_once rootPath('includes/sijo/master_footer.php', 1);
?>