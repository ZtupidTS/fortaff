<?php
if(isset($_SESSION["login_utilizador"]))
{
	$intruso = true;
	include 'ligacao.php';
	$db_verify = mysql_query("SELECT * FROM delegacao WHERE estado_valido != 'X'");
	while($dados = mysql_fetch_array($db_verify))
	{
		if($dados['login'] == $_SESSION["login_utilizador"] && $dados['password'] == $_SESSION["password_utilizador"] && $dados['cod_delegacao'] == 'co')
		{
			$intruso = false;
		}
	}
	if($intruso)
	{
		$_SESSION["login_false"] = true;
		header('Location: ../login/area_reservada.php');
	}#redirecciona para area_reservada caso seja um intruso
	mysql_close($conexao);
}else{
	#$_SESSION["login_false"] = true;
	header('Location: ../login/area_reservada.php');
}//if(isset($_SESSION))
?>