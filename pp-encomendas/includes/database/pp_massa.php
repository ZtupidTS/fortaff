<?php

//obtenho uma guia de reparação e só uma aqui
function massaGetById($id)
{
    $t = getTable("pp_massa", "pp_massa_id = ".dbInteger($id), "");
    return foreachRow($t);
}

//minha para procurar o que pretendo
//fazer o mysql_fetch_array
function massaGetByFiltro($where, $orderby)
{
    return getTable("pp_massa", $where, $orderby);
}

function massaGetByDistinct($where, $orderby)
{
	$column = $orderby;
	return getTableDistinct("pp_massa", $column, $where, $orderby);	
}

function massaGetAll()
{
        return getTable("pp_massa", "", "pp_massa_designacao");
}

//devolve me o id inserido
function massaInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("pp_massa", $fields, true);
}

//tenho que mandar o id e depois ele trato do resto
function massaUpdate($fields)
{
        $where = "pp_massa_id = " . dbString($fields['pp_massa_id']);
        unset($fields['pp_massa_id']);

        updateRecord("pp_massa", $fields, $where);
}

?>