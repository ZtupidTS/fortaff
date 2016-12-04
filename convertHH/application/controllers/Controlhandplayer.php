<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controlhandplayer extends CI_Controller {
	
	
	public function mail($players)
	{
		shell_exec("echo -e 'to: stoploss59@gmail.com \nsubject: Players Without Hands \r\n\r\n Players: ".$players."' | /usr/sbin/ssmtp stoploss59@gmail.com -F'HH Sharing'");			
	}
	
	public function dayswithouthand()
	{
		//a ideia é de hoje menos 5 dia
		$this->load->helper('myfunction_helper');
		
		$all_players = $this->All_model->getplayersenable();
		//menos um dia por ser as hands do dia anterior que o soft foi convertido
		//as 8h, 12h, 16h, 20h
		$arr_todaylessday = todaysplitlessxday(DAYS_HANDS);
		$arr_today = todaysplit();
		
		$player = "";
		
		foreach($all_players as $elem_allplayers)
		{
			if(strtotime("now") < strtotime($elem_allplayers['expire_date']))
			{
				
				$have_hands = $this->All_model->getexisthand($arr_today,$arr_todaylessday,$elem_allplayers['id_player']);
				
				if(!$have_hands)
				{
					$player .= $elem_allplayers['nick_player']." ";		
				}
			}			
		}
		if($player != "")
		{
			/*echo $player;*/
			$this->mail($player);
		}
	}
}