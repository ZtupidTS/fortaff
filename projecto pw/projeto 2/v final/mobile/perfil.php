<?php 
include 'includes/cabecalho.php';
if(!(isset($_SESSION['id_vis'])))
{
	header('Location: index.php');
}
?>
	
		<div data-role="page">
			<div data-role="header">
				<h1>Perfil</h1>
				<img src="images/icon.png"/>
			</div>
			 
			<div data-role="content">
				<ul data-role="listview">
					<li>Reservas Compras</li>
					<?php
					$db = mysql_query("SELECT * FROM reserva_compra WHERE id_vis = '$_SESSION[id_vis]'");
					while($dados = mysql_fetch_array($db))
					{?>
						<li>
							<?php
							if($dados['tipo'] == 'PR')
							{
								echo 'Prova: ';
							}else{
								echo 'Evento: ';
							}
							if($dados['tipo'] == 'PR')
							{
								$db2 = mysql_fetch_array(mysql_query("SELECT * FROM tipo_prova WHERE cod_prova = '$dados[cod_sessao]'"));
								echo $db2['nome_modalidade'];
							}else{
								$db2 = mysql_fetch_array(mysql_query("SELECT * FROM evento WHERE cod_evento = '$dados[cod_sessao]'"));
								echo $db2['designacao'].', '.$db2['descricao'];
							}
							echo "\n".$dados['re_ou_com'];
							?>							
						</li>
						<?php
					}?>
				</ul>
		
<?php include 'includes/rodape.php';?>
