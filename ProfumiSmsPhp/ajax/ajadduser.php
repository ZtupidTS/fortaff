<?php
include '../includes/allpage.php';


//aqui faço o update da tabela grep e faço o registo na tabela modif.
$fields = array();
$fields['name'] = dbString($_POST['user']);
$fields['password'] = dbString($_POST['pass']);
loginInsert($fields);
unset($fields);

//agora a tabela modif
//insertmodifgr($_POST['id_gr'], 'Mensagem processada, verificar dentro de 5 min o estado dela');
/*if(strlen($error) > 0 )
{
	echo $error;	
}else{*/
echo "ok";	
//}
	

closeDataBase();
?>