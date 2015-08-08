<?php

$odb;

/*##########  Ligação a base de dados  ##########*/
function openDataBase($server, $database, $user, $pw)
{
	global $odb;
        #$odb = mysql_connect($server, $user, $pw);
        $odb = mysql_connect($server, $user, $pw);
        	
	if ($odb == null) {
		return false;
	}
	
	mysql_select_db($database);
	InitializeObjects();
        $database_charset = "utf8";
        mysql_query("SET CHARACTER SET '$database_charset'", $odb);
	return $odb;
}

function closeDataBase()
{
	global $odb;
	mysql_close($odb);
}

function InitializeObjects()
{
	if (!isset($_SESSION['mySql_objects'])){
		$_SESSION['mySql_objects'] = array();
	}
	
	$_SESSION['mySql_objects']['error'] = false;
	$_SESSION['mySql_objects']['errorObj'] = getLastError();
}

/*##########  Erros  ##########*/
function clearError()
{
	$_SESSION['mySql_objects']['error'] = false;
}

function ocurrenceError()
{
	return $_SESSION['mySql_objects']['error'];
}

function reportError()
{
	$_SESSION['mySql_objects']['error'] = true;
	$_SESSION['mySql_objects']['errorObj'] = getLastError();
}

function getLastErrorMessage()
{
	global $odb;
	return mysql_error($odb);
}

function getLastErrorNumber()
{
	global $odb;
	return mysql_errno($odb);
}

function getLastError()
{
	$error = array();
	$error["num"] = getLastErrorNumber();
	$error["msg"] = getLastErrorMessage();
	return $error;
}

/*##########  Métodos de Leitura  ##########*/
//neste método depois fazer o mysql_fetch_array
function getTable($table, $where, $orderBy)
{
	$sql = "SELECT * FROM " . $table . " ";
	
	if ($where !== "") {
		$sql .= " WHERE " . $where . " ";
	}
	
	if ($orderBy !== "") {
		$sql .= " ORDER BY " . $orderBy . " ";
	}
	return executeReader($sql);
}

function getTableDistinct($table, $column, $where, $orderBy)
{
	$sql = "SELECT DISTINCT " . $column . " FROM " . $table . " ";
	
	if ($where !== "") {
		$sql .= " WHERE " . $where . " ";
	}
	
	if ($orderBy !== "") {
		$sql .= " ORDER BY " . $orderBy . " ";
	}
	return executeReader($sql);
}

function getTableCount($table, $where, $orderBy)
{
	return mysql_num_rows(getTable($table, $where, $orderBy));
}

function executeReader($sql)
{
	try {
		global $odb;
		clearError();
		return mysql_query($sql, $odb);
	} catch (Exception $ex) {
		reportError();
	}
}

function getInsertID()
{
	try {
		global $odb;
		clearError();
		return mysql_insert_id($odb);
	} catch (Exception $ex) {
		reportError();
	}
}

/*##########  Métodos de Escrita  ##########*/
/* $autoincrement = boolean */
function insertRecord($table, $fields, $autoIncrement)
{
	$columns = "";
	$values = "";
	$query = "";
	
	foreach ($fields as $column => $value) {
		if ($columns !== "") $columns .= ", ";
		if ($values !== "") $values .= ", ";
		$columns .= $column;
		$values .= $value;
	}
	
	$query = "INSERT INTO $table ($columns) VALUES ($values)";
	executeQuery($query);
	
	if ($autoIncrement) {
		return getInsertID();
	} else {
		return -1;
	}

}

function updateRecord($table, $fields, $where) {

	$columns = "";
	$query = "";
	
	foreach ($fields as $column => $value) {
		if ($columns !== "") $columns .= ", ";
		$columns .= "$column = $value";
	}
	
	$query = "UPDATE $table SET $columns WHERE $where";
	//echo $query;
	executeQuery($query);

}

function deleteRecord($table, $where) {

	$query = "DELETE FROM $table WHERE $where";
	executeQuery($query);

}

function executeQuery($sql)
{
	//try {
		global $odb;
	//	clearError();
		
		mysql_unbuffered_query($sql, $odb);
	//} catch (Exception $ex) {
	//	reportError();
	//}
}

/*##########  M�todos de Auxiliares  ##########*/

function dbString($value) {
	return "'" . mysql_escape_string(strval($value)) ."'";
}

function dbInteger($value) {
	return strval($value);
}

function dbFloat($value) {
	return str_replace(',', '.', strval($value));
}

function dbDate($value) {

}

function dbDateTime($value) {

}

function dbBoolean($value) {
	if ($value === false) return "0"; else return "1";
}

/*##########  M�todos de Itera��o  ##########*/
function foreachRow($table)
{
	return mysql_fetch_array($table);
}

function foreachColumn($row)
{
	return mysql_fetch_row($row);
}

?>
