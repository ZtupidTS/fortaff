<?php
	include 'json.php';
	
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
		$json = new Services_JSON();
		return $json->encode($object);
	}
	
?>