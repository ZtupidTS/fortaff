<div id="contagem">
<?php
if(isset($_SESSION['mensagem_limit30']))
{
	echo 'N�o vai poder efectuar altera��es nas equipas e nos atletas';
}else{?>
	<p class="relogio" id="relogio"></p>
	<?php
}
?>
</div>