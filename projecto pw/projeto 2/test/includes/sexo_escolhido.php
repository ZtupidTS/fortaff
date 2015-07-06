<?php
$sexo = mysql_query("SELECT * FROM equipa WHERE cod_equipa = '$_SESSION[cod_equipa]'");
$dados_sexo = mysql_fetch_array($sexo);
if($dados_sexo['sexo'] == 'M')
{?>
	<input type="radio" name="sexo" value="M" id="M" checked/><label for="M"><img src="../images/sexo/sexo_masculino.jpg" /></label>
	<?php
}else{
	?>
	<input type="radio" name="sexo" value="F" id="F" checked/><label for="F"><img src="../images/sexo/sexo_feminino.jpg" /></label>
	<?php
}?>