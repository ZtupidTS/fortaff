<?php
include '../includes/allpage.php';

//echo $_POST['id_user'];

//aqui faço o update da tabela grep e faço o registo na tabela modif.
$fields = array();
$fields['id'] = $_POST['id_user'];
$fields['enable'] = dbString("1");
usersUpdate($fields);
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