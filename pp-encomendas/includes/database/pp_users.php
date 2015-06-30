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