<?php

//obtenho todas as modificações feita numa guia
function modifgrGet($id)
{
    return getTable("modifgr", "gr_id = $id", "modif_date");
}

//rejet = null se não o quero nos meus filtros
//status o que eu pretendo
// se meto id = -1 faz as outras coisas
function modifgrGetByFiltro($id, $status_array, $reject_status_array)
{
    $where = '';

    if ($id !== -1) {
            $where .= ($where == '') ? '' : ' AND ';
            $where .= "id = " . dbInteger($id);
    }

    if ($status_array !== null) {
            $where .= ($where == '') ? '' : ' AND ';
            $where .= "status IN ('" . join("', '", $status_array) . "')";
    }

    if ($reject_status_array !== null) {
            $where .= ($where == '') ? '' : ' AND ';
            $where .= "status NOT IN ('" . join("', '", $reject_status_array) . "')";
    }

    //ultima variável é para o order by
    return getTable('modifgr', $where, 'modif_date');
}

function modifgrGetAll()
{
        return getTable("modifgr", "", "");
}

function modifgrInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("modifgr", $fields, true);
}

//tenho que mandar o id e depois ele trato do resto
/*function modifgrUpdate($fields)
{
        $where = "id = " . dbString($fields['id']);
        unset($fields['id']);

        updateRecord("modifgr", $fields, $where);
}*/
?>
