<?php

//obtenho um sms só
function smsGetById($id)
{
    $t = getTable("sms", "id = " . $id, "");
    return foreachRow($t);
}

//minha para procurar o que pretendo
//fazer o mysql_fetch_array
function smsGetByFiltro($where, $orderby)
{
    return getTable("sms", $where, $orderby);
}

//rejet = null se não o quero nos meus filtros
//status o que eu pretendo: id = 'dsadadads',....
// se meto id_grep = -1 faz as outras coisas
//function grepoGetByFiltro($id_grep, $status_array, $reject_status_array)
//{
//    $where = '';
//
//    if ($id_grep !== -1) {
//            $where .= ($where == '') ? '' : ' AND ';
//            $where .= "id = " . dbInteger($id_grep);
//    }
//
//    if ($status_array !== null) {
//            $where .= ($where == '') ? '' : ' AND ';
//            $where .= "status IN ('" . join("', '", $status_array) . "')";
//    }
//
//    if ($reject_status_array !== null) {
//            $where .= ($where == '') ? '' : ' AND ';
//            $where .= "status NOT IN ('" . join("', '", $reject_status_array) . "')";
//    }
//
//    //ultima variável é para o order by
//    return getTable('grep', $where, 'date_in');
//}

function smsGetAll()
{
        return getTable("sms", "", "");
}

function smsInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("sms", $fields, true);
}

//tenho que mandar o id e depois ele trato do resto
function smsUpdate($fields)
{
        $where = "id = " . dbString($fields['id']);
        unset($fields['id']);

        updateRecord("sms", $fields, $where);
}

?>