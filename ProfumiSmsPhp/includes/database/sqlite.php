<?php

$odb;

class MyDB_dev extends SQLite3
{
      function __construct()
      {
         $this->open($_SERVER['DOCUMENT_ROOT'].'db/DB_dev.sqlite');
      }
}

class MyDB_prod extends SQLite3
{
      function __construct()
      {
         $this->open($_SERVER['DOCUMENT_ROOT'].'db/DB.sqlite');
      }
}

function openDataBase($typedb)
{
	global $odb;
	if(strlen($typedb) > 3)
	{
		$odb = new MyDB_prod();
	}else{
		$odb = new MyDB_dev();
	}

	if(!$odb){
	   return $odb->lastErrorMsg();
	} else {
	   return "";
	}
}

function closeDataBase()
{
	global $odb;
	$odb->close();
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

function executeReader($sql)
{
	try {
		global $odb;
		//clearError();
		return $odb->query($sql);
	} catch (Exception $ex) {
		reportError();
	}
}


/*##########  M�todos de Itera��o  ##########*/
function foreachRow($table)
{
	return $table->fetchArray();
}

/*##########  M�todos de Auxiliares  ##########*/

function dbString($value) {
	return "'" . SQLite3::escapeString(strval($value)) ."'";
}

function dbInteger($value) {
	return strval($value);
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
	executeQuery($query);

}

function executeQuery($sql)
{
	global $odb;
	$ret = $odb->exec($sql);
	if(!$ret){
	   echo $odb->lastErrorMsg();
	}
}

function getInsertID()
{
	try {
		global $odb;
		$id_last = $odb->lastInsertRowID();
		return $id_last;
	} catch (Exception $ex) {
		return $odb->lastErrorMsg();
	}
}

?>