<?php
include '../includes/allpageaj.php';

$de = sectionGetAll();

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
}
closeDataBase();
?>