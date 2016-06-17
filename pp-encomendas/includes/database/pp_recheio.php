<?php

//obtenho uma guia de reparação e só uma aqui
function recheioGetById($id)
{
    $t = getTable("pp_recheio", "pp_recheio_id = ".dbInteger($id), "");
    return foreachRow($t);
}

//minha para procurar o que pretendo
//fazer o mysql_fetch_array
function recheioGetByFiltro($where, $orderby)
{
    return getTable("pp_recheio", $where, $orderby);
}

function recheioGetByDistinct($where, $orderby)
{
	$column = $orderby;
	return getTableDistinct("pp_recheio", $column, $where, $orderby);	
}

function recheioGetAll()
{
        return getTable("pp_recheio", "", "pp_recheio_designacao");
}

//devolve me o id inserido
function recheioInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("pp_recheio", $fields, true);
}

//tenho que mandar o id e depois ele trato do resto
function recheioUpdate($fields)
{
        $where = "pp_recheio_id = " . dbString($fields['pp_recheio_id']);
        unset($fields['pp_recheio_id']);

        updateRecord("pp_recheio", $fields, $where);
}

?>