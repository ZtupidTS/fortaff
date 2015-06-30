<?php

//obtenho uma guia de reparação e só uma aqui
function modifBolosGetById($id)
{
    $t = getTable("pp_modif_bolos", "pp_modif_id = ".dbInteger($id), "");
    return foreachRow($t);
}

//minha para procurar o que pretendo
//fazer o mysql_fetch_array
function modifBolosGetByFiltro($where, $orderby)
{
    return getTable("pp_modif_bolos", $where, $orderby);
}

function modifBolosGetByDistinct($where, $orderby)
{
	$column = $orderby;
	return getTableDistinct("pp_modif_bolos", $column, $where, $orderby);	
}

function modifBolosGetAll()
{
        return getTable("pp_modif_bolos", "", "");
}

//devolve me o id inserido
function modifBolosInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("pp_modif_bolos", $fields, true);
}

//tenho que mandar o id e depois ele trato do resto
function modifBolosUpdate($fields)
{
        $where = "pp_modif_id = " . dbString($fields['pp_modif_id']);
        unset($fields['pp_modif_id']);

        updateRecord("pp_modif_bolos", $fields, $where);
}

?>