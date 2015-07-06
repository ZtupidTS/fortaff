<?php
$linhas_totais = $dados_linhas['linhas_total'];
$linhas_por_pagina = 15;
#essa função arredonda por cima (ex: 5.2 passa a ser 6)
$numero_de_pagina = ceil($linhas_totais/$linhas_por_pagina);

if(isset($_GET['pagina']))
{
	$pagina_actual = intval($_GET['pagina']);
	#este if é no caso do utilizador meter um numero de pagina superior ao que existe
	if($pagina_actual > $numero_de_pagina) 
	{
		$pagina_actual=$numero_de_pagina;
	}
	#este if é no caso do utilizador alterar a pagina para 0
	if($pagina_actual <= 0)
	{
		$pagina_actual = 1;
	}
}else{
	$pagina_actual = 1;    
}
# -1 porque começa em 0
$primeira_entrada=($pagina_actual-1)*$linhas_por_pagina;
?>