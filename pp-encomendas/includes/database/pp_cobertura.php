<?php

//obtenho uma guia de reparação e só uma aqui
function coberturaGetById($id)
{
    $t = getTable("pp_cobertura", "pp_cobertura_id = ".dbInteger($id), "");
    return foreachRow($t);
}

//minha para procurar o que pretendo
//fazer o mysql_fetch_array
function coberturaGetByFiltro($where, $orderby)
{
    return getTable("pp_cobertura", $where, $orderby);
}

function coberturaGetByDistinct($where, $orderby)
{
	$column = $orderby;
	return getTableDistinct("pp_cobertura", $column, $where, $orderby);	
}

function coberturaGetAll()
{
        return getTable("pp_cobertura", "", "");
}

//devolve me o id inserido
function coberturaInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("pp_cobertura", $fields, true);
}

//tenho que mandar o id e depois ele trato do resto
function coberturaUpdate($fields)
{
        $where = "pp_cobertura_id = " . dbString($fields['pp_cobertura_id']);
        unset($fields['pp_cobertura_id']);

        updateRecord("pp_cobertura", $fields, $where);
}

?>