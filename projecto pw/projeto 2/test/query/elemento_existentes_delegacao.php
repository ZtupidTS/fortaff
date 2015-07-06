<?php
function elemento_existentes_delegacao($cod_delegacao, $cod_equipa)
{
	#$cod_elemento_equipa = mysql_query("SELECT ei.cod_elemento_equipa FROM elemento_in_equipa ei, equipa eq WHERE ei.cod_equipa = eq.cod_equipa and eq.cod_delegacao = '$cod_delegacao' and ei.estado_valido != 'X' and ei.cod_equipa != '$cod_equipa'");
	#$cod_elemento_equipa = mysql_query("SELECT distinct ei.cod_elemento_equipa FROM elemento_in_equipa ei, equipa eq WHERE ei.cod_equipa = eq.cod_equipa and eq.cod_delegacao = '$cod_delegacao' and ei.cod_equipa != '$cod_equipa' and ei.cod_elemento_equipa not in (SELECT cod_elemento_equipa FROM elemento_in_equipa WHERE cod_equipa = '$cod_equipa')");
	$cod_elemento_equipa = mysql_query("SELECT distinct ei.cod_elemento_equipa FROM elemento_in_equipa ei, equipa eq WHERE ei.cod_equipa = eq.cod_equipa and eq.cod_delegacao = '$cod_delegacao' and eq.sexo = '$_SESSION[sexo_atleta]' and ei.cod_elemento_equipa not in (SELECT cod_elemento_equipa FROM elemento_in_equipa WHERE cod_equipa = '$cod_equipa' and estado_valido != 'X')");
	return $cod_elemento_equipa;
}
?>