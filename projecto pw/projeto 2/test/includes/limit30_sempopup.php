<div id="contagem">
<?php
if(isset($_SESSION['mensagem_limit30']))
{
	echo 'Não vai poder efectuar alterações nas equipas e nos atletas';
}else{?>
	<p class="relogio" id="relogio"></p>
	<?php
}
?>
</div>