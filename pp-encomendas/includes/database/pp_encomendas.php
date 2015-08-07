<?php

//obtenho uma guia de reparação e só uma aqui
function encomendasGetById($id)
{
    $t = getTable("pp_encomendas", "pp_enc_id = ".dbInteger($id), "");
    return foreachRow($t);
}

//minha para procurar o que pretendo
//fazer o mysql_fetch_array
function encomendasGetByFiltro($where, $orderby)
{
    return getTable("pp_encomendas", $where, $orderby);
}

function encomendasGetByDistinct($where, $orderby)
{
	$column = $orderby;
	return getTableDistinct("pp_encomendas", $column, $where, $orderby);	
}

function encomendasGetAll()
{
        return getTable("pp_encomendas", "", "");
}

function encomendasGetAllEnable()
{
	return etTable("pp_encomendas", "pp_enc_enable = 1", "pp_enc_id");
}

//devolve me o id inserido
function encomendasInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("pp_encomendas", $fields, true);
}

//tenho que mandar o id e depois ele trato do resto
function encomendasUpdate($fields)
{
        $where = "pp_enc_id = " . dbString($fields['pp_enc_id']);
        unset($fields['pp_enc_id']);

        updateRecord("pp_encomendas", $fields, $where);
}

?>