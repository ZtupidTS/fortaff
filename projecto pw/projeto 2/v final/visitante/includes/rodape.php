<!-- include para a mensagem popup -->

	<div id="menus">	
	</div>
	
<?php
mysql_close($conexao);
include '../includes/mensagem_popup.php';
include 'includes/feed_noticias.php';
?>

	<div id="rodap�">
	<?php
	$css_muda = $_COOKIE['css'];
	switch($css_muda)
	{
	case ($css_muda == 'css/estilo_azul.css');
		?>
		<img src="images/banner/imagemcabe�alhoazul.jpg" alt="Header" class="header_login"/>
		<img src="images/banner/imagemcabe�alhoazul.jpg" alt="Header" class="header_login2"/>
		<?php
		break;
	case ($css_muda == 'css/estilo_amarelo.css');
		?>
		<img src="images/banner/imagemcabe�alhoamarelo.jpg" alt="Header" class="header_login"/>
		<img src="images/banner/imagemcabe�alhoamarelo.jpg" alt="Header" class="header_login2"/>
		<?php
		break;
	case ($css_muda == 'css/estilo_verde.css');
		?>
		<img src="images/banner/imagemcabe�alhoverde.jpg" alt="Header" class="header_login"/>
		<img src="images/banner/imagemcabe�alhoverde.jpg" alt="Header" class="header_login2"/>
		<?php
		break;
	case ($css_muda == 'css/estilo_vermelho.css');
		?>
		<img src="images/banner/imagemcabe�alhovermelho.jpg" alt="Header" class="header_login"/>
		<img src="images/banner/imagemcabe�alhovermelho.jpg" alt="Header" class="header_login2"/>
		<?php
		break;
	}?>
	<div id="rodap�_centro">
	<p> &#160 &#169 2012 JRE - Grupo 609 </p>
	</div>
	</div>

	</div>
	</body>
</html>