<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<body>
	<?php header("Content-Type: text/html;  charset=ISO-8859-1",true); ?>
	<?php
	#codigo para o global
	if($_GET['tabela'] == 'global')
	{?>
		<table id="results">
			<th colspan="2">Estatísticas Globais</th>
			<tr>
				<td>Numero total de delega&ccedil;&otilde;es</td>
					<?php
					require_once '../../funcao/funcao_formulario.php';
					$total = (estatistica('delegacao'));
					?>
				<td><?= $total['total'];?></td>
			</tr>
			<tr>
				<td>Numero total de equipas</td>
					<?php
					$total = (estatistica('equipa'));
					?>
				<td><?= $total['total'];?></td>
			</tr>
			<tr>
				<td>Número total de atletas</td>
					<?php
					require_once '../../funcao/funcao_formulario.php';
					$total_M = (estatistica_sexo('dados_atletas','M'));
					$total_F = (estatistica_sexo('dados_atletas','F'));
					?>
					<td>
						<?= $total_M['total'];?> <img src="../images/sexo/sexo_feminino.png" alt="Feminino" title="feminino"/>
						<?= $total_F['total'];?> <img src="../images/sexo/sexo_masculino.png" alt="masculino" title="masculino"/>
					</td>
			</tr>
			<tr>
				<td>Número total de auxiliares</td>
					<?php
					$total = (estatistica('dados_auxiliares'));
					?>
				<td><?= $total['total'];?></td>
			</tr>
			<tr>
				<td>Total de pessoas que assistiram aos eventos</td>
					<?php
					include '../../includes/ligacao.php';
					$total_ev = mysql_fetch_array(mysql_query("SELECT sum(lugares_reservados) AS total FROM evento WHERE estado_valido = 'V'"));
					$total_pr = mysql_fetch_array(mysql_query("SELECT sum(lugares_reservados) AS total FROM prova WHERE estado_valido = 'V'"));
					$total = $total_ev['total'] + $total_pr['total'];
					mysql_close($conexao);
					?>
				<td><?= $total;?></td>
			</tr>
		</table>
		<?php
	}
	#codigo para as medalhas
	if($_GET['tabela'] == 'medalhas')
	{?>
		<table id="results">
			<tr>
				<th>Delega&ccedil;&otilde;es</th>
				<th><img src="../images/medalhas/ouro.png" alt="Ouro" title="Ouro" class="bandeiras" /></th>
				<th><img src="../images/medalhas/prata.png" alt="prata" title="prata"class="bandeiras" /></th>
				<th><img src="../images/medalhas/bronze.png" alt="bronze" title="bronze"class="bandeiras" /></th>
			</tr>
			<?php
			include '../../includes/ligacao.php';
			#aqui vou recuperar o cod_delegacao dos atletas e equipas que ja tiveram uma classificação
			$db = mysql_query("SELECT distinct cod_delegacao FROM classificacao_atleta");
			$del_array = array();
			while($dados = mysql_fetch_array($db))
			{
				array_push($del_array, $dados['cod_delegacao']);
			}
			$db = mysql_query("SELECT distinct cod_delegacao FROM classificacao_equipa");
			while($dados = mysql_fetch_array($db))
			{
				if(!in_array($dados['cod_delegacao'],$del_array))
				{
					array_push($del_array, $dados['cod_delegacao']);
				}
			}
			#agora vou criar a tabela com as medalhas
			for($i=0;$i<sizeof($del_array);$i++)
			{
				$ouro=0;
				$prata=0;
				$bronze=0;
				$nome_pais = "";
				$db = mysql_query("SELECT * FROM classificacao_equipa WHERE cod_delegacao = '$del_array[$i]'");
				if(mysql_num_rows($db) > 0)
				{
					while($dados = mysql_fetch_array($db))
					{
						$nome_pais = $dados['nome_pais'];
						switch($dados['classificacao'])
						{
							case ($dados['classificacao'] == 1);
								$ouro++;
								break;
							case ($dados['classificacao'] == 2);
								$prata++;
								break;
							case ($dados['classificacao'] == 3);
								$bronze++;
								break;
						}
					}
				}
				$db = mysql_query("SELECT * FROM classificacao_atleta WHERE cod_delegacao = '$del_array[$i]'");
				if(mysql_num_rows($db) > 0)
				{
					while($dados = mysql_fetch_array($db))
					{
						$nome_pais = $dados['nome_pais'];
						switch($dados['classificacao'])
						{
							case ($dados['classificacao'] == 1);
								$ouro++;
								break;
							case ($dados['classificacao'] == 2);
								$prata++;
								break;
							case ($dados['classificacao'] == 3);
								$bronze++;
								break;
						}
					}
				}?>
				<tr>
					<td class="delegação_nome">
						<img src="../images/Bandeiras/<?= $del_array[$i];?>.png" class="bandeiras"/>
						<?php echo $nome_pais; ?>
					</td>				
					<td><?=$ouro;?></td>
					<td><?=$prata;?></td>
					<td><?=$bronze;?></td>
				</tr>
				<?php
			}?>	
		</table><?php	
		mysql_close($conexao);
	}
	#codigo para a idade média
	if($_GET['tabela'] == 'idade')
	{?>
		<table id="results">
			<tr>
				<th>Delega&ccedil;&otilde;es</th>
				<th>Idade m&#233dia</th>
			</tr>
			<?php
			include '../../includes/ligacao.php';
			#aqui vou recuperar o cod_delegacao dos atletas e auxiliares criados
			$db = mysql_query("SELECT distinct cod_delegacao FROM dados_atletas WHERE estado_valido = 'V'");
			$del_array = array();
			while($dados = mysql_fetch_array($db))
			{
				array_push($del_array, $dados['cod_delegacao']);
			}
			$db = mysql_query("SELECT distinct cod_delegacao FROM dados_auxiliares WHERE estado_valido = 'V'");
			while($dados = mysql_fetch_array($db))
			{
				if(!in_array($dados['cod_delegacao'],$del_array))
				{
					array_push($del_array, $dados['cod_delegacao']);
				}
			}
			#agora que tenho o array das delegações vou calcular a idade média para cada delegação
			for($i=0;$i<sizeof($del_array);$i++)
			{
				$idade_total=0;
				$count=0;
				$nome_pais = "";
				$db = mysql_query("SELECT distinct cod_elemento_equipa, nome_pais, data_nasc FROM dados_atletas WHERE cod_delegacao = '$del_array[$i]' and estado_valido = 'V'");
				if(mysql_num_rows($db) > 0)
				{
					while($dados = mysql_fetch_array($db))
					{
						$nome_pais = $dados['nome_pais'];
						#converte a data recebida do mysql em segundos referente à data (timestamp do php)
						$data_mysql = strtotime($dados['data_nasc']);
						#chama a função que vai converter e retornar o valor da diferença
						require_once '../../funcao/funcao_diff_data.php';
						$data_devolvida = diff_data_ano($data_mysql);
						$idade_total += $data_devolvida;
						$count++;
					}
				}
				$db = mysql_query("SELECT distinct cod_elemento_equipa, nome_pais, data_nasc FROM dados_auxiliares WHERE cod_delegacao = '$del_array[$i]' and estado_valido = 'V'");
				if(mysql_num_rows($db) > 0)
				{
					while($dados = mysql_fetch_array($db))
					{
						$nome_pais = $dados['nome_pais'];
						#converte a data recebida do mysql em segundos referente à data (timestamp do php)
						$data_mysql = strtotime($dados['data_nasc']);
						#chama a função que vai converter e retornar o valor da diferença
						require_once '../../funcao/funcao_diff_data.php';
						$data_devolvida = diff_data_ano($data_mysql);
						$idade_total += $data_devolvida;
						$count++;
					}
				}?>
				<tr>
					<td class="delegação_nome">
						<img src="../images/Bandeiras/<?= $del_array[$i];?>.png" class="bandeiras"/>
						<?php echo $nome_pais; ?>
					</td>				
					<td><?=($idade_total/$count);?></td>
				</tr>
				<?php
			}?>
		</table>
		<?php
	}?>	
	</body>
</html>