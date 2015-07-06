<?php include 'includes/cabecalho.php';?>
	
		<div data-role="page">
			<div data-role="header">
				<h1>Provas</h1>
				<img src="images/icon.png"/>
			</div>
			 
			<div data-role="content">
				<ul data-role="listview">
					<?php
					$db = mysql_query("SELECT * FROM prova WHERE estado_valido = 'V' ORDER BY data");
					while($dados = mysql_fetch_array($db))
					{?>
						<li>
						<?php
						$db_modalidade = mysql_query("SELECT * FROM modalidade WHERE cod_modalidade = '$dados[cod_modalidade]'");
						$dados_modalidade = mysql_fetch_array($db_modalidade);
						echo $dados_modalidade['nome_modalidade']."<br/>";
						require_once '../funcao/funcao_formulario.php';
						echo $dados['local'].': '.inverte_data($dados['data'])."<br/>";
						require_once '../funcao/funcao_formulario.php';
						$hora = dividir_hora($dados['hora_inicio']);
						echo 'As '.$hora[0].':'.$hora[1]."<br/>";
						echo 'Preço: '.$dados['preco'] . '€'."<br/>";
						$db_lug_vazio = mysql_query("SELECT * FROM lugares_vazios_prova WHERE cod_prova = '$dados[cod_prova]'");
						$dados_lug_vazio = mysql_fetch_array($db_lug_vazio);
						echo 'Lug Vazios: '.$dados_lug_vazio['lugar_vazios']; 
						?>
						</li>
						<?php
					}?>
					
				</ul>
		
		
<?php include 'includes/rodape.php';?>