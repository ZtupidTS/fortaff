<?
//Includes
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);


// PHP 4.1

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

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
		// check the payment_status is Completed
		// check that txn_id has not been previously processed
		// check that receiver_email is your Primary PayPal email
		// check that payment_amount/payment_currency are correct
		// process payment
			
			$fields = array();
			$fields['id'] = -1;
			$fields['item_name'] = dbString($_POST['item_name']);
			$fields['item_number'] = dbString($_POST['item_number']);
			$fields['payment_status'] = dbString($_POST['payment_status']);
			$fields['mc_gross'] = dbString($_POST['mc_gross']);
			$fields['mc_currency'] = dbString($_POST['mc_currency']);
			$fields['txn_id'] = dbString($_POST['txn_id']);
			$fields['receiver_email'] = dbString($_POST['receiver_email']);
			$fields['payer_email'] = dbString($_POST['payer_email']);
			
			//Cria o ficheiro de log
			file_put_contents('log/ok-' . date('Ymd-His-u-D') . '.log', print_r($_POST, true));
			
			//Insere na tabela de logs dos pagamentos paypal o pagamento recebido.
			paypalInsert($fields);
			
			//Confirma o bilhete como pago.
			if (strtolower($fields['payment_status']) == 'completed') {
				bilheteUpdateStatus($_POST['item_number'], 'P')
			}
			
		} else if (strcmp ($res, "INVALID") == 0) {
		// log for manual investigation
		
			//Cria o ficheiro de log
			file_put_contents('log/err-' . date('Ymd-His-u-D') . '.log', print_r($_POST, true));
		}
		
	}
	fclose ($fp);
}

//Includes
	include_once rootPath('includes/sijo/master_footer.php', 1);
	
?>
