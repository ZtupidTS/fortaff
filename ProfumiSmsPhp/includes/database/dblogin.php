<?php

function loginGet($id)
{
        $t = getTable("Users", "id = $id", "");
        return foreachRow($t);
}

function loginGetByEnableAdmin()
{
        $where = "password IS NULL AND us_enable = 1";
        return getTable('Users', $where, 'us_name');
}

function loginGetDisable()
{
        $where = "us_password IS NULL AND us_enable = 0";
        return getTable('Users', $where, 'us_name');
}

function loginGetAll()
{
        return getTable("Users", "", "");
}

function loginGetAllWithoutAdmin()
{
	$where = "name != 'Admin'";
        return getTable("Users", $where, "name");
}

function usersUpdate($fields)
{
        $where = "us_id = " . dbString($fields['us_id']);
        unset($fields['us_id']);

        updateRecord("Users", $fields, $where);
}

function getLoginAdmin($password)
{
	$t = getTable("Users", "name = 'Admin' AND password = " . $password, "");
	return $t;
}

function loginInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("Users", $fields, true);
}

?>

