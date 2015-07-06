<?php 
require_once '../funcao/dia_actual.php';
$data = dia_actual();
$db = mysql_query("SELECT * FROM evento WHERE estado_valido = 'V' and data > '$data' ORDER BY data LIMIT 0,6");
?>
<div class="proximos_6ev">
	<marquee Class="Scroller"  behavior="scroll" direction="left"  scrollamount="2" scrolldelay="0" onmouseout="this.start()">
		<?php
		while($dados = mysql_fetch_array($db))
		{
			echo $dados['designacao'].': '.$dados['descricao'].' dia '.$dados['data'].' às '.$dados['hora_inicio'].' | ';
		}?>
	</marquee>
</div>