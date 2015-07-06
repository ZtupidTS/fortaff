
<div id="bandeira">
<a> 
	<p class="img_bandeira"><img src="../images/Bandeiras/<?= $_SESSION["cod_delegacao_utilizador"];?>.png"></p>
	<p class="texto_bandeira"><?= $_SESSION["nome_pais"];?></p>
	<p class="texto_bandeira"><?= $_SESSION["nome_responsavel"];?></p>
	<?php
	require_once '../funcao/funcao_formulario.php';
	$data_ultimo_acesso = inverte_data($_SESSION["ultimo_acesso"]);
	#$data = $_SESSION["ultimo_acesso"];
	?>
	<p class="texto_bandeira">Ultimo acesso:<br> <?= $data_ultimo_acesso;?></p>
	<p class="terminar"><?php include 'terminar_sessao.php';?>
</a>
</div>