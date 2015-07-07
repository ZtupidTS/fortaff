<?php

//obtenho uma guia de reparação e só uma aqui
function boloGetById($id)
{
    $t = getTable("pp_bolo", "pp_bolo_id = ".dbInteger($id), "");
    return foreachRow($t);
}

//minha para procurar o que pretendo
//fazer o mysql_fetch_array
function boloGetByFiltro($where, $orderby)
{
    return getTable("pp_bolo", $where, $orderby);
}

function boloGetByDistinct($where, $orderby)
{
	$column = $orderby;
	return getTableDistinct("pp_bolo", $column, $where, $orderby);	
}

//tenho que fazer o mysql_fetch_array
function boloGetAll()
{
        return getTable("pp_bolo", "", "");
}

//devolve me o id inserido
function boloInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("pp_bolo", $fields, true);
}

//tenho que mandar o id e depois ele trato do resto
function boloUpdate($fields)
{
        $where = "pp_bolo_id = " . dbString($fields['pp_bolo_id']);
        unset($fields['pp_bolo_id']);

        updateRecord("pp_bolo", $fields, $where);
}

?>