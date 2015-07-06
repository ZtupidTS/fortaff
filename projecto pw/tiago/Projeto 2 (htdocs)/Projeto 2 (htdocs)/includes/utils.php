<?php
	include 'json.php';
	
	$use_proxy = false;
	
	function rootPath($path, $offset = 0) {
		$rev = strrev($_SERVER['SCRIPT_NAME']);
		$i = 0;
		$count = 0;
		while ($i = strpos($rev, '/', $i)) {
			$count += 1;
			$i += 1;
		}
		$count -= (1 + $offset);
		return str_repeat('../', $count) . $path;
	}
	
	// 1º Parametro => array
	// Restantes Parametros => strings
	function arrayContainsKeys()
	{
		$args = func_get_args();
		$args_length = func_num_args();
		
		$array = $args[0];
		
		for ($i = 1 ; $i < $args_length; $i++) {
			if (!isset($array[$args[$i]])) {
				return false;
			}
		}
		return true;
	}
	
	function setIsEquivalent($array1, $array2)
	{
		foreach ($array1 as $key => $value) {
			if (isset($array2[$key])) {
				if ($array1[$key] != $array2[$key]) {
					return false;
				}
			}
		}
		return true;
	}
	
	class TimeStamp
	{
		public $days;    
		public $hours;  
		public $mins;  
		public $secs;
		
		public $totaldays ;    
		public $totalhours;  
		public $totalmins;  
		public $totalsecs;
		
		public function __construct($start_date, $end_date)
		{
			$time = $end_date->getTimestamp() - $start_date->getTimestamp();
			
			$this->days = floor($time/60/60/24);    
			$this->hours = $time/60/60%24;  
			$this->mins = $time/60%60;  
			$this->secs = $time%60;
			
			$this->totaldays = $time/60/60/24;    
			$this->totalhours = $time/60/60;  
			$this->totalmins = $time/60;  
			$this->totalsecs = $time;
		}
		
	}
	
	function ujson_encode($object)
	{
		// $json = new Services_JSON();
		// return $json->encode($object);
		return json_encode($object);
	}
	
	function ujson_decode($object)
	{
		$json = new Services_json();
		return $json->decode($object);
		// return json_decode($object);
	}
	
	function printPayPalButton($code, $description, $amount)
	{
		$email = "noreplypw606@gmail.com";
?>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="business" value="<?= $email ?>">
		<input type="hidden" name="lc" value="PT">
		<input type="hidden" name="item_name" value="<?= $description ?>">
		<input type="hidden" name="item_number" value="<?= $code ?>">
		<input type="hidden" name="amount" value="<?= $amount ?>">
		<input type="hidden" name="currency_code" value="EUR">
		<input type="hidden" name="button_subtype" value="services">
		<input type="hidden" name="no_note" value="0">
		<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
		<input type="image" src="/pw606/img/ticket/16/C.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<!--
		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypalobjects.com/pt_BR/i/scr/pixel.gif" width="1" height="1">
		-->
		</form>
<?php
	}
	
	function getConfigProxyContext() {
		global $use_proxy;
		if ($use_proxy) {
			$opts = array('http' => array('proxy' => 'tcp://proxy.uminho.pt:3128', 'request_fulluri' => true));
			return stream_context_create($opts);
		}
	}
	
	function convert($amount, $from, $to)
	{
		$google_url = "http://www.google.com/ig/calculator?hl=en&q=" . $amount . $from . "=?" . $to;
	 
		$result = file_get_contents($google_url, false, getConfigProxyContext());
		return $result;
	}
	
?>