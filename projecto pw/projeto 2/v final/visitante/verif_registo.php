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

$controle = true;

include_once '../securimage/securimage.php';
$securimage = new Securimage();
if ($securimage->check($_POST['ct_captcha']) == false)
{
	$_SESSION["mensagem"] = "O captcha não foi bem preenchido";
	mysql_close($conexao);
	$controle = false;
	header('Location: registo_vis.php');
}
if(!is_numeric($nif) && $nif != "")
{
	$_SESSION["mensagem"] = "O numero de contribuinte só pode conter numeros";
	mysql_close($conexao);
	$controle = false;
	header('Location: registo_vis.php');
}
if(!is_numeric($telemovel) && $telemovel != "" && $controle)
{
	$_SESSION["mensagem"] = "O numero de telemovel só pode conter numeros";
	mysql_close($conexao);
	$controle = false;
	header('Location: registo_vis.php');
}
$nif_existe = mysql_query("SELECT * FROM visitante WHERE nif = '$nif'");
if(mysql_num_rows($nif_existe) > 0 && $controle)
{
	$_SESSION["mensagem"] = "Nif já existente, por favor verifica o numero introduzido";
	mysql_close($conexao);
	$controle = false;
	header('Location: registo_vis.php');
}
$login_existe = mysql_query("SELECT * FROM visitante WHERE login = '$login'");
if(mysql_num_rows($login_existe) > 0 && $controle)
{
	$_SESSION["mensagem"] = "Login já existente, escolha outro";
	mysql_close($conexao);
	$controle = false;
	header('Location: registo_vis.php');
}
$telem_existe = mysql_query("SELECT * FROM visitante WHERE telemovel = '$telemovel'");
if(mysql_num_rows($telem_existe) > 0 && $controle)
{
	$_SESSION["mensagem"] = "Numero de telemóvel já existente, por favor verifica o numero introduzido";
	mysql_close($conexao);
	$controle = false;
	header('Location: registo_vis.php');
}
if(!(strcmp($psw,$psw2) == 0) && $psw != "" && $controle)
{
	$_SESSION["mensagem"] = "As palavras passes não coincidem";
	mysql_close($conexao);
	$controle = false;
	header('Location: registo_vis.php');
}
$email = $email1 . "@" . $email2;
$email_existe = mysql_query("SELECT * FROM visitante WHERE email = '$email'");
if(mysql_num_rows($email_existe) > 0 && $controle)
{
	$_SESSION["mensagem"] = "Email já existente, por favor verifica o email introduzido";
	mysql_close($conexao);
	$controle = false;
	header('Location: registo_vis.php');
}
if($email1 != "" && $email2 != "" && $controle)
{
	mysql_query("INSERT INTO visitante (nome, apelido, nif, morada, telemovel, email, login, password) VALUES ('$nome', '$apelido', $nif, '$morada', $telemovel, '$email', '$login', '$psw')");
	if(mysql_affected_rows() > 0)
	{
		#vou para a pagina de registo com sucesso
		mysql_close($conexao);
		require_once '../funcao/funcao_formulario.php';
		$mail = enviamail($email,$login,$psw);
		header('Location: registo_ok.php');
	}else{
		$_SESSION["mensagem"] = 'Ocorreu um erro volta a tentar';
		mysql_close($conexao);
		header('Location: registo_vis.php');
	}
}?>

