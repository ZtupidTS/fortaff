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
        $where = "enable = 0";
        return getTable('Users', $where, 'name');
}

function loginGetEnable()
{
        $where = "enable = 1";
        return getTable('Users', $where, 'name');
}

function loginGetAll()
{
        return getTable("Users", "", "");
}

function loginGetAllWithoutAdmin()
{
	$where = "name != 'Admin' AND enable = 1";
        return getTable("Users", $where, "name");
}

function usersUpdate($fields)
{
        $where = "id = " . dbString($fields['id']);
        unset($fields['id']);

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

