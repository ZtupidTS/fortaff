<?php

//obtenho uma guia de reparação e só uma aqui
function modifEncomendasGetById($id)
{
    $t = getTable("pp_modif_encomendas", "pp_modif_enc_id = ".dbInteger($id), "");
    return foreachRow($t);
}

//minha para procurar o que pretendo
//fazer o mysql_fetch_array
function modifEncomendasGetByFiltro($where, $orderby)
{
    return getTable("pp_modif_encomendas", $where, $orderby);
}

function modifEncomendasGetByDistinct($where, $orderby)
{
	$column = $orderby;
	return getTableDistinct("pp_modif_encomendas", $column, $where, $orderby);	
}

function modifEncomendasGetAll()
{
        return getTable("pp_modif_encomendas", "", "");
}

//devolve me o id inserido
function modifEncomendasInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("pp_modif_encomendas", $fields, true);
}

//tenho que mandar o id e depois ele trato do resto
function modifEncomendasUpdate($fields)
{
        $where = "pp_modif_id = " . dbString($fields['pp_modif_id']);
        unset($fields['pp_modif_id']);

        updateRecord("pp_modif_encomendas", $fields, $where);
}

?>