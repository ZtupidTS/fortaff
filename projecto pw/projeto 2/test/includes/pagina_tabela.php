<div id="pagina">
<?php
//echo $numero_de_pagina;
if(!(isset($_GET['pagina'])))
{
	$_SESSION['url_pagina'] = pathinfo($_SERVER['REQUEST_URI'], PATHINFO_BASENAME);
}
#texto para pagina
echo '<p align="center">Página: '; 
if($numero_de_pagina == 0)
{
	echo "[1]";
}
else{
	for($i=1; $i<=$numero_de_pagina; $i++)
	{
		if($i == $pagina_actual)
		{
			echo '['.$i.']'; 
		}	
		else{
			echo '<a href="'.$_SESSION['url_pagina'].'?pagina='.$i.'">'.$i.'</a> ';
		}
	}
}
echo '</p>';	
?>
</div>