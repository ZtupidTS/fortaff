<?php

include 'utils.phpmailer.php';
include 'template.php';
include '../database/mysql.php';

// $to = "tiago_daraujo@hotmail.com";

// $body = templateNewUser(5, "asd", "123654789");

// $mail = createmailJO($to, "", $body);

// if ($mail->SendAndClose()) {
	// echo "true";
// } else {
	// echo "false";
// }

//echo "<pre>" . print_r($_SERVER) . "</pre>";
//echo  print_r($_SERVER) ;

echo dbDateTime(mktime(0,0,0,0,0,0));

?>