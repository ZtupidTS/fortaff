<?php
session_start();
include '../includes/ligacao.php';
$dados_tipo = mysql_fetch_array(mysql_query("SELECT * FROM informacao_diversas WHERE informacao = '$_POST[pr_ou_ev]'"));
#$dados_reco = mysql_fetch_array(mysql_query("SELECT * FROM informacao_diversas WHERE informacao = '$_POST[tipo]'"));
mysql_query("INSERT INTO reserva_compra (tipo, id_vis, quant, cod_sessao, re_ou_com) VALUES ('$dados_tipo[id]', '$_SESSION[id_vis]', '$_POST[qtd]', '$_POST[cod]', 'Reserva')"); 

#ultimo id inserido
$numero = mysql_insert_id();

#insere em prova ou evento
if($_POST['pr_ou_ev'] == 'prova')
{
	mysql_query("UPDATE prova SET lugares_reservados = (lugares_reservados + '$_POST[qtd]') WHERE cod_prova = '$_POST[cod]'");
	$dados_nometipo = mysql_fetch_array(mysql_query("SELECT * FROM prova WHERE cod_prova = '$_POST[cod]'"));
	$dados_mod = mysql_fetch_array(mysql_query("SELECT * FROM modalidade WHERE cod_modalidade = '$dados_nometipo[cod_modalidade]'"));
	$nometipo = 'Prova de '.$dados_mod['nome_modalidade'];
	$url = 'provas.php';
}else{
	mysql_query("UPDATE evento SET lugares_reservados = (lugares_reservados + '$_POST[qtd]') WHERE cod_evento = '$_POST[cod]'");
	$dados_nometipo = mysql_fetch_array(mysql_query("SELECT * FROM evento WHERE cod_evento = '$_POST[cod]'"));
	$nometipo = $dados_nometipo['designacao'].' de '.$dados_nometipo['descricao'];
	$url = 'eventos.php';
}

#envia o email
require_once '../funcao/funcao_formulario.php';
$mail = enviamail_re_co($_SESSION['email_vis'],'Reserva',$_SESSION['nome_vis'], $_POST['qtd'], $nometipo, $numero);

#envia o sms
if(isset($_POST['sms']))
{
	require_once '../sms/sendSMSclass.php';
	$gsm = array();
	$telemovel = (351 * 1000000000)+$_SESSION['telemovel_vis'];
	#echo $telemovel;
	$gsm[0] = $telemovel;
	$SENDSMS = new SendSMSclass();
	$messagetext = 'Efectou a reserva com o numero '.$numero;
	$response = $SENDSMS->SendSMS($messagetext,$gsm);	
	#echo 'resposta: '.htmlentities($response, ENT_QUOTES);
	#print_r($response);
}
#envia do texto a enviar ao utilizador pela essa variável
$_SESSION["mensagem"] = 'Compra efectuada com sucesso, verifica a sua caixa de correio';
mysql_close($conexao);
header('Location: '.$url);
?>