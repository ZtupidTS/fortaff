<?php

//obtenho uma guia de reparação e só uma aqui
function viewBoloGetById($id)
{
    $t = getTable("view_nossobolos", "pp_bolo_id = ".dbInteger($id), "");
    return foreachRow($t);
}

//minha para procurar o que pretendo
//fazer o mysql_fetch_array
function viewBoloGetByFiltro($where, $orderby)
{
    return getTable("view_nossobolos", $where, $orderby);
}

function viewBoloGetByDistinct($where, $orderby)
{
	$column = $orderby;
	return getTableDistinct("view_nossobolos", $column, $where, $orderby);	
}

//tenho que fazer o mysql_fetch_array
function viewBoloGetAll()
{
        return getTable("view_nossobolos", "", "");
}


?>