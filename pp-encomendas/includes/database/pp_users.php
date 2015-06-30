<?php

//obtenho uma guia de reparação e só uma aqui
function usersGetById($id)
{
    $t = getTable("pp_users", "pp_us_id = $id", "");
    return foreachRow($t);
}

//minha para procurar o que pretendo
//fazer o mysql_fetch_array
function usersGetByFiltro($where, $orderby)
{
    return getTable("pp_users", $where, $orderby);
}

function usersGetByDistinct($where, $orderby)
{
	$column = $orderby;
	return getTableDistinct("pp_users", $column, $where, $orderby);	
}

function usersGetAll()
{
        return getTable("pp_users", "pp_us_enable = 1", "");
}

function usersInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("pp_users", $fields, true);
}

//tenho que mandar o id e depois ele trato do resto
function usersUpdate($fields)
{
        $where = "pp_us_id = " . dbString($fields['pp_us_id']);
        unset($fields['pp_us_id']);

        updateRecord("pp_users", $fields, $where);
}

?>