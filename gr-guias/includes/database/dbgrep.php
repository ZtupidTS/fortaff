<?php

//obtenho uma guia de reparação e só uma aqui
function grepGetById($id)
{
    $t = getTable("grep", "id = $id", "");
    return foreachRow($t);
}

function grepGetByGrNumber($grnumber)
{
    $t = getTable("grep", "gr_number = '$grnumber'", "");
    return foreachRow($t);
}

//minha para procurar o que pretendo
//fazer o mysql_fetch_array
function grepGetByFiltro($where, $orderby)
{
    return getTable("grep", $where, $orderby);
}

function grepGetByDistinct($where, $orderby)
{
	$column = $orderby;
	return getTableDistinct("grep", $column, $where, $orderby);	
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

function grepGetAll()
{
        return getTable("grep", "", "");
}

function grepInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("grep", $fields, true);
}

//tenho que mandar o id e depois ele trato do resto
function grepUpdate($fields)
{
        $where = "id = " . dbString($fields['id']);
        unset($fields['id']);

        updateRecord("grep", $fields, $where);
}

//obter o ultimo numero de guias
function gregGetLastNumberGr($year)
{
	$t = getNumberGr("grep", "gr_number LIKE '%".$year."-%'", "gr_number", "1", "gr_number", "DESC");
	return foreachRow($t);
}

?>