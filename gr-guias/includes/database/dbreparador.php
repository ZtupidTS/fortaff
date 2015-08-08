<?php

//obtenho uma guia de reparação e só uma aqui
function reparadorGetById($id)
{
    $t = getTable("reparador", "rep_id = $id", "");
    return foreachRow($t);
}

//minha para procurar o que pretendo
//fazer o mysql_fetch_array
function reparadorGetByFiltro($where, $orderby)
{
    return getTable("reparador", $where, $orderby);
}

function reparadorGetAll()
{
        return getTable("reparador", "", "rep_name");
}

function reparadorInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("reparador", $fields, true);
}

//tenho que mandar o id e depois ele trato do resto
function reparadorUpdate($fields)
{
        $where = "rep_id = " . dbString($fields['rep_id']);
        unset($fields['rep_id']);

        updateRecord("reparador", $fields, $where);
}

?>