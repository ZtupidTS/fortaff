<div class="bordermenu">
	<ul id="nav">
		<li><a href="registo_vis.php">Perfil</a></li>
		<li><a href="opiniao_vis.php">Opinião</a></li>
		<li><a href="javascript:void(0)" onClick="TerminarSessao('<?= $url_actual;?>')">Terminar Sessão</a></li>
		<li><?= 'Bem-Vindo '.$_SESSION['nome_vis'];?></li>
		<li>
			<?php
			require_once '../funcao/funcao_formulario.php';
			$data = inverte_data($_SESSION['ult_acesso']);
			echo 'Última visita '.$data;			
			?>
		</li>
	</ul>
</div>