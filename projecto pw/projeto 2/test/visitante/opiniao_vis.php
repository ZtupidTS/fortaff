<?php
if(!(isset($_SESSION['id_vis'])))
{
	header('Location: visitante.php');
}
include 'includes/cabecalho.php';
?>	
	
	<!-- corpo -->
	
	<!-- insere na BD os dados -->
	<?php
	if(isset($_POST['tipo']))
	{
		if($_POST['conteudo'] != "")
		{
			require_once '../funcao/dia_actual.php';
			$dia_actual = dia_actual();	
			mysql_query("INSERT INTO opiniao (tipo, email, conteudo, data) VALUES ('$_POST[tipo]', '$_SESSION[email_vis]', '$_POST[conteudo]', '$dia_actual')");
			$db = mysql_query("SELECT * FROM informacao_diversas WHERE id = '$_POST[tipo]'");
			$dados = mysql_fetch_array($db);
			if(isset($_POST['email']))
			{
				require_once '../funcao/funcao_formulario.php';
				$mail = enviamail_opiniao($_SESSION['email_vis'],$_POST['conteudo'],$dados['informacao']);
				$_SESSION['mensagem'] = 'Opinião registada com sucesso e uma cópia foi enviada para o seu mail: '.$_SESSION['email_vis'];
			}else{
				$_SESSION['mensagem'] = 'Opinião registada com sucesso';
			}
		}else{
			$_SESSION['mensagem'] = 'Não foi inserido texto';
		}
	}?>
	
	<!-- a tabela de preenchimento da opinião -->
		<div id="opiniao">
		<form id="form_table" method="POST" action="opiniao_vis.php">
			<table>
				<tr>
					<td>
						<select name="tipo">
							<option value="CO">Comentário</option>
							<option value="RE">Reclamação</option>
							<option value="SU">Sugestão</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<textarea name="conteudo" rows="6" cols="50" maxlength="250">
						</textarea>
					</td>
				</tr>
					<td>Receber uma cópia por mail: <input type="checkbox" name="email" value="email"/><br />
				<tr>
					<td><input type="submit" value="Submeter"/></td>
				</tr>
			</table>
		</form>
		<script type="text/javascript" language="javascript" src="js/formulario_inscricao.js"></script>
		</div>
		<!-- em baixo -->
		<?php include 'includes/rodape.php';?>
</html>