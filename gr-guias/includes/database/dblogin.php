<?php

function loginGet($id)
{
        $t = getTable("users", "us_id = $id", "");
        return foreachRow($t);
}

function loginGetByEnableAdmin()
{
        $where = "us_password IS NULL AND us_enable = 1";
        return getTable('users', $where, 'us_name');
}

function loginGetDisable()
{
        $where = "us_password IS NULL AND us_enable = 0";
        return getTable('users', $where, 'us_name');
}

function loginGetAll()
{
        return getTable("users", "", "");
}

function usersUpdate($fields)
{
        $where = "us_id = " . dbString($fields['us_id']);
        unset($fields['us_id']);

        updateRecord("users", $fields, $where);
}

function getLoginAdmin($password)
{
	$t = getTable("users", "us_name = 'admin' AND us_password = " . $password, "");
	return $t;
}

function loginInsert($fields)
{
    #$fields['id'] = insertRecord("grep", $fields, true);
    return insertRecord("users", $fields, true);
}

?>

