<?php

	function sendMessage($phoneTo, $textMessage) {
		$user = "noreplypw606";
		$password = "pw10606jo";
		$api_id = "3356658";
		$baseurl ="http://api.clickatell.com";
		
		$text = urlencode($textMessage);
		$to = $phoneTo;

		// auth call
		$url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id";

		// do auth call
		$ret = file($url);

		// explode our response. return string is on first line of the data returned
		$sess = explode(":",$ret[0]);
		if ($sess[0] == "OK") {

			$sess_id = trim($sess[1]); // remove any whitespace
			$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text";

			// do sendmsg call
			$ret = file($url);
			$send = explode(":",$ret[0]);

			if ($send[0] == "ID") {
				// echo "success\nmessage ID: ". $send[1];
				return true;
				
			} else {
				// echo "send message failed";
				return false;
			}
		} else {
			// echo "Authentication failure: ". $ret[0];
			return false;
		}
	}
?>