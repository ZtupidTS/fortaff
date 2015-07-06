<?php include 'includes/cabecalho.php';?>
	
		<div data-role="page">
			<div data-role="header">
				<h1>Eventos</h1>
			</div>
			 
			<div data-role="content">
				<ul data-role="listview">
					<li><img src="images/icon.png"/></li>
					<?php
					$db = mysql_query("SELECT * FROM evento WHERE estado_valido = 'V'");
					while($dados = mysql_fetch_array($db))
					{?>
						<li>
						<?php
						echo $dados['designacao'].': '.$dados['descricao']."<br/>";
						require_once '../funcao/funcao_formulario.php';
						echo 'Dia '.inverte_data($dados['data'])."<br/>";
						require_once '../funcao/funcao_formulario.php';
						$hora = dividir_hora($dados['hora_inicio']);
						echo 'As '.$hora[0].':'.$hora[1]."<br/>";
						echo 'Preço: '.$dados['preco'] . '€'."<br/>";
						$db_lug_vazio = mysql_query("SELECT * FROM lugares_vazios_evento WHERE cod_evento = '$dados[cod_evento]'");
						$dados_lug_vazio = mysql_fetch_array($db_lug_vazio);
						echo 'Lug Vazios: '.$dados_lug_vazio['lugar_vazios']."<br/>";
						?>
						</li>
						<?php
					}?>
					
				</ul>
		
		
<?php include 'includes/rodape.php';?>