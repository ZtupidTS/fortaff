<?php 
session_start();

include '../includes/ligacao.php';
require_once '../funcao/funcao_formulario.php';
$nome = control_post($_POST['nome']);
$apelido = control_post($_POST['apelido']);
$nif = control_post($_POST['nif']);
$morada = control_post($_POST['morada']);
$telemovel = control_post($_POST['telemovel']);
$email1 = control_post($_POST['email1']);
$email2 = control_post($_POST['email2']);
$login = control_post($_POST['login']);
$psw = control_post($_POST['psw']);
$psw2 = control_post($_POST['psw2']);

$email = $email1 . "@" . $email2;
$controle = true;

if(!is_numeric($nif) && $nif != "")
{
	$_SESSION["mensagem"] = "O numero de contribuinte s� pode conter numeros";
	mysql_close($conexao);
	$controle = false;
	header('Location: registo_vis.php');
}
$nif_existe = mysql_query("SELECT * FROM visitante WHERE nif = '$nif' and id_visitante != '$_SESSION[id_vis]'");
if(mysql_num_rows($login_existe) > 0 && $controle)
{
	$_SESSION["mensagem"] = "Nif j� existente, por favor verifica o numero introduzido";
	mysql_close($conexao);
	$controle = false;
	header('Location: registo_vis.php');
}
if(!is_numeric($telemovel) && $telemovel != "" && $controle)
{
	$_SESSION["mensagem"] = "O numero de telemovel s� pode conter numeros";
	mysql_close($conexao);
	$controle = false;
	header('Location: registo_vis.php');
}
$telem_existe = mysql_query("SELECT * FROM visitante WHERE telemovel = '$telemovel' and id_visitante != '$_SESSION[id_vis]'");
if(mysql_num_rows($telem_existe) > 0 && $controle)
{
	$_SESSION["mensagem"] = "Numero de telem�vel j� existente, por favor verifica o numero introduzido";
	mysql_close($conexao);
	$controle = false;
	header('Location: registo_vis.php');
}
$login_existe = mysql_query("SELECT * FROM visitante WHERE login = '$login' and id_visitante != '$_SESSION[id_vis]'");
if(mysql_num_rows($login_existe) > 0 && $controle)
{
	$_SESSION["mensagem"] = "Login j� existente, escolha outro";
	mysql_close($conexao);
	$controle = false;
	header('Location: registo_vis.php');
}
if(!(strcmp($psw,$psw2) == 0) && $psw != "" && $controle)
{
	$_SESSION["mensagem"] = "As palavras passes n�o coincidem";
	mysql_close($conexao);
	$controle = false;
	header('Location: registo_vis.php');
}
$email_existe = mysql_query("SELECT * FROM visitante WHERE email = '$email' and id_visitante != '$_SESSION[id_vis]'");
if(mysql_num_rows($email_existe) > 0 && $controle)
{
	$_SESSION["mensagem"] = "Email j� existente, por favor verifica o email introduzido";
	mysql_close($conexao);
	$controle = false;
	header('Location: registo_vis.php');
}
if($email1 != "" && $email2 != "" && $controle)
{
	mysql_query("UPDATE visitante SET nome = '$nome', apelido = '$apelido', nif = '$nif', morada = '$morada', telemovel = '$telemovel', email = '$email', login = '$login', password = '$psw' WHERE id_visitante = '$_SESSION[id_vis]'");
	if(mysql_affected_rows() > 0)
	{
		#vou para a pagina de registo com sucesso
		mysql_close($conexao);
		require_once '../funcao/funcao_formulario.php';
		$mail = enviamail($email,$login,$psw);
		$_SESSION['nome_vis'] = $nome;
		$_SESSION['email_vis'] = $email;
		$_SESSION['apelido_vis'] = $apelido;
		$_SESSION['nif_vis'] = $nif;
		$_SESSION['morada_vis'] = $morada;
		$_SESSION['telemovel_vis'] = $telemovel;
		$_SESSION['login_vis'] = $login;
		$_SESSION['ult_acesso'] = $ult_acesso;
		header('Location: registo_ok.php');
		
	}else{
		$_SESSION["mensagem"] = 'Ocorreu um erro volta a tentar';
		mysql_close($conexao);
		header('Location: registo_vis.php');
	}
}?>

