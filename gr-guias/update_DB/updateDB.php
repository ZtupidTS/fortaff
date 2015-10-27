<?php
include '../includes/allpageaj.php';

/*$de = sectionGetAll();

if(empty($de))
{
	//echo 'empty';
	$query = "CREATE TABLE section (
                          sec_id int(11) AUTO_INCREMENT,
                          sec_name varchar(50) NOT NULL,
                          sec_enable varchar(1) NOT NULL,
                          PRIMARY KEY (sec_id)
                          )";	
	executeQuery($query);
	
	$fields2 = array();
	$fields2['sec_name'] = dbString("Bazar Ligeiro");
	$fields2['sec_enable'] = dbInteger(1);
	sectionInsert($fields2);
	unset($fields2);
	$fields2 = array();
	$fields2['sec_name'] = dbString('Bazar Pesado');
	$fields2['sec_enable'] = dbInteger(1);
	sectionInsert($fields2);
	unset($fields2);
	$de = sectionGetAll();
	if(empty($de))
	{
		
	}else{
		echo "Script executado com sucesso";
	}
}else{
	echo 'Script não executado';
}*/

$col_name = 'gr_number';

$col = mysql_query("SELECT ".$col_name." FROM grep");

if (!$col){
    mysql_query("ALTER TABLE grep ADD ".$col_name." VARCHAR(7) UNIQUE");

    echo "A coluna " .$col_name." foi acrescentada com sucesso a tabela grep<br/>";
} else {
    echo 'A coluna '.$col_name.' já existe na tabela grep<br/>';
}

$col_name = 'gr_number';

$col = mysql_query("SELECT ".$col_name." FROM modifgr");

if (!$col){
    mysql_query("ALTER TABLE modifgr ADD ".$col_name." VARCHAR(7)");

    echo 'A coluna ' .$col_name.' foi acrescentada com sucesso a tabela modifgr<br/>';
} else {
    echo 'A coluna '.$col_name.' já existe na tabela modifgr<br/>';
}

echo "O script já acabou, já podem fechar a pagina";

closeDataBase();
?>