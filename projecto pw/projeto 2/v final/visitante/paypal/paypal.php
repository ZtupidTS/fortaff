<?php 
// read the post from PayPal system and add 'cmd'
session_start();
include '../../includes/ligacao.php';

$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('https://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
	if ($payment_status == "Completed")
	{
		#$_SESSION['mensagem'] = 'Pagamento efetuado com sucesso, obrigado.';
		$dados_array = explode(":", $item_name);
		// $fp = fopen('test.txt', 'w+');
		// fwrite($fp, $dados_array[0]);
		// fwrite($fp, $dados_array[1]);
		// fwrite($fp, $dados_array[2]);
		// fwrite($fp, $dados_array[3]);
		// fclose($fp);
		
		$dados_tipo = mysql_fetch_array(mysql_query("SELECT * FROM informacao_diversas WHERE informacao = '$dados_array[0]'"));
		$dados_vis = mysql_fetch_array(mysql_query("SELECT * FROM visitante WHERE id_vis = '$dados_array[3]'"));
		$compra = 'Compra';
		mysql_query("INSERT INTO reserva_compra (tipo, id_vis, quant, cod_sessao, re_ou_com) VALUES ('$dados_tipo[id]', '$dados_vis[id_visitante]', '$item_number', '$dados_array[1]', '$compra')"); 
		#ultimo id inserido
		$numero = mysql_insert_id();
		if($dados_array[0] == 'prova')
		{
			mysql_query("UPDATE prova SET lugares_reservados = (lugares_reservados + '$item_number') WHERE cod_prova = '$dados_array[1]'");
			$dados_nometipo = mysql_fetch_array(mysql_query("SELECT * FROM prova WHERE cod_prova = '$dados_array[1]'"));
			$dados_mod = mysql_fetch_array(mysql_query("SELECT * FROM modalidade WHERE cod_modalidade = '$dados_nometipo[cod_modalidade]'"));
			$nometipo = 'Prova de '.$dados_mod['nome_modalidade'];
		}else{
			mysql_query("UPDATE evento SET lugares_reservados = (lugares_reservados + '$item_number') WHERE cod_evento = '$dados_array[1]'");
			$dados_nometipo = mysql_fetch_array(mysql_query("SELECT * FROM evento WHERE cod_evento = '$dados_array[1]'"));
			$nometipo = $dados_nometipo['designacao'].' de '.$dados_nometipo['descricao'];
		}
		require_once '../../funcao/funcao_formulario.php';
		$mail = enviamail_re_co($dados_vis['email'],$compra,$dados_vis['nome'], $item_number, $nometipo, $numero);
		require_once '../../sms/sendSMSclass.php';
		$gsm = array();
		$telemovel = (351 * 1000000000)+$dados_vis['telemovel'];
		#echo $telemovel;
		$gsm[0] = $telemovel;
		$SENDSMS = new SendSMSclass();
		$messagetext = 'Efectou a seguinte compra com o numero '.$numero;
		$response = $SENDSMS->SendSMS($messagetext,$gsm);	
		#echo 'resposta: '.htmlentities($response, ENT_QUOTES);
		#print_r($response);
	}else{
		#$_SESSION['mensagem'] = 'Pagamento não foi efetuado, volta a tentar.';
	}
	
}
else if (strcmp ($res, "INVALID") == 0) {
	#$_SESSION['mensagem'] = 'Pagamento não foi efetuado, volta a tentar.';
}
}
fclose ($fp);
}
?>
