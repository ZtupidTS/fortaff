<?php

//obtenho todas as modificações feita numa guia
function modifrepGet($id)
{
    return getTable("modifrep", "rep_id = $id", "modif_date");
}

function modifrepGetAll()
{
        return getTable("modifrep", "", "");
}

function modifrepInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("modifrep", $fields, true);
}

//tenho que mandar o id e depois ele trato do resto
function modifrepUpdate($fields)
{
        $where = "id = " . dbString($fields['id']);
        unset($fields['id']);

        updateRecord("modifrep", $fields, $where);
}
?>