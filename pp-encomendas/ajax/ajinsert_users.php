<?php
include '../includes/allpageaj.php';

$login = control_post($_GET['login']);
$password = control_post($_GET['password']);

//antes de inserir verificar se já existe na DB
$us = usersGetByFiltro('pp_us_name = '.dbString($login), '');

if (is_bool($us) === false) 
{
	if(mysql_num_rows($us) > 0)
	{
		echo 'Já existe um utilizador com esse nome';
	}else{
		//vou inserir na DB
		$fields = array();
		$fields['pp_us_name'] = dbString($login);
		$fields['pp_us_password'] = dbString($password);
		usersInsert($fields);
		unset($fields);

		echo 'ok';
		
	}
}else{
	echo 'Pedir assistência ao administrador';
}

closeDataBase();
?>