<?php

//obtenho uma guia de reparação e só uma aqui
function grepGetById($id)
{
    $t = getTable("pp_modif_encomendas", "pp_modif_enc_id = $id", "pp_modif_date");
    return foreachRow($t);
}

//minha para procurar o que pretendo
//fazer o mysql_fetch_array
function grepGetByFiltro($where, $orderby)
{
    return getTable("pp_modif_encomendas", $where, $orderby);
}

function grepGetByDistinct($where, $orderby)
{
	$column = $orderby;
	return getTableDistinct("pp_modif_encomendas", $column, $where, $orderby);	
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
        return getTable("pp_modif_encomendas", "", "");
}

function grepInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("pp_modif_encomendas", $fields, true);
}

//tenho que mandar o id e depois ele trato do resto
/*function grepUpdate($fields)
{
        $where = "pp_enc_id = " . dbString($fields['pp_enc_id']);
        unset($fields['pp_enc_id']);

        updateRecord("pp_modif_encomendas", $fields, $where);
}*/

?>