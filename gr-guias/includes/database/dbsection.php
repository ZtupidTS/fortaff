<?php

//obtenho uma guia de reparação e só uma aqui
function sectionGetById($id)
{
    $t = getTable("section", "sec_id = $id", "");
    return foreachRow($t);
}

//minha para procurar o que pretendo
//fazer o mysql_fetch_array
function sectionGetByFiltro($where, $orderby)
{
    return getTable("section", $where, $orderby);
}

function sectionGetAll()
{
        return getTable("section", "", "sec_name");
}

function sectionInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("section", $fields, true);
}

//tenho que mandar o id e depois ele trato do resto
function sectionUpdate($fields)
{
        $where = "sec_id = " . dbString($fields['sec_id']);
        unset($fields['sec_id']);

        updateRecord("section", $fields, $where);
}
?>